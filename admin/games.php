<?php
$page_title = 'Games Management';
require_once __DIR__ . '/includes/admin-header.php';

$games = $mysqli->query("SELECT g.*, th.name as home_name, ta.name as away_name FROM games g JOIN teams th ON th.id=g.home_team_id JOIN teams ta ON ta.id=g.away_team_id ORDER BY g.game_date DESC, g.id DESC");
?>

<div class="page-header">
  <div>
    <h1>Games Management</h1>
    <p>Manage game schedules and results</p>
  </div>
  <div class="section-actions">
    <a href="dashboard.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
    <a href="game-form.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add Game</a>
  </div>
</div>

<div class="admin-card">
  <div class="admin-card-header">
    <h3><i class="fas fa-calendar-alt"></i> All Games</h3>
    <span style="color: var(--gray-500); font-size: 14px;"><?php echo $games->num_rows; ?> games</span>
  </div>
  <div class="table-wrapper">
    <table class="admin-table">
      <thead>
        <tr>
          <th><i class="fas fa-calendar"></i> Date</th>
          <th><i class="fas fa-handshake"></i> Match</th>
          <th><i class="fas fa-trophy"></i> Division</th>
          <th><i class="fas fa-venus-mars"></i> Gender</th>
          <th><i class="fas fa-info-circle"></i> Status</th>
          <th><i class="fas fa-scoreboard"></i> Score</th>
          <th><i class="fas fa-map-marker-alt"></i> Location</th>
          <th><i class="fas fa-cogs"></i> Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($g = $games->fetch_assoc()): ?>
        <tr>
          <td><strong><?php echo date('M d, Y', strtotime($g['game_date'])); ?></strong></td>
          <td>
            <div style="display: flex; align-items: center; gap: 8px;">
              <span style="color: var(--primary); font-weight: 600;"><?php echo sanitize($g['home_name']); ?></span>
              <span style="color: var(--gray-400);">vs</span>
              <span style="color: var(--primary); font-weight: 600;"><?php echo sanitize($g['away_name']); ?></span>
            </div>
          </td>
          <td><?php echo sanitize($g['division']); ?></td>
          <td>
            <span class="status-badge" style="background: var(--gray-100); color: var(--gray-700);">
              <i class="fas fa-<?php echo $g['gender'] === 'Female' ? 'venus' : 'mars'; ?>"></i>
              <?php echo sanitize($g['gender']); ?>
            </span>
          </td>
          <td>
            <?php
            $statusClass = match($g['status']) {
              'Completed' => 'status-active',
              'Live' => 'status-pending',
              'Postponed' => 'status-inactive',
              default => 'status-active'
            };
            ?>
            <span class="status-badge <?php echo $statusClass; ?>">
              <?php echo sanitize($g['status']); ?>
            </span>
          </td>
          <td><strong><?php echo (int)$g['home_score']; ?> - <?php echo (int)$g['away_score']; ?></strong></td>
          <td><?php echo sanitize($g['location']); ?></td>
          <td>
            <div class="action-links">
              <a href="game-form.php?id=<?php echo (int)$g['id']; ?>" class="action-link edit">
                <i class="fas fa-edit"></i> Edit
              </a>
              <a href="delete-game.php?id=<?php echo (int)$g['id']; ?>" class="action-link delete" onclick="return confirm('Delete game? This will recalculate standings.')">
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
