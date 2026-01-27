<?php
$page_title = 'Teams Management';
require_once __DIR__ . '/includes/admin-header.php';

$res = $mysqli->query("SELECT id,name,gender,division,location,logo FROM teams ORDER BY name ASC");
?>

<div class="page-header">
  <div>
    <h1>Teams Management</h1>
    <p>Manage basketball teams in the league</p>
  </div>
  <div class="section-actions">
    <a href="dashboard.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
    <a href="team-form.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add Team</a>
  </div>
</div>

<div class="admin-card">
  <div class="admin-card-header">
    <h3><i class="fas fa-users"></i> All Teams</h3>
    <span style="color: var(--gray-500); font-size: 14px;"><?php echo $res->num_rows; ?> teams</span>
  </div>
  <div class="table-wrapper">
    <table class="admin-table">
      <thead>
        <tr>
          <th><i class="fas fa-image"></i> Logo</th>
          <th><i class="fas fa-tag"></i> Name</th>
          <th><i class="fas fa-venus-mars"></i> Gender</th>
          <th><i class="fas fa-trophy"></i> Division</th>
          <th><i class="fas fa-map-marker-alt"></i> Location</th>
          <th><i class="fas fa-cogs"></i> Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($t = $res->fetch_assoc()): ?>
        <tr>
          <td>
            <?php if ($t['logo']): ?>
              <img src="uploads/<?php echo sanitize($t['logo']); ?>" alt="logo">
            <?php else: ?>
              <div style="width: 44px; height: 44px; background: var(--gray-200); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--gray-400);">
                <i class="fas fa-image"></i>
              </div>
            <?php endif; ?>
          </td>
          <td><strong><?php echo sanitize($t['name']); ?></strong></td>
          <td>
            <span class="status-badge" style="background: var(--gray-100); color: var(--gray-700);">
              <i class="fas fa-<?php echo $t['gender'] === 'Female' ? 'venus' : 'mars'; ?>"></i>
              <?php echo sanitize($t['gender']); ?>
            </span>
          </td>
          <td><?php echo sanitize($t['division']); ?></td>
          <td><?php echo sanitize($t['location']); ?></td>
          <td>
            <div class="action-links">
              <a href="team-form.php?id=<?php echo (int)$t['id']; ?>" class="action-link edit">
                <i class="fas fa-edit"></i> Edit
              </a>
              <a href="delete-team.php?id=<?php echo (int)$t['id']; ?>" class="action-link delete" onclick="return confirm('Delete team? This may affect players and coaches.')">
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
