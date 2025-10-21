<?php 
require_once __DIR__ . '/../includes/config.php';
require_login();

$rows = $mysqli->query("SELECT id, title, content, category, image, video_url, created_at FROM news ORDER BY created_at DESC, id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage News - FERWABA</title>
<link rel="stylesheet" href="<?php echo asset_url('../css/style.css'); ?>">
</head>
<body>
<div class="container" style="margin:24px auto; max-width:900px">
  <div class="section-title" style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px">
    <h2>News</h2>
    <div>
      <a href="javascript:history.back()" class="btn" style="background:#6b7280;margin-right:8px;">⬅️ Back</a>
      <a href="news-form.php" class="btn">➕ Add Article</a>
    </div>
  </div>

  <div class="card">
    <table>
      <thead>
        <tr>
          <th>Image</th>
          <th>Title</th>
          <th>Category</th>
          <th>Content</th>
          <th>Video URL</th>
          <th>Published</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while($n = $rows->fetch_assoc()): ?>
        <tr>
          <td>
            <?php if($n['image']): ?>
              <img src="/ferwaba1/admin/uploads/<?php echo sanitize($n['image']); ?>" alt="img" style="width:48px;height:32px;object-fit:cover;border-radius:6px">

            <?php endif; ?>
          </td>
          <td><?php echo sanitize($n['image']); ?></td>
          <td><?php echo sanitize($n['title']); ?></td>
          <td><?php echo sanitize($n['category']); ?></td>
          <td><?php echo sanitize($n['content']); ?></td>
          <td><?php echo sanitize($n['video_url']); ?></td>
          <td><?php echo sanitize($n['created_at']); ?></td>
          <td>
            <a href="news-form.php?id=<?php echo (int)$n['id']; ?>" class="btn-small">✏️ Edit</a>
            <a href="delete-news.php?id=<?php echo (int)$n['id']; ?>" class="btn-small danger" onclick="return confirm('Delete this article?')">🗑️ Delete</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>
