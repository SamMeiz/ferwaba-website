<?php require_once __DIR__ . '/includes/header.php'; ?>

<section class="section-title">
  <h2>News</h2>
  <nav class="muted" style="display:flex;gap:12px;flex-wrap:wrap">
    <?php
    $cats = ['Latest','Transfers','Injuries','Squad Updates'];
    foreach($cats as $cat): ?>
      <a class="btn" href="<?php echo asset_url('news.php?category=' . urlencode($cat)); ?>" style="background:#f3f4f6">
        <?php echo sanitize($cat); ?>
      </a>
    <?php endforeach; ?>
  </nav>
</section>

<div class="grid col-3">
<?php
$where = '';
$types = '';
$params = [];
if(!empty($_GET['category'])) {
    $where = ' WHERE category=?';
    $types = 's';
    $params[] = $_GET['category'];
}

// Fetch latest news by created_at DESC
$stmt = $mysqli->prepare('SELECT id,title,content,category,image,video_url,created_at FROM news' . $where . ' ORDER BY created_at DESC, id DESC');
if($where){ $stmt->bind_param($types, ...$params); }
$stmt->execute();
$res = $stmt->get_result();

while($n = $res->fetch_assoc()): ?>
  <!-- Link to dedicated news-card.php page -->
  <a class="card" href="news-card.php?id=<?php echo (int)$n['id']; ?>">
    <?php if($n['image']): ?>
      <img src="/ferwaba1/admin/uploads/<?php echo sanitize($n['image']); ?>" 
           alt="img" style="width:100%;height:160px;object-fit:cover">
    <?php endif; ?>
    <div class="card-body">
      <h3><?php echo sanitize($n['title']); ?></h3>
      <div class="muted"><?php echo sanitize($n['category'].' • '.$n['created_at']); ?></div>
    </div>
  </a>
<?php endwhile; ?>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
