<?php require_once __DIR__ . '/../includes/config.php';
require_login();

$rows = $mysqli->query("SELECT id,title,category,image,created_at FROM news ORDER BY created_at DESC, id DESC");
?>
<!DOCTYPE html>
<html lang=\"en\">
<head>
  <meta charset=\"UTF-8\">
  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
  <title>Manage News - FERWABA</title>
  <link rel=\"stylesheet\" href=\"<?php echo asset_url('../css/style.css'); ?>\">
</head>
<body>
<div class=\"container\" style=\"margin:20px auto\">
  <div class=\"section-title\">
    <h2>News</h2>
    <a class=\"btn\" href=\"/admin/news-form.php\">Add Article</a>
  </div>
  <div class=\"card\">
    <table>
      <thead><tr><th>Image</th><th>Title</th><th>Category</th><th>Published</th><th>Actions</th></tr></thead>
      <tbody>
        <?php while($n=$rows->fetch_assoc()): ?>
        <tr>
          <td><?php if($n['image']): ?><img src=\"/admin/uploads/<?php echo sanitize($n['image']); ?>\" alt=\"img\" style=\"width:48px;height:32px;object-fit:cover;border-radius:6px\"><?php endif; ?></td>
          <td><?php echo sanitize($n['title']); ?></td>
          <td><?php echo sanitize($n['category']); ?></td>
          <td><?php echo sanitize($n['created_at']); ?></td>
          <td>
            <a href=\"/admin/news-form.php?id=<?php echo (int)$n['id']; ?>\">Edit</a>
            <a href=\"/admin/delete-news.php?id=<?php echo (int)$n['id']; ?>\" onclick=\"return confirm('Delete article?')\">Delete</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>


