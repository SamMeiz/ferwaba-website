<?php
$page_title = 'News Management';
require_once __DIR__ . '/includes/admin-header.php';

$rows = $mysqli->query("SELECT id, title, category, image, created_at FROM news ORDER BY created_at DESC, id DESC");
?>

<div class="page-header">
  <div>
    <h1>News Management</h1>
    <p>Manage news articles and announcements</p>
  </div>
  <div class="section-actions">
    <a href="dashboard.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
    <a href="news-form.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add Article</a>
  </div>
</div>

<div class="admin-card">
  <div class="admin-card-header">
    <h3><i class="fas fa-newspaper"></i> All Articles</h3>
    <span style="color: var(--gray-500); font-size: 14px;"><?php echo $rows->num_rows; ?> articles</span>
  </div>
  <div class="table-wrapper">
    <table class="admin-table">
      <thead>
        <tr>
          <th><i class="fas fa-image"></i> Image</th>
          <th><i class="fas fa-heading"></i> Title</th>
          <th><i class="fas fa-tag"></i> Category</th>
          <th><i class="fas fa-calendar"></i> Published</th>
          <th><i class="fas fa-cogs"></i> Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($n = $rows->fetch_assoc()): ?>
        <tr>
          <td>
            <?php if ($n['image']): ?>
              <img src="uploads/<?php echo sanitize($n['image']); ?>" alt="img">
            <?php else: ?>
              <div style="width: 44px; height: 44px; background: var(--gray-200); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--gray-400);">
                <i class="fas fa-image"></i>
              </div>
            <?php endif; ?>
          </td>
          <td><strong><?php echo sanitize($n['title']); ?></strong></td>
          <td>
            <span class="status-badge" style="background: var(--gray-100); color: var(--gray-700);">
              <i class="fas fa-tag"></i>
              <?php echo sanitize($n['category']); ?>
            </span>
          </td>
          <td><?php echo date('M d, Y', strtotime($n['created_at'])); ?></td>
          <td>
            <div class="action-links">
              <a href="news-form.php?id=<?php echo (int)$n['id']; ?>" class="action-link edit">
                <i class="fas fa-edit"></i> Edit
              </a>
              <a href="delete-news.php?id=<?php echo (int)$n['id']; ?>" class="action-link delete" onclick="return confirm('Delete this article?')">
                <i class="fas fa-trash"></i> Delete
              </a>
            </div>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>
