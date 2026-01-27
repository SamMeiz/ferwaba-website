<?php require_once __DIR__ . '/../includes/header.php'; ?>
<br><br><br><br><br><br>


<!-- 🎨 HERO / BANNER -->
<section class="ferwaba-hero" 
         style="position:relative;width:100%;height:300px;
                display:flex;align-items:center;justify-content:center;
                background:#fff; border-radius:12px; margin:20px auto; max-width:1200px;">
  <div style="text-align:center;max-width:700px;">
    <h1 style="font-size:42px;font-weight:800;margin-bottom:10px; color:#1A2A44;">Welcome to Ferwaba & Visit Rwanda Collection</h1>
    <p style="font-size:12px; color:#1A2A44;">Official merchandise celebrating Rwandan basketball pride</p>
  </div>
</section>



<!-- 🛒 SHOP ITEMS GRID -->
<section id="ferwaba-shop" style="padding:40px 20px; background:linear-gradient(to bottom right, #1A2A44, #2E4A3C);">
  <div class="grid col-3" style="gap:20px;max-width:1200px;margin:auto;">
    <?php
    $stmt = $mysqli->prepare("SELECT id,name,price,image,gender FROM shop_items WHERE is_active=1 AND category='Ferwaba and Visit Rwanda' ORDER BY created_at DESC");
    $stmt->execute();
    $res = $stmt->get_result();

    if($res->num_rows === 0) {
      echo "<p style='text-align:center;width:100%;color:#fff;'>No Ferwaba & Visit Rwanda items found.</p>";
    }

    while($i = $res->fetch_assoc()): ?>
      <div class="card">
        <?php if($i['image']): ?>
          <img src="admin/uploads/<?php echo sanitize($i['image']); ?>" alt="<?php echo sanitize($i['name']); ?>">
        <?php endif; ?>
        <div class="overlay">
          <h3><?php echo sanitize($i['name']); ?></h3>
          <div style="margin-top:4px;font-weight:700;">RWF <?php echo number_format((float)$i['price'],2); ?></div>
          <a href="item.php?id=<?php echo $i['id']; ?>" class="buy-btn">Buy Now</a>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</section>

<style>
/* Body background matches main Ferwaba theme */
body {
  background: linear-gradient(to bottom right, #1A2A44, #2E4A3C);
  color:#fff;
}

/* Grid */
.grid.col-3 { display:grid; grid-template-columns:repeat(3,1fr); gap:20px; }
@media(max-width:900px){ .grid.col-3{ grid-template-columns:repeat(2,1fr);} }
@media(max-width:600px){ .grid.col-3{ grid-template-columns:1fr;} }

/* Cards */
.card {
  position:relative;
  overflow:hidden;
  border:none;
  border-radius:10px;
  background:transparent;
  cursor:pointer;
}
.card img {
  width:100%;
  height:260px;
  object-fit:contain;
  display:block;
  transition:transform 0.4s ease, filter 0.4s ease;
}
.card:hover img { transform:scale(1.05); filter:brightness(0.9); }
.overlay {
  position:absolute; inset:0;
  display:flex; flex-direction:column;
  justify-content:center; align-items:center;
  opacity:0; transition:opacity 0.4s ease;
  color:#fff;
  text-align:center;
}
.card:hover .overlay { opacity:1; }
.overlay h3 { font-size:20px;font-weight:700;margin-bottom:6px;color:#fff; }
.buy-btn {
  display:inline-block;margin-top:6px;
  background:#111;color:#fff;padding:8px 18px;
  border-radius:25px;text-decoration:none;font-weight:600;
  transition:all 0.2s ease;
}
.buy-btn:hover { background:#333; }

/* Hero text */
.ferwaba-hero h1, .ferwaba-hero p {
  color:#fff;
}

/* Button in hero */
.ferwaba-hero .btn {
  display:inline-block;
  background:#111;
  color:#fff;
  padding:10px 18px;
  border-radius:8px;
  text-decoration:none;
  font-weight:600;
  margin-top:16px;
  transition:all 0.3s ease;
}
.ferwaba-hero .btn:hover { filter:brightness(0.85); transform:translateY(-2px); }
</style>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
