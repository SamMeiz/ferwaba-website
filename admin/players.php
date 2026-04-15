<?php
$page_title = 'Players Management';
require_once __DIR__ . '/includes/admin-header.php';

$players = $db->query("SELECT p.id, p.name, p.position, p.height, p.nationality, p.jersey_number, p.photo, t.name AS team_name 
                      FROM players p LEFT JOIN teams t ON t.id=p.team_id 
                      ORDER BY t.name ASC, p.jersey_number ASC")->fetchAll();
?>

<div class="page-header">
  <div>
    <h1>Players Management</h1>
    <p>Manage player roster and information</p>
  </div>
  <div class="section-actions">
    <a href="dashboard.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
    <a href="player-form.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add Player</a>
  </div>
</div>

<div class="admin-card">
  <div class="admin-card-header">
    <h3><i class="fas fa-users"></i> All Players</h3>
    <span style="color: var(--gray-500); font-size: 14px;"><?php echo count($players); ?> players</span>
  </div>
  <div class="table-wrapper">
    <table class="admin-table">
      <thead>
        <tr>
          <th><i class="fas fa-image"></i> Photo</th>
          <th><i class="fas fa-hashtag"></i> #</th>
          <th><i class="fas fa-user"></i> Name</th>
          <th><i class="fas fa-running"></i> Position</th>
          <th><i class="fas fa-users"></i> Team</th>
          <th><i class="fas fa-globe"></i> Nationality</th>
          <th><i class="fas fa-cogs"></i> Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($players as $p): ?>
          <tr>
            <td>
              <?php if ($p['photo']): ?>
                <img src="uploads/<?php echo sanitize($p['photo']); ?>" alt="photo">
              <?php else: ?>
                <div
                  style="width: 44px; height: 44px; background: var(--gray-200); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--gray-400);">
                  <i class="fas fa-user"></i>
                </div>
              <?php endif; ?>
            </td>
            <td><strong style="color: var(--primary);"><?php echo (int) $p['jersey_number']; ?></strong></td>
            <td><strong><?php echo sanitize($p['name']); ?></strong></td>
            <td><?php echo sanitize($p['position']); ?></td>
            <td><?php echo sanitize($p['team_name'] ?? '-'); ?></td>
            <td><?php echo sanitize($p['nationality']); ?></td>
            <td>
              <div class="action-links">
                <a href="player-form.php?id=<?php echo (int) $p['id']; ?>" class="action-link edit">
                  <i class="fas fa-edit"></i> Edit
                </a>
                <a href="delete-player.php?id=<?php echo (int) $p['id']; ?>" class="action-link delete"
                  onclick="return confirm('Delete player?')">
                  <i class="fas fa-trash"></i> Delete
                </a>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>