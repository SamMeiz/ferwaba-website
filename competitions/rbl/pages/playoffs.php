<?php require_once __DIR__ . '/../includes/header.php'; ?>

<style>
  /* Enhanced Playoff Bracket Styles */
  .playoff-container {
    background: rgba(255, 255, 255, 0.7);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 40px 20px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.8);
    overflow-x: auto;
    overflow-y: visible;
    -webkit-overflow-scrolling: touch;
  }

  .playoff-bracket {
    display: flex;
    gap: 40px;
    padding: 30px 20px;
    justify-content: flex-start;
    align-items: center;
    min-width: max-content;
    width: fit-content;
  }

  .playoff-round {
    display: flex;
    flex-direction: column;
    gap: 30px;
    min-width: 320px;
    position: relative;
  }

  .round-header {
    text-align: center;
    padding: 16px 24px;
    background: linear-gradient(135deg, #1a365d 0%, #2563eb 100%);
    color: #fff;
    border-radius: 16px;
    font-weight: 800;
    font-size: 16px;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    box-shadow: 0 8px 24px rgba(37, 99, 235, 0.3);
    position: relative;
    overflow: hidden;
  }

  .round-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    animation: shimmer 3s infinite;
  }

  @keyframes shimmer {
    0% {
      left: -100%;
    }

    100% {
      left: 100%;
    }
  }

  .round-header i {
    margin-right: 10px;
    font-size: 18px;
  }

  .bracket-match {
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    border-radius: 16px;
    padding: 20px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
    border: 2px solid #e2e8f0;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
  }

  .bracket-match::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #3b82f6, #8b5cf6, #ec4899);
    opacity: 0;
    transition: opacity 0.3s ease;
  }

  .bracket-match:hover {
    transform: translateY(-6px) scale(1.02);
    box-shadow: 0 16px 48px rgba(0, 0, 0, 0.15);
    border-color: #3b82f6;
  }

  .bracket-match:hover::before {
    opacity: 1;
  }

  .series-info {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
    padding-bottom: 12px;
    border-bottom: 2px dashed #e2e8f0;
  }

  .match-date {
    font-size: 13px;
    color: #64748b;
    display: flex;
    align-items: center;
    gap: 6px;
    font-weight: 600;
  }

  .series-score {
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
    color: #78350f;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 800;
    letter-spacing: 0.5px;
    box-shadow: 0 4px 12px rgba(251, 191, 36, 0.3);
  }

  .match-teams {
    display: flex;
    flex-direction: column;
    gap: 12px;
  }

  .team-result {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px 16px;
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border-radius: 12px;
    transition: all 0.3s ease;
    border: 2px solid transparent;
  }

  .team-result.winner {
    background: linear-gradient(135deg, rgba(34, 197, 94, 0.15) 0%, rgba(34, 197, 94, 0.05) 100%);
    border: 2px solid #22c55e;
    box-shadow: 0 4px 16px rgba(34, 197, 94, 0.2);
  }

  .team-result.winner .team-name {
    color: #15803d;
  }

  .team-result.loser {
    opacity: 0.5;
  }

  .team-name {
    font-weight: 700;
    font-size: 15px;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .team-name i {
    color: #3b82f6;
  }

  .team-score {
    font-weight: 800;
    font-size: 20px;
    color: #1a365d;
    min-width: 36px;
    text-align: center;
    background: white;
    padding: 4px 12px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  }

  .team-result.winner .team-score {
    color: #16a34a;
    background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
  }

  .match-status {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    margin-top: 14px;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .status-completed {
    background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
    color: #166534;
  }

  .status-scheduled {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    color: #92400e;
  }

  .status-live {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    color: #991b1b;
    animation: pulse 2s infinite;
  }

  @keyframes pulse {

    0%,
    100% {
      opacity: 1;
    }

    50% {
      opacity: 0.7;
    }
  }

  .champion-section {
    margin-top: 50px;
    text-align: center;
  }

  .champion-card {
    display: inline-block;
    padding: 40px 60px;
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
    border-radius: 24px;
    box-shadow: 0 20px 60px rgba(251, 191, 36, 0.4);
    position: relative;
    overflow: hidden;
  }

  .champion-card::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.2) 0%, transparent 70%);
    animation: rotate 10s linear infinite;
  }

  @keyframes rotate {
    0% {
      transform: rotate(0deg);
    }

    100% {
      transform: rotate(360deg);
    }
  }

  .champion-card h3 {
    margin: 0 0 12px;
    font-size: 16px;
    color: #78350f;
    text-transform: uppercase;
    letter-spacing: 2px;
    position: relative;
    z-index: 1;
  }

  .champion-card .champion-name {
    font-size: 36px;
    font-weight: 900;
    color: #1a365d;
    position: relative;
    z-index: 1;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
  }

  .champion-card .trophy-icon {
    font-size: 64px;
    margin-bottom: 16px;
    position: relative;
    z-index: 1;
    animation: bounce 2s infinite;
  }

  @keyframes bounce {

    0%,
    100% {
      transform: translateY(0);
    }

    50% {
      transform: translateY(-10px);
    }
  }

  .third-place-section {
    margin-top: 24px;
  }

  .third-place-card {
    display: inline-flex;
    align-items: center;
    gap: 14px;
    padding: 16px 32px;
    background: linear-gradient(135deg, #cd7f32 0%, #b45309 100%);
    border-radius: 16px;
    color: #fff;
    box-shadow: 0 8px 24px rgba(205, 127, 50, 0.3);
  }

  .third-place-card i {
    font-size: 28px;
  }

  .third-place-card span {
    font-weight: 800;
    font-size: 18px;
  }

  .connector-line {
    position: absolute;
    width: 40px;
    height: 2px;
    background: linear-gradient(90deg, #cbd5e1, transparent);
    top: 50%;
    right: -40px;
    z-index: -1;
  }

  @media (max-width: 768px) {
    .playoff-bracket {
      flex-direction: column;
      gap: 30px;
    }

    .playoff-round {
      min-width: 100%;
    }

    .connector-line {
      display: none;
    }

    .bracket-match {
      padding: 16px;
    }

    .round-header {
      font-size: 14px;
      padding: 12px 16px;
    }

    .team-name {
      font-size: 13px;
    }

    .team-score {
      font-size: 18px;
    }

    .series-score {
      font-size: 11px;
      padding: 4px 10px;
    }

    .champion-card {
      padding: 30px 40px;
    }

    .champion-card .trophy-icon {
      font-size: 48px;
    }

    .champion-card .champion-name {
      font-size: 28px;
    }
  }

</style>

<section class="section-title" style="margin-bottom: 12px;">
  <h2>🏆 BetPawa Playoffs</h2>
  <nav class="category-filter">
    <a class="category-btn" href="games">Regular Season</a>
    <a class="category-btn" href="standings">Standings</a>
    <a class="category-btn active" href="playoffs">Playoffs</a>
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
<div class="playoff-container">
  <div class="playoff-bracket">
    <!-- Quarterfinals -->
    <div class="playoff-round">
      <div class="round-header"><i class="fas fa-th"></i> Quarterfinals</div>
      <?php if ($byStage['Quarterfinal']->num_rows > 0): ?>
        <?php while ($qf = $byStage['Quarterfinal']->fetch_assoc()): ?>
          <div class="bracket-match">
            <div class="series-info">
              <div class="match-date"><i class="far fa-calendar"></i>
                <?php echo date('M d, Y', strtotime($qf['start_date'])); ?></div>
              <?php if (isset($qf['series_format']) && $qf['series_format']): ?>
                <div class="series-score">Best of <?php echo (int) $qf['series_format']; ?></div>
              <?php endif; ?>
            </div>
            <div class="match-teams">
              <div
                class="team-result <?php echo $qf['winner_team_id'] == $qf['home_team_id'] ? 'winner' : ($qf['status'] === 'Completed' ? 'loser' : ''); ?>">
                <span class="team-name"><i class="fas fa-basketball-ball"></i>
                  <?php echo sanitize($qf['home_name'] ?? 'TBD'); ?></span>
                <span class="team-score"><?php echo (int) $qf['home_score']; ?></span>
              </div>
              <div
                class="team-result <?php echo $qf['winner_team_id'] == $qf['away_team_id'] ? 'winner' : ($qf['status'] === 'Completed' ? 'loser' : ''); ?>">
                <span class="team-name"><i class="fas fa-basketball-ball"></i>
                  <?php echo sanitize($qf['away_name'] ?? 'TBD'); ?></span>
                <span class="team-score"><?php echo (int) $qf['away_score']; ?></span>
              </div>
            </div>
            <span
              class="match-status status-<?php echo strtolower($qf['status']); ?>"><?php echo sanitize($qf['status']); ?></span>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <div class="bracket-match" style="text-align: center; color: #64748b;">
          <i class="fas fa-clock"></i> Coming soon
        </div>
      <?php endif; ?>
      <div class="connector-line"></div>
    </div>

    <!-- Semifinals -->
    <div class="playoff-round">
      <div class="round-header"><i class="fas fa-bolt"></i> Semifinals</div>
      <?php if ($byStage['Semifinal']->num_rows > 0): ?>
        <?php while ($sf = $byStage['Semifinal']->fetch_assoc()): ?>
          <div class="bracket-match">
            <div class="series-info">
              <div class="match-date"><i class="far fa-calendar"></i>
                <?php echo date('M d, Y', strtotime($sf['start_date'])); ?></div>
              <?php if (isset($sf['series_format']) && $sf['series_format']): ?>
                <div class="series-score">Best of <?php echo (int) $sf['series_format']; ?></div>
              <?php endif; ?>
            </div>
            <div class="match-teams">
              <div
                class="team-result <?php echo $sf['winner_team_id'] == $sf['home_team_id'] ? 'winner' : ($sf['status'] === 'Completed' ? 'loser' : ''); ?>">
                <span class="team-name"><i class="fas fa-basketball-ball"></i>
                  <?php echo sanitize($sf['home_name'] ?? 'TBD'); ?></span>
                <span class="team-score"><?php echo (int) $sf['home_score']; ?></span>
              </div>
              <div
                class="team-result <?php echo $sf['winner_team_id'] == $sf['away_team_id'] ? 'winner' : ($sf['status'] === 'Completed' ? 'loser' : ''); ?>">
                <span class="team-name"><i class="fas fa-basketball-ball"></i>
                  <?php echo sanitize($sf['away_name'] ?? 'TBD'); ?></span>
                <span class="team-score"><?php echo (int) $sf['away_score']; ?></span>
              </div>
            </div>
            <span
              class="match-status status-<?php echo strtolower($sf['status']); ?>"><?php echo sanitize($sf['status']); ?></span>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <div class="bracket-match" style="text-align: center; color: #64748b;">
          <i class="fas fa-clock"></i> Coming soon
        </div>
      <?php endif; ?>
      <div class="connector-line"></div>
    </div>

    <!-- Final -->
    <div class="playoff-round">
      <div class="round-header"><i class="fas fa-crown"></i> Final</div>
      <?php if ($byStage['Final']->num_rows > 0): ?>
        <?php while ($f = $byStage['Final']->fetch_assoc()): ?>
          <div class="bracket-match">
            <div class="series-info">
              <div class="match-date"><i class="far fa-calendar"></i>
                <?php echo date('M d, Y', strtotime($f['start_date'])); ?>
              </div>
              <?php if (isset($f['series_format']) && $f['series_format']): ?>
                <div class="series-score">Best of <?php echo (int) $f['series_format']; ?></div>
              <?php endif; ?>
            </div>
            <div class="match-teams">
              <div
                class="team-result <?php echo $f['winner_team_id'] == $f['home_team_id'] ? 'winner' : ($f['status'] === 'Completed' ? 'loser' : ''); ?>">
                <span class="team-name"><i class="fas fa-basketball-ball"></i>
                  <?php echo sanitize($f['home_name'] ?? 'TBD'); ?></span>
                <span class="team-score"><?php echo (int) $f['home_score']; ?></span>
              </div>
              <div
                class="team-result <?php echo $f['winner_team_id'] == $f['away_team_id'] ? 'winner' : ($f['status'] === 'Completed' ? 'loser' : ''); ?>">
                <span class="team-name"><i class="fas fa-basketball-ball"></i>
                  <?php echo sanitize($f['away_name'] ?? 'TBD'); ?></span>
                <span class="team-score"><?php echo (int) $f['away_score']; ?></span>
              </div>
            </div>
            <span
              class="match-status status-<?php echo strtolower($f['status']); ?>"><?php echo sanitize($f['status']); ?></span>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <div class="bracket-match" style="text-align: center; color: #64748b;">
          <i class="fas fa-clock"></i> Coming soon
        </div>
      <?php endif; ?>
    </div>

    <!-- 3rd Place -->
    <div class="playoff-round">
      <div class="round-header" style="background: linear-gradient(135deg, #cd7f32 0%, #b45309 100%);"><i
          class="fas fa-medal"></i> 3rd Place</div>
      <?php if ($byStage['3rd Place']->num_rows > 0): ?>
        <?php while ($tp = $byStage['3rd Place']->fetch_assoc()): ?>
          <div class="bracket-match">
            <div class="series-info">
              <div class="match-date"><i class="far fa-calendar"></i>
                <?php echo date('M d, Y', strtotime($tp['start_date'])); ?></div>
              <?php if (isset($tp['series_format']) && $tp['series_format']): ?>
                <div class="series-score">Best of <?php echo (int) $tp['series_format']; ?></div>
              <?php endif; ?>
            </div>
            <div class="match-teams">
              <div
                class="team-result <?php echo $tp['winner_team_id'] == $tp['home_team_id'] ? 'winner' : ($tp['status'] === 'Completed' ? 'loser' : ''); ?>">
                <span class="team-name"><i class="fas fa-basketball-ball"></i>
                  <?php echo sanitize($tp['home_name'] ?? 'TBD'); ?></span>
                <span class="team-score"><?php echo (int) $tp['home_score']; ?></span>
              </div>
              <div
                class="team-result <?php echo $tp['winner_team_id'] == $tp['away_team_id'] ? 'winner' : ($tp['status'] === 'Completed' ? 'loser' : ''); ?>">
                <span class="team-name"><i class="fas fa-basketball-ball"></i>
                  <?php echo sanitize($tp['away_name'] ?? 'TBD'); ?></span>
                <span class="team-score"><?php echo (int) $tp['away_score']; ?></span>
              </div>
            </div>
            <span
              class="match-status status-<?php echo strtolower($tp['status']); ?>"><?php echo sanitize($tp['status']); ?></span>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <div class="bracket-match" style="text-align: center; color: #64748b;">
          <i class="fas fa-clock"></i> Coming soon
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<!-- Champion History -->
<section id="history" style="margin-top: 60px;">
  <div class="section-title">
    <h2>📜 Champion History</h2>
  </div>
  <div class="card" style="background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px);">
    <div class="card-body" style="text-align: center; padding: 50px;">
      <i class="fas fa-history" style="font-size: 56px; color: #cbd5e1; margin-bottom: 20px;"></i>
      <h3 style="color: #64748b; margin-bottom: 12px; font-size: 20px;">Historical Data</h3>
      <p style="color: #94a3b8; font-size: 15px;">Previous season champions will be displayed here.</p>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
