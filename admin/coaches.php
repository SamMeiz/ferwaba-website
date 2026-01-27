<?php
$page_title = 'Coaches Management';
require_once __DIR__ . '/includes/admin-header.php';

$coaches = $mysqli->query("SELECT c.id,c.name,c.role,c.nationality,c.photo,t.name AS team_name FROM coaches c LEFT JOIN teams t ON t.id=c.team_id ORDER BY t.name ASC, c.role ASC, c.name ASC");
?>

<div class="page-header">
  <div>
    <h1>Coaches Management</h1>
    <p>Manage coaching staff</p>
  </div>
  <div class="section-actions">
    <a href="dashboard.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
    <a href="coach-form.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add Coach</a>
  </div>
</div>

<div class="admin-card">
  <div class="admin-card-header">
    <h3><i class="fas fa-chalkboard-teacher"></i> All Coaches</h3>
    <span style="color: var(--gray-500); font-size: 14px;"><?php echo $coaches->num_rows; ?> coaches</span>
  </div>
  <div class="table-wrapper">
    <table class="admin-table">
      <thead>
        <tr>
          <th><i class="fas fa-image"></i> Photo</th>
          <th><i class="fas fa-user"></i> Name</th>
          <th><i class="fas fa-briefcase"></i> Role</th>
          <th><i class="fas fa-users"></i> Team</th>
          <th><i class="fas fa-globe"></i> Nationality</th>
          <th><i class="fas fa-cogs"></i> Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($c = $coaches->fetch_assoc()): ?>
        <tr>
          <td>
            <?php if ($c['photo']): ?>
              <img src="uploads/<?php echo sanitize($c['photo']); ?>" alt="photo">
            <?php else: ?>
              <div style="width: 44px; height: 44px; background: var(--gray-200); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--gray-400);">
                <i class="fas fa-user"></i>
              </div>
            <?php endif; ?>
          </td>
          <td><strong><?php echo sanitize($c['name']); ?></strong></td>
          <td><?php echo sanitize($c['role']); ?></td>
          <td><?php echo sanitize($c['team_name'] ?? '-'); ?></td>
          <td><?php echo sanitize($c['nationality']); ?></td>
          <td>
            <div class="action-links">
              <a href="coach-form.php?id=<?php echo (int)$c['id']; ?>" class="action-link edit">
                <i class="fas fa-edit"></i> Edit
              </a>
              <a href="delete-coach.php?id=<?php echo (int)$c['id']; ?>" class="action-link delete" onclick="return confirm('Delete coach?')">
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
