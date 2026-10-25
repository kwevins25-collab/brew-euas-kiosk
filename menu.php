<?php
require_once 'db.php';
function esc($v){return htmlspecialchars((string)$v,ENT_QUOTES,'UTF-8');}
$cats=$conn->query("SELECT category_id,category_name FROM categories ORDER BY category_id");
$selected=isset($_GET['category'])?(int)$_GET['category']:0;
$sql="SELECT p.product_id,p.product_name,p.description,p.price,p.category_id,c.category_name FROM products p JOIN categories c ON c.category_id=p.category_id WHERE p.is_available=1";
if($selected>0){$sql.=" AND p.category_id=".$selected;}
$sql.=" ORDER BY c.category_id,p.product_name";
$res=$conn->query($sql);
$products=[]; if($res) while($p=$res->fetch_assoc()){
 $p['variants']=[];$vid=(int)$p['product_id'];
 $vr=$conn->query("SELECT variant_id,size_name,price FROM product_variants WHERE product_id=$vid AND is_available=1 ORDER BY variant_id");
 if($vr) while($v=$vr->fetch_assoc()) $p['variants'][]=$v;
 $products[]=$p;
}
$icons=[1=>'☕',2=>'🧋',3=>'🍟',4=>'🥤',5=>'🍱',6=>'🧊',7=>'🥐'];
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Menu | Brew Eua's</title><link rel="stylesheet" href="kiosk.css"></head><body>
<header class="top"><a class="brand" href="index.php"><img src="logo.jpg" alt="Logo"><span>Brew Eua's<small>BREW & BITES</small></span></a><nav class="nav"><a href="index.php">Home</a><a class="active" href="menu.php">Menu</a><a href="order.php">Checkout (<span id="navCount">0</span>)</a><a href="staff.php">Staff</a><a href="admin.php">Admin</a></nav></header>
<main class="wrap"><section class="hero"><h1>Find your favorite.</h1><p>Choose your drink or bite, customize your size, then add it to your order.</p></section>
<h2 class="section-title">Browse categories</h2><div class="categories"><a class="chip <?= $selected===0?'active':'' ?>" href="menu.php">All items</a><?php if($cats) while($c=$cats->fetch_assoc()): ?><a class="chip <?= $selected===(int)$c['category_id']?'active':'' ?>" href="menu.php?category=<?= (int)$c['category_id'] ?>"><?= esc($c['category_name']) ?></a><?php endwhile ?></div>
<h2 class="section-title"><?= $selected ? 'Selected category' : 'Our menu' ?></h2>
<div class="grid"><?php foreach($products as $p): ?><article class="card"><div class="product-art"><?= $icons[(int)$p['category_id']]??'🍴' ?></div><div class="card-body"><h3><?= esc($p['product_name']) ?></h3><div class="muted"><?= esc($p['description']) ?></div>
<?php if(count($p['variants'])): ?><label for="v<?= (int)$p['product_id'] ?>">Size / option</label><select id="v<?= (int)$p['product_id'] ?>" class="variant"><?php foreach($p['variants'] as $v): ?><option value="<?= (int)$v['variant_id'] ?>" data-price="<?= esc($v['price']) ?>"><?= esc($v['size_name']) ?> — ₱<?= number_format((float)$v['price'],2) ?></option><?php endforeach ?></select><?php else: ?><div class="price">₱<?= number_format((float)$p['price'],2) ?></div><?php endif ?>
<button class="btn add" data-id="<?= (int)$p['product_id'] ?>" data-name="<?= esc($p['product_name']) ?>" data-price="<?= esc($p['price']) ?>" <?= count($p['variants'])?'data-variants="1"':'' ?>>＋ Add to order</button></div></article><?php endforeach ?></div>
<div class="panel row"><div><strong><span id="cartCount">0</span> items in your order</strong><div class="muted">Your cart is saved in this browser until checkout.</div></div><div><span class="total" id="cartTotal">₱0.00</span> <a class="btn" href="order.php">Review order →</a></div></div>
</main><script>
const key='brewEuasCart';
let cart=JSON.parse(localStorage.getItem(key)||'[]');
function render(){let count=cart.reduce((s,i)=>s+i.qty,0),total=cart.reduce((s,i)=>s+i.price*i.qty,0);document.getElementById('cartCount').textContent=count;document.getElementById('navCount').textContent=count;document.getElementById('cartTotal').textContent='₱'+total.toFixed(2);localStorage.setItem(key,JSON.stringify(cart))}
document.querySelectorAll('.add').forEach(b=>b.addEventListener('click',()=>{let variant=b.closest('.card-body').querySelector('.variant');let vid=variant?parseInt(variant.value):0;let opt=variant?variant.selectedOptions[0]:null;let price=opt?parseFloat(opt.dataset.price):parseFloat(b.dataset.price);let size=opt?opt.textContent.split(' — ')[0]:'Regular';let existing=cart.find(i=>i.product_id===parseInt(b.dataset.id)&&i.variant_id===vid);if(existing)existing.qty++;else cart.push({product_id:parseInt(b.dataset.id),variant_id:vid,name:b.dataset.name,size,price,qty:1});render();let old=b.textContent;b.textContent='✓ Added';setTimeout(()=>b.textContent=old,700)}));render();
</script></body></html>