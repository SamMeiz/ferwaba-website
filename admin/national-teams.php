<?php
$page_title = 'National Teams Management';
require_once __DIR__ . '/includes/admin-header.php';

// Fetch national teams ordered by category and creation date
$result = $mysqli->query("SELECT * FROM national_teams ORDER BY category, created_at DESC");
?>

<div class="page-header">
  <div>
    <h1>National Teams Management</h1>
    <p>Manage Rwanda national basketball teams and rosters</p>
  </div>
  <div class="section-actions">
    <a href="dashboard.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
    <a href="national-team-form.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add National Team</a>
  </div>
</div>

<div class="admin-card">
  <div class="admin-card-header">
    <h3><i class="fas fa-flag"></i> National Teams</h3>
    <span style="color: var(--gray-500); font-size: 14px;"><?php echo $result->num_rows; ?>
      team<?php echo $result->num_rows !== 1 ? 's' : ''; ?></span>
  </div>
  <div class="table-wrapper">
    <table class="admin-table">
      <thead>
        <tr>
          <th><i class="fas fa-image"></i> Banner</th>
          <th><i class="fas fa-flag"></i> Team Name</th>
          <th><i class="fas fa-tag"></i> Category</th>
          <th><i class="fas fa-calendar"></i> Created</th>
          <th><i class="fas fa-cogs"></i> Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result->num_rows > 0): ?>
          <?php while ($t = $result->fetch_assoc()): ?>
            <tr>
              <td>
                <?php if (!empty($t['banner_image'])): ?>
                  <img src="uploads/<?php echo sanitize($t['banner_image']); ?>" alt="Banner">
                <?php else: ?>
                  <div
                    style="width: 48px; height: 48px; background: var(--gray-200); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--gray-400);">
                    <i class="fas fa-flag"></i>
                  </div>
                <?php endif; ?>
              </td>
              <td>
                <strong><?php echo sanitize($t['team_name']); ?></strong>
              </td>
              <td>
                <span class="status-badge"
                  style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); color: #fff;">
                  <i class="fas fa-certificate"></i>
                  <?php echo sanitize($t['category']); ?>
                </span>
              </td>
              <td><?php echo date('M j, Y', strtotime($t['created_at'])); ?></td>
              <td>
                <div class="action-links">
                  <a href="national-team-form.php?id=<?php echo (int) $t['id']; ?>" class="action-link edit">
                    <i class="fas fa-edit"></i> Edit
                  </a>
                  <a href="national-players.php?team_id=<?php echo (int) $t['id']; ?>" class="action-link view">
                    <i class="fas fa-users"></i> Players
                  </a>
                </div>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="5">
              <div class="empty-state">
                <i class="fas fa-flag"></i>
                <h3>No National Teams Yet</h3>
                <p>Add your first national team to get started</p>
                <a href="national-team-form.php" class="btn btn-primary">
                  <i class="fas fa-plus"></i> Add National Team
                </a>
              </div>
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>