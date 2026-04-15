<?php require_once __DIR__ . '/../includes/header.php'; ?><br><br>

<style>
  /* Professional News Cards */
  .news-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
  }

  .news-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 30px;
    margin-top: 40px;
  }

  .news-card-pro {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    display: flex;
    flex-direction: column;
    text-decoration: none;
    color: inherit;
    position: relative;
  }

  .news-card-pro:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
  }

  .news-card-image {
    position: relative;
    width: 100%;
    height: 240px;
    overflow: hidden;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  }

  .news-card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
  }

  .news-card-pro:hover .news-card-image img {
    transform: scale(1.1);
  }

  .news-category-badge {
    position: absolute;
    top: 16px;
    left: 16px;
    background: rgba(255, 255, 255, 0.95);
    color: #2563eb;
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    backdrop-filter: blur(10px);
  }

  .news-card-content {
    padding: 24px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    background: #fff;
  }

  .news-card-title {
    font-size: 20px;
    font-weight: 700;
    line-height: 1.4;
    margin-bottom: 10px;
    color: #1a365d;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .news-card-desc {
    font-size: 14px;
    line-height: 1.6;
    color: #4b5563;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    margin-bottom: 16px;
  }

  .news-card-meta {
    display: flex;
    align-items: center;
    gap: 12px;
    color: #6b7280;
    font-size: 13px;
    margin-top: auto;
    padding-top: 16px;
    border-top: 1px solid #e5e7eb;
  }

  .news-card-meta i {
    color: #fbbf24;
  }

  .category-filter {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    justify-content: center;
    margin-top: 20px;
  }

  .category-btn {
    padding: 10px 24px;
    border-radius: 25px;
    background: #f3f4f6;
    color: #4b5563;
    text-decoration: none;
    font-weight: 500;
    font-size: 14px;
    transition: all 0.3s ease;
    border: 2px solid transparent;
  }

  .category-btn:hover, .category-btn.active {
    background: #1a365d;
    color: #fbbf24;
    transform: translateY(-2px);
    border-color: #fbbf24;
    box-shadow: 0 4px 12px rgba(26, 54, 93, 0.2);
  }

  .category-btn i {
    margin-right: 8px;
    font-size: 14px;
  }

  @media (max-width: 768px) {
    .news-grid {
      grid-template-columns: 1fr;
    }
  }
</style>

<section class="section-title">
  <h2>RBL Latest News</h2>
  <nav class="category-filter">
    <?php
    $cats = [
      'Latest' => 'fas fa-newspaper',
      'Transfers' => 'fas fa-exchange-alt',
      'Injuries' => 'fas fa-medkit',
      'Squad Updates' => 'fas fa-users'
    ];
    $current_cat = $_GET['category'] ?? 'Latest';
    foreach ($cats as $cat => $icon):
      $active_class = ($current_cat === $cat || ($cat === 'Latest' && empty($_GET['category']))) ? 'active' : '';
      ?>
      <a class="category-btn <?php echo $active_class; ?>"
        href="news.php<?php echo $cat === 'Latest' ? '' : '?category=' . urlencode($cat); ?>">
        <i class="<?php echo $icon; ?>"></i> <?php echo sanitize($cat); ?>
      </a>
    <?php endforeach; ?>
  </nav>
</section>

<div class="news-container">
  <div class="news-grid">
    <?php
    $where = '';
    $types = '';
    $params = [];
    if (!empty($_GET['category'])) {
      $where = ' WHERE category=?';
      $types = 's';
      $params[] = $_GET['category'];
    }

    $stmt = $mysqli->prepare('SELECT id,title,content,category,image,video_url,created_at FROM news' . $where . ' ORDER BY created_at DESC, id DESC');
    if ($where) {
      $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $res = $stmt->get_result();

    while ($n = $res->fetch_assoc()): ?>
      <a class="news-card-pro" href="news-card.php?id=<?php echo (int) $n['id']; ?>">
        <div class="news-card-image">
          <?php if ($n['image']): ?>
            <img src="../../../admin/uploads/<?php echo sanitize($n['image']); ?>"
              alt="<?php echo sanitize($n['title']); ?>">
          <?php else: ?>
            <div style="width:100%;height:100%;background:linear-gradient(135deg, #667eea 0%, #764ba2 100%);"></div>
          <?php endif; ?>
          <span class="news-category-badge"><?php echo sanitize($n['category']); ?></span>
        </div>
        <div class="news-card-content">
          <h3 class="news-card-title"><?php echo sanitize($n['title']); ?></h3>
          <p class="news-card-desc"><?php echo sanitize(substr(strip_tags($n['content']), 0, 120)) . '...'; ?></p>
          <div class="news-card-meta">
            <span><i class="far fa-calendar"></i> <?php echo date('M d, Y', strtotime($n['created_at'])); ?></span>
          </div>
        </div>
      </a>
    <?php endwhile; ?>
  </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
