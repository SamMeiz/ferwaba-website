<?php require_once __DIR__ . '/../includes/header.php'; ?>

<style>
.playoff-bracket {
  display: flex;
  gap: 30px;
  overflow-x: auto;
  padding: 20px 0;
}

.playoff-round {
  display: flex;
  flex-direction: column;
  gap: 20px;
  min-width: 260px;
}

.round-header {
  text-align: center;
  padding: 12px 16px;
  background: linear-gradient(135deg, #1a365d 0%, #0f2744 100%);
  color: #fff;
  border-radius: 10px;
  font-weight: 700;
  font-size: 14px;
  text-transform: uppercase;
  letter-spacing: 1px;
}

.round-header i {
  margin-right: 8px;
}

.bracket-match {
  background: #fff;
  border-radius: 12px;
  padding: 16px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.08);
  border: 1px solid #e5e7eb;
  transition: all 0.3s ease;
}

.bracket-match:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 24px rgba(0,0,0,0.12);
}

.match-date {
  font-size: 12px;
  color: #6b7280;
  margin-bottom: 12px;
  display: flex;
  align-items: center;
  gap: 6px;
}

.match-teams {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.team-result {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px 12px;
  background: #f9fafb;
  border-radius: 8px;
  transition: all 0.2s ease;
}

.team-result.winner {
  background: linear-gradient(135deg, rgba(34, 197, 94, 0.15) 0%, rgba(34, 197, 94, 0.08) 100%);
  border: 1px solid #22c55e;
}

.team-result.loser {
  opacity: 0.6;
}

.team-name {
  font-weight: 600;
  font-size: 14px;
  color: #1f2937;
}

.team-score {
  font-weight: 700;
  font-size: 16px;
  color: #1a365d;
  min-width: 28px;
  text-align: center;
}

.team-result.winner .team-score {
  color: #16a34a;
}

.match-status {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  margin-top: 12px;
  padding: 4px 10px;
  border-radius: 20px;
  font-size: 11px;
  font-weight: 600;
  text-transform: uppercase;
}

.status-completed {
  background: #dcfce7;
  color: #166534;
}

.status-scheduled {
  background: #fef3c7;
  color: #92400e;
}

.status-live {
  background: #fee2e2;
  color: #991b1b;
}

.champion-section {
  margin-top: 40px;
  text-align: center;
}

.champion-card {
  display: inline-block;
  padding: 24px 48px;
  background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
  border-radius: 16px;
  box-shadow: 0 10px 40px rgba(251, 191, 36, 0.3);
}

.champion-card h3 {
  margin: 0 0 8px;
  font-size: 14px;
  color: #78350f;
  text-transform: uppercase;
  letter-spacing: 1px;
}

.champion-card .champion-name {
  font-size: 28px;
  font-weight: 800;
  color: #1a365d;
}

.champion-card .trophy-icon {
  font-size: 48px;
  margin-bottom: 12px;
}

.third-place-section {
  margin-top: 20px;
}

.third-place-card {
  display: inline-flex;
  align-items: center;
  gap: 12px;
  padding: 12px 24px;
  background: linear-gradient(135deg, #cd7f32 0%, #b45309 100%);
  border-radius: 10px;
  color: #fff;
}

.third-place-card i {
  font-size: 24px;
}

.third-place-card span {
  font-weight: 700;
  font-size: 16px;
}

@media (max-width: 768px) {
  .playoff-bracket {
    flex-direction: column;
    gap: 20px;
  }

  .playoff-round {
    min-width: 100%;
  }
}
</style>

<section class="section-title" style="margin-bottom: 8px;">
  <h2>BetPawa Playoffs</h2>
  <nav class="category-filter">
    <a class="category-btn" href="games.php">Regular Season</a>
    <a class="category-btn" href="standings.php">Standings</a>
    <a class="category-btn active" href="playoffs.php">Playoffs</a>
  </nav>
</section>

<?php
// Fetch by stage
$stages = ['Quarterfinal', 'Semifinal', 'Final', '3rd Place'];
$byStage = [];
foreach ($stages as $st) {
  $stmt = $mysqli->prepare("SELECT p.*, th.name AS home_name, ta.name AS away_name, tw.name AS winner_name FROM playoffs p LEFT JOIN teams th ON th.id=p.home_team_id LEFT JOIN teams ta ON ta.id=p.away_team_id LEFT JOIN teams tw ON tw.id=p.winner_team_id WHERE p.stage=? ORDER BY p.start_date ASC, p.id ASC");
  $stmt->bind_param('s', $st);
  $stmt->execute();
  $byStage[$st] = $stmt->get_result();
}

// Get champion and 3rd place winner
$champion = null;
$thirdPlace = null;
if ($final = $byStage['Final']->fetch_assoc()) {
  $champion = $final['winner_name'];
  $byStage['Final']->data_seek(0); // Reset cursor
}
if ($tp = $byStage['3rd Place']->fetch_assoc()) {
  $thirdPlace = $tp['winner_name'];
  $byStage['3rd Place']->data_seek(0); // Reset cursor
}
?>

<!-- Champion Banner -->
<?php if ($champion): ?>
<div class="champion-section">
  <div class="champion-card">
    <div class="trophy-icon"><i class="fas fa-trophy"></i></div>
    <h3>League Champion</h3>
    <div class="champion-name"><?php echo sanitize($champion); ?></div>
  </div>
  <?php if ($thirdPlace): ?>
  <div class="third-place-section">
    <div class="third-place-card">
      <i class="fas fa-medal"></i>
      <span>3rd Place: <?php echo sanitize($thirdPlace); ?></span>
    </div>
  </div>
  <?php endif; ?>
</div>
<?php endif; ?>

<!-- Playoff Bracket -->
<div class="playoff-bracket">
  <!-- Quarterfinals -->
  <div class="playoff-round">
    <div class="round-header"><i class="fas fa-th"></i> Quarterfinals</div>
    <?php if ($byStage['Quarterfinal']->num_rows > 0): ?>
      <?php while ($qf = $byStage['Quarterfinal']->fetch_assoc()): ?>
        <div class="bracket-match">
          <div class="match-date"><i class="far fa-calendar"></i> <?php echo date('M d, Y', strtotime($qf['start_date'])); ?></div>
          <div class="match-teams">
            <div class="team-result <?php echo $qf['winner_team_id'] == $qf['home_team_id'] ? 'winner' : ($qf['status'] === 'Completed' ? 'loser' : ''); ?>">
              <span class="team-name"><?php echo sanitize($qf['home_name'] ?? 'TBD'); ?></span>
              <span class="team-score"><?php echo (int)$qf['home_score']; ?></span>
            </div>
            <div class="team-result <?php echo $qf['winner_team_id'] == $qf['away_team_id'] ? 'winner' : ($qf['status'] === 'Completed' ? 'loser' : ''); ?>">
              <span class="team-name"><?php echo sanitize($qf['away_name'] ?? 'TBD'); ?></span>
              <span class="team-score"><?php echo (int)$qf['away_score']; ?></span>
            </div>
          </div>
          <span class="match-status status-<?php echo strtolower($qf['status']); ?>"><?php echo sanitize($qf['status']); ?></span>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <div class="bracket-match" style="text-align: center; color: #6b7280;">
        <i class="fas fa-clock"></i> Coming soon
      </div>
    <?php endif; ?>
  </div>

  <!-- Semifinals -->
  <div class="playoff-round">
    <div class="round-header"><i class="fas fa-bolt"></i> Semifinals</div>
    <?php if ($byStage['Semifinal']->num_rows > 0): ?>
      <?php while ($sf = $byStage['Semifinal']->fetch_assoc()): ?>
        <div class="bracket-match">
          <div class="match-date"><i class="far fa-calendar"></i> <?php echo date('M d, Y', strtotime($sf['start_date'])); ?></div>
          <div class="match-teams">
            <div class="team-result <?php echo $sf['winner_team_id'] == $sf['home_team_id'] ? 'winner' : ($sf['status'] === 'Completed' ? 'loser' : ''); ?>">
              <span class="team-name"><?php echo sanitize($sf['home_name'] ?? 'TBD'); ?></span>
              <span class="team-score"><?php echo (int)$sf['home_score']; ?></span>
            </div>
            <div class="team-result <?php echo $sf['winner_team_id'] == $sf['away_team_id'] ? 'winner' : ($sf['status'] === 'Completed' ? 'loser' : ''); ?>">
              <span class="team-name"><?php echo sanitize($sf['away_name'] ?? 'TBD'); ?></span>
              <span class="team-score"><?php echo (int)$sf['away_score']; ?></span>
            </div>
          </div>
          <span class="match-status status-<?php echo strtolower($sf['status']); ?>"><?php echo sanitize($sf['status']); ?></span>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <div class="bracket-match" style="text-align: center; color: #6b7280;">
        <i class="fas fa-clock"></i> Coming soon
      </div>
    <?php endif; ?>
  </div>

  <!-- Final -->
  <div class="playoff-round">
    <div class="round-header"><i class="fas fa-crown"></i> Final</div>
    <?php if ($byStage['Final']->num_rows > 0): ?>
      <?php while ($f = $byStage['Final']->fetch_assoc()): ?>
        <div class="bracket-match">
          <div class="match-date"><i class="far fa-calendar"></i> <?php echo date('M d, Y', strtotime($f['start_date'])); ?></div>
          <div class="match-teams">
            <div class="team-result <?php echo $f['winner_team_id'] == $f['home_team_id'] ? 'winner' : ($f['status'] === 'Completed' ? 'loser' : ''); ?>">
              <span class="team-name"><?php echo sanitize($f['home_name'] ?? 'TBD'); ?></span>
              <span class="team-score"><?php echo (int)$f['home_score']; ?></span>
            </div>
            <div class="team-result <?php echo $f['winner_team_id'] == $f['away_team_id'] ? 'winner' : ($f['status'] === 'Completed' ? 'loser' : ''); ?>">
              <span class="team-name"><?php echo sanitize($f['away_name'] ?? 'TBD'); ?></span>
              <span class="team-score"><?php echo (int)$f['away_score']; ?></span>
            </div>
          </div>
          <span class="match-status status-<?php echo strtolower($f['status']); ?>"><?php echo sanitize($f['status']); ?></span>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <div class="bracket-match" style="text-align: center; color: #6b7280;">
        <i class="fas fa-clock"></i> Coming soon
      </div>
    <?php endif; ?>
  </div>

  <!-- 3rd Place -->
  <div class="playoff-round">
    <div class="round-header" style="background: linear-gradient(135deg, #cd7f32 0%, #b45309 100%);"><i class="fas fa-medal"></i> 3rd Place</div>
    <?php if ($byStage['3rd Place']->num_rows > 0): ?>
      <?php while ($tp = $byStage['3rd Place']->fetch_assoc()): ?>
        <div class="bracket-match">
          <div class="match-date"><i class="far fa-calendar"></i> <?php echo date('M d, Y', strtotime($tp['start_date'])); ?></div>
          <div class="match-teams">
            <div class="team-result <?php echo $tp['winner_team_id'] == $tp['home_team_id'] ? 'winner' : ($tp['status'] === 'Completed' ? 'loser' : ''); ?>">
              <span class="team-name"><?php echo sanitize($tp['home_name'] ?? 'TBD'); ?></span>
              <span class="team-score"><?php echo (int)$tp['home_score']; ?></span>
            </div>
            <div class="team-result <?php echo $tp['winner_team_id'] == $tp['away_team_id'] ? 'winner' : ($tp['status'] === 'Completed' ? 'loser' : ''); ?>">
              <span class="team-name"><?php echo sanitize($tp['away_name'] ?? 'TBD'); ?></span>
              <span class="team-score"><?php echo (int)$tp['away_score']; ?></span>
            </div>
          </div>
          <span class="match-status status-<?php echo strtolower($tp['status']); ?>"><?php echo sanitize($tp['status']); ?></span>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <div class="bracket-match" style="text-align: center; color: #6b7280;">
        <i class="fas fa-clock"></i> Coming soon
      </div>
    <?php endif; ?>
  </div>
</div>

<!-- Champion History -->
<section id="history" style="margin-top: 60px;">
  <div class="section-title"><h2>Champion History</h2></div>
  <div class="card">
    <div class="card-body" style="text-align: center; padding: 40px;">
      <i class="fas fa-history" style="font-size: 48px; color: #d1d5db; margin-bottom: 16px;"></i>
      <h3 style="color: #6b7280; margin-bottom: 8px;">Historical Data</h3>
      <p style="color: #9ca3af;">Previous season champions will be displayed here.</p>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
