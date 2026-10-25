<?php
session_start(); require_once 'db.php';
function esc($v){return htmlspecialchars((string)$v,ENT_QUOTES,'UTF-8');}
$message='';$newOrder=null;
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['cart_json'])){
 $cart=json_decode($_POST['cart_json'],true);$payment=$_POST['payment_method']??'Cash';
 if(!in_array($payment,['Cash','GCash','Card'],true))$payment='Cash';
 if(!is_array($cart)||!count($cart))$message='Your cart is empty. Please add items first.';
 else {
  try{
   $conn->begin_transaction();$items=[];$total=0;
   foreach($cart as $item){
    $pid=(int)($item['product_id']??0);$qty=max(1,min(50,(int)($item['qty']??1)));
    $st=$conn->prepare("SELECT product_name,price FROM products WHERE product_id=? AND is_available=1");$st->bind_param('i',$pid);$st->execute();$p=$st->get_result()->fetch_assoc();$st->close();
    if(!$p)throw new Exception('A selected product is unavailable. Please review your cart.');
    $variantId=(int)($item['variant_id']??0);$custom='Regular';$price=(float)$p['price'];
    if($variantId>0){$st=$conn->prepare("SELECT size_name,price FROM product_variants WHERE variant_id=? AND product_id=? AND is_available=1");$st->bind_param('ii',$variantId,$pid);$st->execute();$v=$st->get_result()->fetch_assoc();$st->close();if(!$v)throw new Exception('A selected size is unavailable. Please review your cart.');$custom=$v['size_name'];$price=(float)$v['price'];}
    $items[]=['id'=>$pid,'name'=>$p['product_name'],'qty'=>$qty,'price'=>$price,'subtotal'=>$price*$qty,'custom'=>$custom];$total+=$price*$qty;
   }
   $next=(int)($conn->query("SELECT COALESCE(MAX(order_number),1000)+1 AS n FROM orders")->fetch_assoc()['n']);
   $st=$conn->prepare("INSERT INTO orders (order_number,total_amount,payment_method,payment_status,order_status) VALUES (?,?,?,'Pending','Pending')");$st->bind_param('ids',$next,$total,$payment);$st->execute();$orderId=$conn->insert_id;$st->close();
   $st=$conn->prepare("INSERT INTO order_items (order_id,product_id,quantity,unit_price,subtotal,customization) VALUES (?,?,?,?,?,?)");
   foreach($items as $it){$st->bind_param('iiidds',$orderId,$it['id'],$it['qty'],$it['price'],$it['subtotal'],$it['custom']);$st->execute();}$st->close();
   $st=$conn->prepare("INSERT INTO order_status_history (order_id,status) VALUES (?,'Pending')");$st->bind_param('i',$orderId);$st->execute();$st->close();
   $conn->commit();$newOrder=['number'=>$next,'total'=>$total,'payment'=>$payment];$message='Order placed successfully!'; 
  }catch(Throwable $e){$conn->rollback();$message=$e->getMessage();}
 }
}
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Checkout | Brew Eua's</title><link rel="stylesheet" href="kiosk.css"></head><body>
<header class="top"><a class="brand" href="index.php"><img src="logo.jpg" alt="Logo"><span>Brew Eua's<small>BREW & BITES</small></span></a><nav class="nav"><a href="index.php">Home</a><a href="menu.php">Menu</a><a class="active" href="order.php">Checkout</a><a href="staff.php">Staff</a><a href="admin.php">Admin</a></nav></header><main class="wrap"><h1 class="section-title">Review your order</h1>
<?php if($newOrder): ?><div class="success"><h2>Thank you for ordering!</h2><p>Your order number is <strong>#<?= (int)$newOrder['number'] ?></strong>.</p><p>Total: <strong>₱<?= number_format($newOrder['total'],2) ?></strong> · Payment: <?= esc($newOrder['payment']) ?> (Pending)</p><p>Show your order number to the staff. Payment is not processed online by this demo.</p><a class="btn" href="menu.php" onclick="localStorage.removeItem('brewEuasCart')">Start another order</a></div>
<?php else: ?><?php if($message): ?><div class="panel"><?= esc($message) ?></div><?php endif ?><div class="panel"><div id="cartList"></div><div class="row" style="margin-top:20px"><strong>Total</strong><span class="total" id="total">₱0.00</span></div></div>
<form method="post" id="checkoutForm" class="panel"><input type="hidden" name="cart_json" id="cartJson"><div class="form-grid"><div><label for="payment">Payment method</label><select id="payment" name="payment_method"><option>Cash</option><option>GCash</option><option>Card</option></select></div></div><p class="small">Choosing GCash or Card records the selected payment method only. This demo does not collect payment details or process online payments.</p><div class="row"><a class="btn light" href="menu.php">← Back to menu</a><button class="btn" type="submit" id="placeOrder">Place order</button></div></form><?php endif ?>
</main><script>
const cartKey='brewEuasCart';let cart=JSON.parse(localStorage.getItem(cartKey)||'[]');
function fmt(n){return '₱'+Number(n).toFixed(2)}
function showCart(){let box=document.getElementById('cartList');if(!box)return; if(!cart.length){box.innerHTML='<div class="empty">Your cart is empty. <a href="menu.php"><u>Browse the menu</u></a>.</div>';document.getElementById('placeOrder').disabled=true;document.getElementById('placeOrder').style.opacity='.5';}else{box.innerHTML=cart.map((i,idx)=>`<div class="row" style="padding:12px 0;border-bottom:1px solid #eadfce"><div><strong>${String(i.name).replace(/[&<>"]/g,'')}</strong><div class="muted">${String(i.size||'Regular')} · ${fmt(i.price)} each</div><div class="row"><button type="button" class="btn light" onclick="changeQty(${idx},-1)">−</button><span>${i.qty}</span><button type="button" class="btn light" onclick="changeQty(${idx},1)">+</button><button type="button" class="btn danger" onclick="removeItem(${idx})">Remove</button></div></div><strong>${fmt(i.price*i.qty)}</strong></div>`).join('');}let total=cart.reduce((s,i)=>s+i.price*i.qty,0);document.getElementById('total').textContent=fmt(total);document.getElementById('cartJson').value=JSON.stringify(cart)}
function changeQty(i,d){cart[i].qty+=d;if(cart[i].qty<1)cart.splice(i,1);localStorage.setItem(cartKey,JSON.stringify(cart));showCart()}function removeItem(i){cart.splice(i,1);localStorage.setItem(cartKey,JSON.stringify(cart));showCart()}
document.getElementById('checkoutForm')?.addEventListener('submit',e=>{if(!cart.length){e.preventDefault();return}document.getElementById('cartJson').value=JSON.stringify(cart)});showCart();
</script></body></html>