<?php require_once __DIR__ . '/../includes/header.php'; ?><br><br>

<style>
  /* Professional E-Commerce Shop Styling */
  .shop-page-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 40px 20px;
    font-family: 'Inter', sans-serif;
  }

  /* Shop Hero */
  .shop-premium-hero {
    height: 500px;
    background: linear-gradient(rgba(15, 23, 42, 0.7), rgba(15, 23, 42, 0.7)), url('../img/ferwaba.jpg');
    background-size: cover;
    background-position: center;
    border-radius: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    color: #fff;
    margin-bottom: 60px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
  }

  .shop-hero-content h1 {
    font-size: 56px;
    font-weight: 900;
    letter-spacing: -2px;
    margin-bottom: 15px;
  }

  .shop-hero-content p {
    font-size: 20px;
    opacity: 0.9;
    max-width: 600px;
    margin: 0 auto 30px;
  }

  /* Category Grid */
  .shop-cat-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
    margin-bottom: 80px;
  }

  .shop-cat-card {
    position: relative;
    height: 300px;
    border-radius: 20px;
    overflow: hidden;
    text-decoration: none;
    color: #fff;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
  }

  .shop-cat-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s ease;
  }

  .shop-cat-card:hover img {
    transform: scale(1.1);
  }

  .shop-cat-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    padding: 30px;
  }

  .shop-cat-overlay h3 {
    font-size: 24px;
    font-weight: 800;
    margin-bottom: 5px;
  }

  .shop-cat-overlay span {
    font-size: 14px;
    font-weight: 600;
    color: #fbbf24;
    text-transform: uppercase;
    letter-spacing: 1px;
  }

  /* Filter Section */
  .shop-controls {
    background: #fff;
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    margin-bottom: 50px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border: 1px solid #f1f5f9;
  }

  .shop-filters {
    display: flex;
    gap: 20px;
  }

  .shop-select {
    padding: 12px 20px;
    border-radius: 12px;
    border: 2px solid #e2e8f0;
    font-weight: 600;
    color: #1e293b;
    background: #f8fafc;
    min-width: 180px;
  }

  /* Product Grid */
  .product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 40px;
  }

  .product-card {
    background: #fff;
    border-radius: 24px;
    overflow: hidden;
    border: 1px solid #f1f5f9;
    transition: all 0.4s ease;
  }

  .product-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
  }

  .product-img-wrapper {
    height: 350px;
    position: relative;
    overflow: hidden;
  }

  .product-img-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s ease;
  }

  .product-card:hover .product-img-wrapper img {
    transform: scale(1.05);
  }

  .product-badge {
    position: absolute;
    top: 20px;
    left: 20px;
    background: #1a365d;
    color: #fff;
    padding: 6px 14px;
    border-radius: 10px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
  }

  .product-info {
    padding: 25px;
  }

  .product-category {
    font-size: 12px;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    margin-bottom: 10px;
  }

  .product-title {
    font-size: 20px;
    font-weight: 800;
    color: #1a365d;
    margin-bottom: 15px;
    line-height: 1.3;
  }

  .product-price-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .product-price {
    font-size: 22px;
    font-weight: 900;
    color: #1a365d;
  }

  .product-btn {
    background: #fbbf24;
    color: #1a365d;
    width: 45px;
    height: 45px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 4px 10px rgba(251, 191, 36, 0.3);
  }

  .product-btn:hover {
    background: #1a365d;
    color: #fff;
  }

  @media (max-width: 1024px) {
    .shop-cat-grid {
      grid-template-columns: 1fr;
    }

    .shop-premium-hero {
      height: 400px;
    }

    .shop-hero-content h1 {
      font-size: 42px;
    }
  }

  @media (max-width: 768px) {
    .shop-controls {
      flex-direction: column;
      gap: 20px;
    }
  }
</style>

