<?php
$page_title = 'Playoffs Management';
require_once __DIR__ . '/includes/admin-header.php';

$rows = $mysqli->query("
    SELECT p.*, 
           th.name AS home_name, 
           ta.name AS away_name, 
           tw.name AS winner_name 
    FROM playoffs p 
    LEFT JOIN teams th ON th.id=p.home_team_id 
    LEFT JOIN teams ta ON ta.id=p.away_team_id 
    LEFT JOIN teams tw ON tw.id=p.winner_team_id 
    ORDER BY FIELD(p.stage,'Quarterfinal','Semifinal','Final','3rd Place'), p.start_date ASC, p.id ASC
");
?>

<div class="page-header">
  <div>
    <h1>Playoffs Management</h1>
    <p>Manage playoff matchups and results</p>
  </div>
  <div class="section-actions">
    <a href="dashboard.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
    <a href="playoff-form.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add Matchup</a>
  </div>
</div>

<div class="admin-card">
  <div class="admin-card-header">
    <h3><i class="fas fa-list"></i> All Playoff Matchups</h3>
    <span style="color: var(--gray-500); font-size: 14px;"><?php echo $rows->num_rows; ?> matches</span>
  </div>
  <div class="table-wrapper">
    <table class="admin-table">
      <thead>
        <tr>
          <th><i class="fas fa-trophy"></i> Stage</th>
          <th><i class="fas fa-calendar"></i> Date</th>
          <th><i class="fas fa-users"></i> Matchup</th>
          <th><i class="fas fa-scoreboard"></i> Score</th>
          <th><i class="fas fa-star"></i> Winner</th>
          <th><i class="fas fa-info-circle"></i> Status</th>
          <th><i class="fas fa-cogs"></i> Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($p = $rows->fetch_assoc()): ?>
        <tr>
          <td>
            <?php
            $stageColors = [
              'Quarterfinal' => 'status-active',
              'Semifinal' => 'status-pending',
              'Final' => 'status-active',
              '3rd Place' => 'status-inactive'
            ];
            ?>
            <span class="status-badge <?php echo $stageColors[$p['stage']] ?? ''; ?>">
              <?php echo sanitize($p['stage']); ?>
            </span>
          </td>
          <td><?php echo date('M d, Y', strtotime($p['start_date'])); ?></td>
          <td>
            <div style="display: flex; align-items: center; gap: 6px;">
              <span style="font-weight: 600;"><?php echo sanitize($p['home_name'] ?? 'TBD'); ?></span>
              <span style="color: var(--gray-400);">vs</span>
              <span style="font-weight: 600;"><?php echo sanitize($p['away_name'] ?? 'TBD'); ?></span>
            </div>
          </td>
          <td><strong><?php echo (int)$p['home_score']; ?> - <?php echo (int)$p['away_score']; ?></strong></td>
          <td><?php echo sanitize($p['winner_name'] ?? '-'); ?></td>
          <td>
            <span class="status-badge <?php echo $p['status'] === 'Completed' ? 'status-active' : ($p['status'] === 'Live' ? 'status-pending' : 'status-inactive'); ?>">
              <?php echo sanitize($p['status']); ?>
            </span>
          </td>
          <td>
            <div class="action-links">
              <a href="playoff-form.php?id=<?php echo (int)$p['id']; ?>" class="action-link edit">
                <i class="fas fa-edit"></i> Edit
              </a>
              <a href="delete-playoff.php?id=<?php echo (int)$p['id']; ?>" class="action-link delete" onclick="return confirm('Delete this matchup?')">
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

<div style="margin-top: 24px; padding: 16px; background: var(--gray-100); border-radius: var(--radius);">
  <i class="fas fa-info-circle"></i>
  <span style="color: var(--gray-600); font-size: 14px;">
    <strong>Note:</strong> The playoff bracket visualization is shown on the frontend at 
    <code>competitions/rbl/pages/playoffs.php</code> for visitors.
  </span>
</div>

<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>
