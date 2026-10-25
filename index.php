<?php
require_once 'db.php';
$cats=$conn->query("SELECT category_id, category_name FROM categories ORDER BY category_id");
$featured=$conn->query("SELECT product_id,product_name,description,price,category_id FROM products WHERE is_available=1 ORDER BY product_id LIMIT 8");
function esc($v){return htmlspecialchars((string)$v,ENT_QUOTES,'UTF-8');}
$icons=['☕','🧋','🥤','🍓','🧊','🍱','🥐'];
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Brew Eua's | Self-Order Kiosk</title><link rel="stylesheet" href="kiosk.css"></head><body>
<header class="top"><a class="brand" href="index.php"><img src="logo.jpg" alt="Brew Eua's logo"><span>Brew Eua's<small>BREW & BITES</small></span></a><nav class="nav"><a class="active" href="index.php">Home</a><a href="menu.php">Menu</a><a href="order.php">Checkout</a><a href="staff.php">Staff</a><a href="admin.php">Admin</a></nav></header>
<main class="wrap"><section class="hero"><h1>Your daily dose of flavor.</h1><p>Fresh coffee, refreshing drinks, and satisfying bites — made for your day.</p><div><a class="btn light" href="menu.php">Start Your Order →</a></div></section>
<h2 class="section-title">Explore our menu</h2><div class="categories"><?php if($cats) while($c=$cats->fetch_assoc()): ?><a class="chip" href="menu.php?category=<?= (int)$c['category_id'] ?>"><?= esc($c['category_name']) ?></a><?php endwhile ?></div>
<h2 class="section-title">Customer favorites</h2><div class="grid"><?php if($featured) while($p=$featured->fetch_assoc()): ?><article class="card"><div class="product-art"><?= $icons[((int)$p['category_id']-1)%count($icons)] ?></div><div class="card-body"><h3><?= esc($p['product_name']) ?></h3><div class="muted"><?= esc($p['description']) ?></div><div class="price">₱<?= number_format((float)$p['price'],2) ?></div><a class="btn" href="menu.php">Choose options</a></div></article><?php endwhile ?></div>
</main><footer class="footer">Brew Eua’s Brew & Bites · Great Coffee · Fresh Bites · Good Vibes</footer></body></html>