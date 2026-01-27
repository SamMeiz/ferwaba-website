<?php require_once __DIR__ . '/../includes/header.php'; ?><br><br>
<?php

// Get the news ID from URL
$id = isset($_GET['id']) && ctype_digit($_GET['id']) ? (int) $_GET['id'] : 0;
if (!$id) {
  redirect('news.php');
}

// Fetch the news article
$stmt = $mysqli->prepare("SELECT title, content, category, image, video_url, created_at FROM news WHERE id=? LIMIT 1");
$stmt->bind_param('i', $id);
$stmt->execute();
$res = $stmt->get_result();
$article = $res->fetch_assoc();
if (!$article) {
  redirect('news.php');
}

// Fetch 3 latest news for sidebar (excluding current)
$related = $mysqli->query("SELECT id, title, image, created_at FROM news WHERE id != $id ORDER BY created_at DESC LIMIT 3");
?>

<style>
  /* Professional News Article Styling */
  .news-detail-page {
    background: #f8fafc;
    min-height: 100vh;
    padding: 40px 0;
  }

  .article-layout {
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 40px;
    padding: 0 20px;
  }

  .article-main {
    background: #fff;
    border-radius: 20px;
    padding: 50px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
  }

  .article-header {
    margin-bottom: 40px;
  }

  .article-category {
    display: inline-block;
    background: #1a365d;
    color: #fbbf24;
    padding: 10px 24px;
    border-radius: 30px;
    font-size: 13px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 24px;
  }

  .article-title {
    font-size: 48px;
    font-weight: 900;
    line-height: 1.1;
    color: #1a1a1a;
    margin-bottom: 25px;
    letter-spacing: -1px;
  }

  .article-meta {
    display: flex;
    align-items: center;
    gap: 24px;
    color: #64748b;
    font-size: 15px;
    padding: 24px 0;
    border-top: 2px solid #f1f5f9;
    border-bottom: 2px solid #f1f5f9;
  }

  .article-meta span {
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .article-meta i {
    color: #fbbf24;
    font-size: 18px;
  }

  .article-featured-image {
    width: 100%;
    max-height: 550px;
    object-fit: cover;
    border-radius: 20px;
    margin: 40px 0;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
  }

  .article-body {
    font-size: 19px;
    line-height: 1.8;
    color: #334155;
  }

  .article-body p {
    margin-bottom: 28px;
  }

  .article-video {
    margin: 60px 0;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    aspect-ratio: 16/9;
  }

  /* Sidebar Styling */
  .article-sidebar {
    display: flex;
    flex-direction: column;
    gap: 30px;
  }

  .sidebar-box {
    background: #fff;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
  }

  .sidebar-title {
    font-size: 20px;
    font-weight: 800;
    color: #1a365d;
    margin-bottom: 24px;
    padding-bottom: 15px;
    border-bottom: 3px solid #fbbf24;
  }

  .related-item {
    display: flex;
    gap: 15px;
    margin-bottom: 20px;
    text-decoration: none;
    color: inherit;
    transition: transform 0.3s ease;
  }

  .related-item:hover {
    transform: translateX(5px);
  }

  .related-thumb {
    width: 90px;
    height: 90px;
    border-radius: 12px;
    object-fit: cover;
    flex-shrink: 0;
  }

  .related-info h4 {
    font-size: 15px;
    font-weight: 700;
    color: #1a365d;
    line-height: 1.3;
    margin: 0 0 5px 0;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .related-date {
    font-size: 12px;
    color: #94a3b8;
  }

  .back-link {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    color: #1a365d;
    font-weight: 700;
    font-size: 15px;
    margin-bottom: 30px;
    transition: all 0.3s ease;
  }

  .back-link:hover {
    color: #fbbf24;
    transform: translateX(-5px);
  }

  @media (max-width: 1100px) {
    .article-layout {
      grid-template-columns: 1fr;
    }
  }

  @media (max-width: 768px) {
    .article-main {
      padding: 30px 20px;
    }

    .article-title {
      font-size: 32px;
    }

    .article-body {
      font-size: 17px;
    }
  }
</style>

<div class="news-detail-page">
  <div class="article-layout">
    <main class="article-main">
      <a href="news.php" class="back-link">
        <i class="fas fa-arrow-left"></i> Back to All News
      </a>

      <article>
        <span class="article-category"><?php echo sanitize($article['category']); ?></span>
        <h1 class="article-title"><?php echo sanitize($article['title']); ?></h1>

        <div class="article-meta">
          <span><i class="far fa-calendar-alt"></i>
            <?php echo date('F d, Y', strtotime($article['created_at'])); ?></span>
          <span><i class="far fa-clock"></i> <?php echo date('h:i A', strtotime($article['created_at'])); ?></span>
          <span><i class="far fa-eye"></i> Professional Daily</span>
        </div>

        <?php if ($article['image']): ?>
          <img src="../../../admin/uploads/<?php echo sanitize($article['image']); ?>"
            alt="<?php echo sanitize($article['title']); ?>" class="article-featured-image">
        <?php endif; ?>

        <div class="article-body">
          <?php echo nl2br(sanitize($article['content'])); ?>
        </div>

        <?php if ($article['video_url']): ?>
          <div class="article-video">
            <?php echo youtube_embed($article['video_url']); ?>
          </div>
        <?php endif; ?>
      </article>

      <div
        style="margin-top:60px; padding-top:40px; border-top:2px solid #f1f5f9; display:flex; justify-content:space-between; align-items:center;">
        <div style="display:flex; gap:15px; align-items:center;">
          <span style="font-weight:800; color:#1a365d; font-size:14px; text-transform:uppercase;">Share:</span>
          <a href="#" style="color:#1a365d; font-size:20px;"><i class="fab fa-facebook-f"></i></a>
          <a href="#" style="color:#1a365d; font-size:20px;"><i class="fab fa-x-twitter"></i></a>
          <a href="#" style="color:#1a365d; font-size:20px;"><i class="fab fa-whatsapp"></i></a>
          <a href="#" style="color:#1a365d; font-size:20px;"><i class="fas fa-link"></i></a>
        </div>
      </div>
    </main>

    <aside class="article-sidebar">
      <div class="sidebar-box">
        <h3 class="sidebar-title">Recent Stories</h3>
        <div class="related-list">
          <?php while ($r = $related->fetch_assoc()):
            $thumb = !empty($r['image']) ? '../../../admin/uploads/' . sanitize($r['image']) : 'https://via.placeholder.com/150';
            ?>
            <a href="news-card.php?id=<?php echo $r['id']; ?>" class="related-item">
              <img src="<?php echo $thumb; ?>" alt="" class="related-thumb">
              <div class="related-info">
                <h4><?php echo sanitize($r['title']); ?></h4>
                <span class="related-date"><?php echo date('M d, Y', strtotime($r['created_at'])); ?></span>
              </div>
            </a>
          <?php endwhile; ?>
        </div>
      </div>

      <div class="sidebar-box" style="background:#1a365d; color:#fff;">
        <h3 class="sidebar-title" style="color:#fbbf24; border-bottom-color:#fbbf24;">RBL Official</h3>
        <p style="font-size:14px; color:rgba(255,255,255,0.8); line-height:1.6; margin-bottom:20px;">
          The Rwanda Basketball League is the premier professional competition in the country. Stay tuned for official
          updates.
        </p>
        <a href="standings.php"
          style="display:block; text-align:center; background:#fbbf24; color:#1a365d; font-weight:800; padding:12px; border-radius:10px; font-size:13px; text-transform:uppercase;">View
          Standings</a>
      </div>
    </aside>
  </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>