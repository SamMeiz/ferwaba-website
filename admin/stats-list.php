<?php
$page_title = 'Player Statistics';
require_once __DIR__ . '/includes/admin-header.php';

$stats = $mysqli->query("
  SELECT ps.*, p.name AS player_name, t.name AS team_name
  FROM player_stats ps
  JOIN players p ON ps.player_id = p.id
  LEFT JOIN teams t ON p.team_id = t.id
  ORDER BY (ps.total_points / GREATEST(ps.games_played, 1)) DESC
");
?>

<style>
  .stats-highlight {
    background: linear-gradient(135deg, rgba(0, 102, 204, 0.08) 0%, rgba(0, 102, 204, 0.05) 100%);
    border-left: 4px solid var(--primary) !important;
  }

  .stat-value {
    font-family: 'Roboto Mono', monospace;
    font-weight: 700;
    font-size: 15px;
  }

  .stat-leader {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 2px 8px;
    background: linear-gradient(135deg, var(--accent) 0%, #e6bd00 100%);
    color: var(--primary-dark);
    border-radius: 4px;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }
</style>

<div class="page-header">
  <div>
    <h1>Player Statistics</h1>
    <p>View and manage player performance statistics</p>
  </div>
  <div class="section-actions">
    <a href="dashboard.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
    <a href="stats-form.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add Statistics</a>
  </div>
</div>

<div class="admin-card">
  <div class="admin-card-header">
    <h3><i class="fas fa-chart-bar"></i> Player Performance Statistics</h3>
    <span style="color: var(--gray-500); font-size: 14px;"><?php echo $stats->num_rows; ?>
      player<?php echo $stats->num_rows !== 1 ? 's' : ''; ?></span>
  </div>
  <div class="table-wrapper">
    <table class="admin-table">
      <thead>
        <tr>
          <th><i class="fas fa-user"></i> Player</th>
          <th><i class="fas fa-users"></i> Team</th>
          <th><i class="fas fa-gamepad"></i> GP</th>
          <th><i class="fas fa-basketball-ball"></i> PPG</th>
          <th><i class="fas fa-hand-rock"></i> RPG</th>
          <th><i class="fas fa-hands-helping"></i> APG</th>
          <th><i class="fas fa-hand-paper"></i> SPG</th>
          <th><i class="fas fa-hand-point-up"></i> BPG</th>
          <th><i class="fas fa-bullseye"></i> FG%</th>
          <th><i class="fas fa-dot-circle"></i> 3P%</th>
          <th><i class="fas fa-circle"></i> FT%</th>
          <th><i class="fas fa-cogs"></i> Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $topScorer = true;
        while ($s = $stats->fetch_assoc()):
          $gp = max(1, $s['games_played']);
          $ppg = round($s['total_points'] / $gp, 1);
          $rpg = round($s['total_rebounds'] / $gp, 1);
          $apg = round($s['total_assists'] / $gp, 1);
          $spg = round($s['total_steals'] / $gp, 1);
          $bpg = round($s['total_blocks'] / $gp, 1);
          $fgp = $s['fg_attempted'] > 0 ? round(($s['fg_made'] / $s['fg_attempted']) * 100, 1) : 0;
          $tp = $s['three_attempted'] > 0 ? round(($s['three_made'] / $s['three_attempted']) * 100, 1) : 0;
          $ftp = $s['ft_attempted'] > 0 ? round(($s['ft_made'] / $s['ft_attempted']) * 100, 1) : 0;

          $rowClass = $topScorer ? 'stats-highlight' : '';
          $topScorer = false;
          ?>
          <tr class="<?php echo $rowClass; ?>">
            <td>
              <strong><?php echo sanitize($s['player_name']); ?></strong>
              <?php if ($rowClass): ?>
                <span class="stat-leader"><i class="fas fa-crown"></i> Top Scorer</span>
              <?php endif; ?>
            </td>
            <td><?php echo sanitize($s['team_name'] ?? 'N/A'); ?></td>
            <td><span class="stat-value"><?php echo $s['games_played']; ?></span></td>
            <td><span class="stat-value" style="color: var(--primary);"><?php echo $ppg; ?></span></td>
            <td><span class="stat-value" style="color: var(--secondary);"><?php echo $rpg; ?></span></td>
            <td><span class="stat-value" style="color: var(--info);"><?php echo $apg; ?></span></td>
            <td><span class="stat-value"><?php echo $spg; ?></span></td>
            <td><span class="stat-value"><?php echo $bpg; ?></span></td>
            <td><span class="stat-value"><?php echo $fgp; ?>%</span></td>
            <td><span class="stat-value"><?php echo $tp; ?>%</span></td>
            <td><span class="stat-value"><?php echo $ftp; ?>%</span></td>
            <td>
              <div class="action-links">
                <a href="stats-form.php?id=<?php echo $s['id']; ?>" class="action-link edit">
                  <i class="fas fa-edit"></i> Edit
                </a>
                <a href="delete.php?type=stats&id=<?php echo $s['id']; ?>" class="action-link delete"
                  onclick="return confirm('Delete this statistics record?')">
                  <i class="fas fa-trash"></i> Delete
                </a>
              </div>
            </td>
          </tr>
        <?php endwhile; ?>

        <?php if ($stats->num_rows === 0): ?>
          <tr>
            <td colspan="12">
              <div class="empty-state">
                <i class="fas fa-chart-bar"></i>
                <h3>No Statistics Yet</h3>
                <p>Add player statistics to track performance</p>
                <a href="stats-form.php" class="btn btn-primary">
                  <i class="fas fa-plus"></i> Add Statistics
                </a>
              </div>
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Statistics Legend -->
<div class="admin-card" style="margin-top: 28px;">
  <div class="admin-card-header">
    <h3><i class="fas fa-info-circle"></i> Statistics Legend</h3>
  </div>
  <div class="admin-card-body">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
      <div style="padding: 12px; background: var(--gray-50); border-radius: var(--radius-md);">
        <strong style="color: var(--primary);">GP</strong> - Games Played
      </div>
      <div style="padding: 12px; background: var(--gray-50); border-radius: var(--radius-md);">
        <strong style="color: var(--primary);">PPG</strong> - Points Per Game
      </div>
      <div style="padding: 12px; background: var(--gray-50); border-radius: var(--radius-md);">
        <strong style="color: var(--primary);">RPG</strong> - Rebounds Per Game
      </div>
      <div style="padding: 12px; background: var(--gray-50); border-radius: var(--radius-md);">
        <strong style="color: var(--primary);">APG</strong> - Assists Per Game
      </div>
      <div style="padding: 12px; background: var(--gray-50); border-radius: var(--radius-md);">
        <strong style="color: var(--primary);">SPG</strong> - Steals Per Game
      </div>
      <div style="padding: 12px; background: var(--gray-50); border-radius: var(--radius-md);">
        <strong style="color: var(--primary);">BPG</strong> - Blocks Per Game
      </div>
      <div style="padding: 12px; background: var(--gray-50); border-radius: var(--radius-md);">
        <strong style="color: var(--primary);">FG%</strong> - Field Goal Percentage
      </div>
      <div style="padding: 12px; background: var(--gray-50); border-radius: var(--radius-md);">
        <strong style="color: var(--primary);">3P%</strong> - Three-Point Percentage
      </div>
      <div style="padding: 12px; background: var(--gray-50); border-radius: var(--radius-md);">
        <strong style="color: var(--primary);">FT%</strong> - Free Throw Percentage
      </div>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>