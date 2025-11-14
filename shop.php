<?php require_once __DIR__ . '/includes/header.php'; ?>
<br><br><br><br>

<!-- 🏀 HERO SECTION -->
<section class="shop-hero" 
  style="position:relative;width:100%;height:600px;
         background:url('img/ferwaba.jpg') center/cover no-repeat;">
  <div style="position:absolute;inset:0;background:rgba(0,0,0,0.45);"></div>
  <div style="position:relative;z-index:2;color:#fff;padding:80px 60px;max-width:700px;">
    <h1 style="font-size:46px;font-weight:800;">Ferwaba & Visit Rwanda Collection</h1>
    <h2 style="font-size:24px;margin-top:-10px;">Official merchandise celebrating Rwandan basketball pride</h2>
    <a href="ferwaba-shop.php" 
       class="btn" 
       style="margin-top:20px;background:#E53935;color:#fff;
              padding:10px 24px;border-radius:30px;text-decoration:none;">
      Shop Now
    </a>
  </div>
</section>

<br><br>

<!-- 🧢 SHOP BY CATEGORY -->
<section id="categories" style="text-align:center;margin-bottom:60px;">
  <h2 style="font-size:28px;margin-bottom:30px;">Shop by Category</h2>
  <div class="grid col-3" style="gap:20px;max-width:1000px;margin:auto;">
    <a href="?category=Jerseys" class="card" style="text-decoration:none;color:inherit;">
      <img src="img/jersey.jpg" alt="Jerseys" style="width:100%;height:240px;object-fit:cover;border-radius:8px;">
      <h3 style="margin-top:10px;">Jerseys</h3>
    </a>
    <a href="?category=Kits" class="card" style="text-decoration:none;color:inherit;">
      <img src="img/gear.jpg" alt="Kits" style="width:100%;height:240px;object-fit:cover;border-radius:8px;">
      <h3 style="margin-top:10px;">Kits</h3>
    </a>
    <a href="?category=Gear" class="card" style="text-decoration:none;color:inherit;">
      <img src="img/kit.jpg" alt="Gear" style="width:100%;height:240px;object-fit:cover;border-radius:8px;">
      <h3 style="margin-top:10px;">Gear</h3>
    </a>
  </div>
</section>

<!-- 🏀 SHOP BY TEAM -->
<section id="teams" style="margin-bottom:60px;">
  <h2 style="text-align:center;font-size:28px;margin-bottom:20px;">Shop by Team</h2>
  <div style="display:flex;overflow-x:auto;gap:16px;padding:10px 20px;scrollbar-width:none;">
    <?php
    $teams = $mysqli->query("SELECT id, name, logo FROM teams ORDER BY name ASC");
    while($t = $teams->fetch_assoc()):
      $teamId = $t['id'];
      $teamName = sanitize($t['name']);
      $teamLogo = !empty($t['logo']) ? "admin/uploads/{$t['logo']}" : "";
    ?>
      <div class="team-filter" 
           data-team="<?php echo $teamId; ?>" 
           style="flex:0 0 auto;text-align:center;cursor:pointer;">
        <div style="width:100px;height:100px;border-radius:50%;overflow:hidden;border:2px solid #eee;margin:auto;">
          <?php if($teamLogo): ?>
            <img src="<?php echo $teamLogo; ?>" alt="logo" style="width:100%;height:100%;object-fit:cover;">
          <?php else: ?>
            <div style="background:#ddd;width:100%;height:100%;"></div>
          <?php endif; ?>
        </div>
        <p style="font-size:14px;margin-top:8px;"><?php echo $teamName; ?></p>
      </div>
    <?php endwhile; ?>
  </div>
</section>