<div class="shop-page-container">

  <!-- Hero Section -->
  <section class="shop-premium-hero">
    <div class="shop-hero-content">
      <h1>Official Merchandise</h1>
      <p>Represent your team with official FERWABA and RBL gear. Quality performance wear for players and fans.</p>
      <a href="#shop-inventory"
        style="background:#fbbf24; color:#1a365d; padding:15px 40px; border-radius:12px; text-decoration:none; font-weight:800; text-transform:uppercase;">Browse
        Collection</a>
    </div>
  </section>

  <!-- Categories -->
  <section class="shop-cat-grid">
    <a href="?category=Jerseys" class="shop-cat-card">
      <img src="../img/jersey.jpg" alt="Jerseys">
      <div class="shop-cat-overlay">
        <span>Performance</span>
        <h3>Official Jerseys</h3>
      </div>
    </a>
    <a href="?category=Kits" class="shop-cat-card">
      <img src="../img/gear.jpg" alt="Kits">
      <div class="shop-cat-overlay">
        <span>Complete Set</span>
        <h3>Team Kits</h3>
      </div>
    </a>
    <a href="?category=Gear" class="shop-cat-card">
      <img src="../img/kit.jpg" alt="Gear">
      <div class="shop-cat-overlay">
        <span>Accessories</span>
        <h3>Basketball Gear</h3>
      </div>
    </a>
  </section>

  <!-- Filter Bar -->
  <section class="shop-controls" id="shop-inventory">
    <div class="shop-filters">
      <form method="get" style="display:flex; gap:15px;">
        <select name="category" class="shop-select" onchange="this.form.submit()">
          <option value="">All Categories</option>
          <option value="Jerseys" <?php echo (($_GET['category'] ?? '') === 'Jerseys') ? 'selected' : ''; ?>>Jerseys
          </option>
          <option value="Kits" <?php echo (($_GET['category'] ?? '') === 'Kits') ? 'selected' : ''; ?>>Kits</option>
          <option value="Gear" <?php echo (($_GET['category'] ?? '') === 'Gear') ? 'selected' : ''; ?>>Gear</option>
        </select>
        <select name="gender" class="shop-select" onchange="this.form.submit()">
          <option value="">Any Gender</option>
          <option value="Men" <?php echo (($_GET['gender'] ?? '') === 'Men') ? 'selected' : ''; ?>>Men</option>
          <option value="Women" <?php echo (($_GET['gender'] ?? '') === 'Women') ? 'selected' : ''; ?>>Women</option>
          <option value="Unisex" <?php echo (($_GET['gender'] ?? '') === 'Unisex') ? 'selected' : ''; ?>>Unisex</option>
        </select>
      </form>
    </div>
    <div class="shop-results-info">
      <span style="font-weight:700; color:#1a365d;">RBL Collection 2024/25</span>
    </div>
  </section>

  <!-- Product Grid -->
  <section class="product-grid">
    <?php
    $where = ' WHERE is_active=1';
    $types = '';
    $params = [];

    if (!empty($_GET['category'])) {
      $where .= ' AND category=?';
      $types .= 's';
      $params[] = $_GET['category'];
    }
    if (!empty($_GET['gender'])) {
      $where .= ' AND gender=?';
      $types .= 's';
      $params[] = $_GET['gender'];
    }

    $stmt = $mysqli->prepare("SELECT * FROM shop_items $where ORDER BY created_at DESC");
    if ($types)
      $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 0) {
      echo "<div style='grid-column: 1/-1; text-align:center; padding:60px;'><p>No items found.</p></div>";
    }

    while ($i = $res->fetch_assoc()): ?>
      <div class="product-card">
        <div class="product-img-wrapper">
          <?php if ($i['image']): ?>
            <img src="../../../admin/uploads/<?php echo sanitize($i['image']); ?>"
              alt="<?php echo sanitize($i['name']); ?>">
          <?php else: ?>
            <img src="https://via.placeholder.com/400x500?text=Product" alt="Placeholder">
          <?php endif; ?>
          <div class="product-badge"><?php echo sanitize($i['gender']); ?></div>
        </div>
        <div class="product-info">
          <div class="product-category"><?php echo sanitize($i['category']); ?></div>
          <h3 class="product-title"><?php echo sanitize($i['name']); ?></h3>
          <div class="product-price-row">
            <div class="product-price">RWF <?php echo number_format((float) $i['price'], 0); ?></div>
            <a href="item.php?id=<?php echo $i['id']; ?>" class="product-btn" title="View Details">
              <i class="fas fa-shopping-cart"></i>
            </a>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </section>

</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
