<?php 
require_once __DIR__ . '/includes/config.php'; 
require_once __DIR__ . '/includes/header.php'; 

// Get the news ID from URL
$id = isset($_GET['id']) && ctype_digit($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) {
    die('Invalid article.');
}

// Fetch the news article
$stmt = $mysqli->prepare("SELECT title, content, category, image, video_url, created_at FROM news WHERE id=? LIMIT 1");
$stmt->bind_param('i', $id);
$stmt->execute();
$res = $stmt->get_result();
$article = $res->fetch_assoc();
if (!$article) {
    die('Article not found.');
}
?>

<div class="container" style="max-width:840px;margin:24px auto">
  <div class="section-title">
    <h2><?php echo sanitize($article['title']); ?></h2>
    <a class="btn" href="news.php" style="background:#6b7280;margin-left:8px;">⬅️ Back to News</a>
  </div>

  <div class="card" style="margin-top:12px">
    <div class="card-body">
      <div class="muted" style="margin-bottom:12px">
        <?php echo sanitize($article['category'] . ' • ' . $article['created_at']); ?>
      </div>

      <?php if ($article['image']): ?>
        <img src="/ferwaba1/admin/uploads/<?php echo sanitize($article['image']); ?>" 
             alt="img" style="width:100%;max-height:400px;object-fit:cover;border-radius:8px;margin-bottom:12px">
      <?php endif; ?>

      <div style="line-height:1.6">
        <?php echo nl2br(sanitize($article['content'])); ?>
      </div>

      <?php if ($article['video_url']): ?>
        <div style="margin-top:12px">
          <?php echo youtube_embed($article['video_url']); ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