<!-- 🚹🚺 SHOP SECTION -->
<section id="shop-section" style="padding:0 20px;">
  <div class="section-title" style="text-align:center;">
    <h2>Shop</h2>
 
    <!-- Filter Form -->
    <form method="get" style="max-width:700px;margin:20px auto 40px auto;display:grid;grid-template-columns:repeat(2,1fr);gap:8px;">
      <!-- Top row: two selects -->
      <select name="category" onchange="this.form.submit()" style="padding:8px;border-radius:6px;border:1px solid #ccc;width:100%;">
        <option value="">All Categories</option>
        <option value="Jerseys" <?php echo (($_GET['category'] ?? '')==='Jerseys')?'selected':''; ?>>Jerseys</option>
        <option value="Kits" <?php echo (($_GET['category'] ?? '')==='Kits')?'selected':''; ?>>Kits</option>
        <option value="Gear" <?php echo (($_GET['category'] ?? '')==='Gear')?'selected':''; ?>>Gear</option>
        <option value="Ferwaba and Visit Rwanda" <?php echo (($_GET['category'] ?? '')==='Ferwaba and Visit Rwanda')?'selected':''; ?>>Ferwaba & Visit Rwanda</option>
      </select>

      <select name="gender" onchange="this.form.submit()" style="padding:8px;border-radius:6px;border:1px solid #ccc;width:100%;">
        <option value="">All Genders</option>
        <option value="Men" <?php echo (($_GET['gender'] ?? '')==='Men')?'selected':''; ?>>Men</option>
        <option value="Women" <?php echo (($_GET['gender'] ?? '')==='Women')?'selected':''; ?>>Women</option>
        <option value="Unisex" <?php echo (($_GET['gender'] ?? '')==='Unisex')?'selected':''; ?>>Unisex</option>
      </select>
    </form>
  </div>

  <!-- 🧥 SHOP ITEMS GRID -->
  <div class="grid col-3" style="gap:20px;max-width:1200px;margin:auto;">
    <?php
    $where = ' WHERE is_active=1';
    $types = '';
    $params = [];

    if(!empty($_GET['category'])) { $where .= ' AND category=?'; $types.='s'; $params[]=$_GET['category']; }
    if(!empty($_GET['gender'])) { $where .= ' AND gender=?'; $types.='s'; $params[]=$_GET['gender']; }
    if(!empty($_GET['team'])) { $where .= ' AND team_id=?'; $types.='i'; $params[]=(int)$_GET['team']; }

    $stmt = $mysqli->prepare("SELECT id,name,price,image,category,gender FROM shop_items $where ORDER BY created_at DESC, id DESC");
    if($types) $stmt->bind_param($types, ...$params);
    $stmt->execute(); 
    $res = $stmt->get_result();

    if($res->num_rows === 0) {
      echo "<p style='text-align:center;width:100%;'>No items found.</p>";
    }

    while($i = $res->fetch_assoc()): ?>
      <div class="card">
        <?php if($i['image']): ?>
          <img src="admin/uploads/<?php echo sanitize($i['image']); ?>" alt="<?php echo sanitize($i['name']); ?>">
        <?php endif; ?>
        <div class="overlay">
          <h3><?php echo sanitize($i['name']); ?></h3>
          <p style="margin:4px 0;font-size:14px;"><?php echo sanitize($i['category']); ?> – <?php echo sanitize($i['gender']); ?></p>
          <div style="margin:6px 0;font-weight:700;">RWF <?php echo number_format((float)$i['price'],2); ?></div>
          <a href="item.php?id=<?php echo $i['id']; ?>" class="buy-btn">Buy Now</a>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</section>

<style>
/* Shop Items Grid */
.grid.col-3 { display:grid; grid-template-columns:repeat(3,1fr); gap:20px; }
@media(max-width:900px){ .grid.col-3{ grid-template-columns:repeat(2,1fr);} }
@media(max-width:600px){ .grid.col-3{ grid-template-columns:1fr;} }

/* Card Styling */
.card {
  position:relative;
  overflow:hidden;
  border-radius:10px;
  cursor:pointer;
}
.card img {
  width:100%;
  height:260px;
  object-fit:cover;
  display:block;
  transition:transform 0.4s ease, filter 0.4s ease;
}
.card .overlay {
  position:absolute;
  inset:0;
  display:flex;
  flex-direction:column;
  justify-content:center;
  align-items:center;
  text-align:center;
  opacity:0;
  transition:opacity 0.4s ease;
  color:#fff;
  background:transparent;
}
.card:hover img {
  transform:scale(1.05);
  filter:brightness(0.7);
}
.card:hover .overlay {
  opacity:1;
}
.overlay h3 {
  font-size:20px;
  font-weight:700;
  margin-bottom:8px;
  color:#fff;
}
.buy-btn {
  display:inline-block;
  margin-top:8px;
  background:#E53935;
  color:#fff;
  padding:8px 18px;
  border-radius:25px;
  text-decoration:none;
  font-weight:600;
  transition:background 0.3s ease;
}
.buy-btn:hover {
  background:#ff4444;
}
</style>

<script>
// 🧩 Team filter auto-submit
const teamFilters = document.querySelectorAll('.team-filter');
teamFilters.forEach(filter => {
  filter.addEventListener('click', () => {
    const teamId = filter.getAttribute('data-team');
    const urlParams = new URLSearchParams(window.location.search);
    urlParams.set('team', teamId);
    window.location.search = urlParams.toString();
  });
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
