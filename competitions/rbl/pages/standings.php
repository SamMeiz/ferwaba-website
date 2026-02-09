<?php require_once __DIR__ . '/../includes/header.php'; ?>

<style>
  /* 🇷🇼 Rwandan Basketball League - Professional Standings */
  :root {
    --rbl-blue: #00A3E0;
    --rbl-yellow: #FCD116;
    --rbl-green: #6DA03F;
    --dark-navy: #0F172A;
    --table-bg: #FFFFFF;
  }

  body {
    background: linear-gradient(rgba(15, 23, 42, 0.9), rgba(15, 23, 42, 0.98)),
      url('../img/rwanda-arena.png') center/cover fixed no-repeat;
    font-family: 'Inter', system-ui, -apple-system, sans-serif;
    color: #fff;
    margin: 0;
    padding: 0;
  }

  .site-main {
    background: transparent !important;
    padding: 100px 0 !important;
    width: 100%;
    overflow-x: hidden;
  }

  .standings-hero {
    text-align: center;
    padding: 40px 20px;
    margin-bottom: 20px;
  }

  .standings-hero h1 {
    font-size: clamp(28px, 6vw, 52px);
    font-weight: 900;
    text-transform: uppercase;
    margin-bottom: 10px;
    background: linear-gradient(to right, #fff, var(--rbl-yellow));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
  }

  .standings-hero p {
    font-size: 14px;
    color: var(--rbl-yellow);
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 2px;
  }

  .standings-grid {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 15px;
    display: flex;
    flex-direction: column;
    gap: 50px;
  }

  .division-card {
    background: var(--table-bg);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    border: 1px solid rgba(255, 255, 255, 0.1);
  }

  .division-header {
    background: var(--rbl-blue);
    padding: 20px 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 4px solid var(--rbl-yellow);
    flex-wrap: wrap;
    gap: 15px;
  }

  .division-header.women {
    background: #5b21b6;
  }

  .division-info {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .division-info i {
    color: var(--rbl-yellow);
    font-size: 20px;
  }

  .division-info h2 {
    font-size: 20px;
    font-weight: 800;
    margin: 0;
    color: #fff;
  }

  .div-toggle-form {
    display: flex;
    background: rgba(0, 0, 0, 0.15);
    padding: 4px;
    border-radius: 10px;
  }

  .div-btn {
    padding: 6px 12px;
    border: none;
    background: transparent;
    color: #fff;
    font-weight: 700;
    cursor: pointer;
    border-radius: 6px;
    font-size: 12px;
  }

  .div-btn.active {
    background: var(--rbl-yellow);
    color: var(--dark-navy);
  }

  /* 📱 THE STANDINGS FIX: TABLE SCROLLING */
  .table-outer-wrapper {
    position: relative;
    width: 100%;
    background: #fff;
  }

  /* Scroll Hint for Mobile */
  .scroll-hint {
    display: none;
    text-align: center;
    padding: 8px;
    background: #f1f5f9;
    color: var(--rbl-blue);
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
  }

  .table-responsive {
    display: block;
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    border-bottom: 1px solid #e2e8f0;
  }

  .rbl-table {
    width: 100%;
    min-width: 700px;
    /* Force the table to be wide enough to justify a scroll */
    border-collapse: collapse;
    table-layout: fixed;
    /* Precise control over column widths */
  }

  /* Column Widths */
  .col-team {
    width: 40%;
    min-width: 220px;
  }

  .col-stat {
    width: 12%;
    min-width: 60px;
  }

  .rbl-table th {
    background: #f8fafc;
    padding: 15px;
    font-size: 11px;
    font-weight: 900;
    text-transform: uppercase;
    color: #64748b;
    border-bottom: 2px solid #e2e8f0;
    text-align: center;
  }

  /* 📍 THE STICKY SOLUTION */
  .rbl-table th:first-child,
  .rbl-table td:first-child {
    position: sticky !important;
    left: 0;
    z-index: 10;
    background: #fff;
    box-shadow: 8px 0 15px -5px rgba(0, 0, 0, 0.08);
    /* Shadow makes the scroll obvious */
  }

  .rbl-table th:first-child {
    background: #f8fafc;
    z-index: 11;
  }

  .rbl-table td {
    padding: 15px;
    border-bottom: 1px solid #f1f5f9;
    font-weight: 700;
    color: var(--dark-navy);
    text-align: center;
    font-size: 14px;
  }

  .rbl-table tr:hover td {
    background: rgba(0, 163, 224, 0.02);
  }

  .team-cell {
    display: flex;
    align-items: center;
    gap: 10px;
    text-align: left;
    padding-left: 5px;
  }

  .rank-box {
    width: 26px;
    height: 26px;
    background: #eee;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 900;
    font-size: 11px;
    color: #666;
    flex-shrink: 0;
  }

  .rank-1,
  .rank-2,
  .rank-3,
  .rank-4 {
    background: var(--rbl-yellow);
    color: var(--dark-navy);
  }

  .team-logo-h {
    width: 30px;
    height: 30px;
    object-fit: contain;
  }

  .team-link {
    font-weight: 800;
    color: var(--dark-navy);
    text-decoration: none;
    font-size: 14px;
    white-space: normal;
    line-height: 1.2;
  }

  .pts-pill {
    background: var(--rbl-blue);
    color: #fff;
    padding: 4px 10px;
    border-radius: 8px;
    font-weight: 900;
  }

  .win-text {
    color: var(--rbl-green);
  }

  .loss-text {
    color: #ef4444;
  }

  .playoff-indicator {
    border-left: 6px solid var(--rbl-green);
  }

  .danger-indicator {
    border-left: 6px solid #ef4444;
  }

  .standings-footer {
    max-width: 800px;
    margin: 40px auto 100px;
    padding: 0 20px;
    display: flex;
    justify-content: center;
    gap: 30px;
    flex-wrap: wrap;
  }

  .legend-pill {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 700;
    font-size: 13px;
    color: #fff;
  }

  .l-color {
    width: 12px;
    height: 12px;
    border-radius: 3px;
  }

  @media (max-width: 768px) {
    .site-main {
      padding: 80px 0 !important;
    }

    .scroll-hint {
      display: block;
      background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
      color: #1a365d;
      font-weight: 900;
      padding: 10px;
      animation: pulse 2s infinite;
    }

    /* Better mobile table layout */
    .col-team {
      width: 45% !important;
      min-width: 160px !important;
    }

    .col-stat {
      min-width: 60px !important;
      width: 13% !important;
    }

    .rbl-table {
      min-width: 600px;
    }

    .team-cell {
      gap: 8px;
    }

    .rank-box {
      width: 24px;
      height: 24px;
      font-size: 10px;
    }

    .team-logo-h {
      width: 26px;
      height: 26px;
    }

    .team-link {
      font-size: 13px;
    }

    .rbl-table th,
    .rbl-table td {
      padding: 12px 8px;
      font-size: 13px;
    }

    .pts-pill {
      padding: 3px 8px;
      font-size: 12px;
    }

    /* Make sticky column shadow more visible on mobile */
    .rbl-table th:first-child,
    .rbl-table td:first-child {
      box-shadow: 10px 0 20px -5px rgba(0, 0, 0, 0.15);
    }

    .division-header {
      padding: 16px 20px;
      flex-direction: column;
      align-items: flex-start;
    }

    .division-info h2 {
      font-size: 18px;
    }

    .standings-hero h1 {
      font-size: 32px;
    }
  }
</style>

<div class="standings-hero">
  <h1>Official Rankings</h1>
  <p>Rwanda Basketball League | 2025/26 Season</p>
</div>

<div class="standings-grid">

  <!-- MEN'S DIVISION -->
  <div class="division-card">
    <div class="division-header">
      <div class="division-info">
        <i class="fas fa-basketball-ball"></i>
        <h2>Men's Division</h2>
      </div>
      <form method="get" class="div-toggle-form">
        <input type="hidden" name="division_women" value="<?= sanitize($_GET['division_women'] ?? 'Division 1') ?>">
        <button type="submit" name="division_men" value="Division 1"
          class="div-btn <?= ($_GET['division_men'] ?? 'Division 1') === 'Division 1' ? 'active' : '' ?>">Div 1</button>
        <button type="submit" name="division_men" value="Division 2"
          class="div-btn <?= ($_GET['division_men'] ?? '') === 'Division 2' ? 'active' : '' ?>">Div 2</button>
      </form>
    </div>

    <div class="table-outer-wrapper">
      <div class="scroll-hint">Swipe right to see stats <i class="fas fa-arrow-right"></i></div>
      <div class="table-responsive">
        <?php
        $division_men = ($_GET['division_men'] ?? 'Division 1');
        $groups_men = ($division_men === 'Division 2') ? ['Group A', 'Group B'] : [null];

        foreach ($groups_men as $current_group):
          if ($current_group)
            echo '<div style="background:#f1f5f9; padding: 10px 25px; border-bottom: 1px solid #e2e8f0; font-weight: 800; color: #1e40af; font-size: 14px; text-transform: uppercase;"><i class="fas fa-layer-group"></i> ' . $current_group . ' Rankings</div>';
          ?>
          <table class="rbl-table" style="<?= $current_group ? 'margin-bottom: 30px;' : '' ?>">
            <colgroup>
              <col class="col-team">
              <col class="col-stat">
              <col class="col-stat">
              <col class="col-stat">
              <col class="col-stat">
              <col class="col-stat">
            </colgroup>
            <thead>
              <tr>
                <th>Team</th>
                <th>GP</th>
                <th>W</th>
                <th>L</th>
                <th>Win %</th>
                <th>Pts</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $group_sql = $current_group ? "AND s.team_group = ?" : "";
              $sql_men = "
                SELECT s.*, t.name, t.logo, t.id AS team_id
                FROM standings s
                JOIN teams t ON t.id = s.team_id
                WHERE s.division=? AND s.gender='Men' $group_sql
                ORDER BY s.points DESC, s.wins DESC, t.name ASC
            ";
              $stmt_men = $mysqli->prepare($sql_men);
              if ($current_group) {
                $stmt_men->bind_param('ss', $division_men, $current_group);
              } else {
                $stmt_men->bind_param('s', $division_men);
              }
              $stmt_men->execute();
              $res_men = $stmt_men->get_result();
              $total_men = $res_men->num_rows;

              if ($total_men === 0): ?>
                <tr>
                  <td colspan="6" style="padding: 60px; color: #94a3b8; text-align: center;">No rankings available for this
                    group.</td>
                </tr>
              <?php else: ?>
                <?php
                $rank = 0;
                while ($row = $res_men->fetch_assoc()):
                  $rank++;
                  $gp = max(1, (int) $row['games_played']);
                  $win_pct = round(((int) $row['wins'] / $gp) * 100, 1);
                  $class = '';
                  if ($rank <= 4)
                    $class = 'playoff-indicator';
                  elseif ($rank > $total_men - 2)
                    $class = 'danger-indicator';
                  ?>
                  <tr class="<?= $class ?>">
                    <td>
                      <div class="team-cell">
                        <div class="rank-box rank-<?= $rank ?>"><?= $rank ?></div>
                        <?php if($division_men !== 'Division 2'): ?>
                        <img src="../../../admin/uploads/<?= $row['logo'] ? sanitize($row['logo']) : 'default-logo.png' ?>"
                          class="team-logo-h" alt="">
                        <?php endif; ?>
                        <a href="team.php?id=<?= $row['team_id'] ?>" class="team-link"><?= sanitize($row['name']) ?></a>
                      </div>
                    </td>
                    <td><?= (int) $row['games_played'] ?></td>
                    <td class="win-text"><?= (int) $row['wins'] ?></td>
                    <td class="loss-text"><?= (int) $row['losses'] ?></td>
                    <td><small><?= $win_pct ?>%</small></td>
                    <td><span class="pts-pill"><?= (int) $row['points'] ?></span></td>
                  </tr>
                <?php endwhile; ?>
              <?php endif; ?>
            </tbody>
          </table>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <!-- WOMEN'S DIVISION -->
  <div class="division-card">
    <div class="division-header women">
      <div class="division-info">
        <i class="fas fa-venus"></i>
        <h2>Women's Division</h2>
      </div>
      <form method="get" class="div-toggle-form">
        <input type="hidden" name="division_men" value="<?= sanitize($_GET['division_men'] ?? 'Division 1') ?>">
        <button type="submit" name="division_women" value="Division 1"
          class="div-btn <?= ($_GET['division_women'] ?? 'Division 1') === 'Division 1' ? 'active' : '' ?>">Div
          1</button>
        <button type="submit" name="division_women" value="Division 2"
          class="div-btn <?= ($_GET['division_women'] ?? '') === 'Division 2' ? 'active' : '' ?>">Div 2</button>
      </form>
    </div>

    <div class="table-outer-wrapper">
      <div class="scroll-hint">Swipe right to see stats <i class="fas fa-arrow-right"></i></div>
      <div class="table-responsive">
        <?php
        $division_women = ($_GET['division_women'] ?? 'Division 1');
        $groups_women = ($division_women === 'Division 2') ? ['Group A', 'Group B'] : [null];

        foreach ($groups_women as $current_group):
            if ($current_group) echo '<div style="background:#fdf2f8; padding: 10px 25px; border-bottom: 1px solid #fbcfe8; font-weight: 800; color: #9d174d; font-size: 14px; text-transform: uppercase;"><i class="fas fa-layer-group"></i> ' . $current_group . ' Rankings</div>';
        ?>
        <table class="rbl-table" style="<?= $current_group ? 'margin-bottom: 30px;' : '' ?>">
          <colgroup>
            <col class="col-team">
            <col class="col-stat">
            <col class="col-stat">
            <col class="col-stat">
            <col class="col-stat">
            <col class="col-stat">
          </colgroup>
          <thead>
            <tr>
              <th>Team</th>
              <th>GP</th>
              <th>W</th>
              <th>L</th>
              <th>Win %</th>
              <th>Pts</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $group_sql = $current_group ? "AND s.team_group = ?" : "";
            $sql_women = "
                SELECT s.*, t.name, t.logo, t.id AS team_id
                FROM standings s
                JOIN teams t ON t.id = s.team_id
                WHERE s.division=? AND s.gender='Women' $group_sql
                ORDER BY s.points DESC, s.wins DESC, t.name ASC
            ";
            $stmt_women = $mysqli->prepare($sql_women);
            if ($current_group) {
                $stmt_women->bind_param('ss', $division_women, $current_group);
            } else {
                $stmt_women->bind_param('s', $division_women);
            }
            $stmt_women->execute();
            $res_women = $stmt_women->get_result();
            $total_women = $res_women->num_rows;

            if ($total_women === 0): ?>
              <tr>
                <td colspan="6" style="padding: 60px; color: #94a3b8; text-align: center;">No rankings available for this group.</td>
              </tr>
            <?php else: ?>
              <?php
              $rank = 0;
              while ($row = $res_women->fetch_assoc()):
                $rank++;
                $gp = max(1, (int) $row['games_played']);
                $win_pct = round(((int) $row['wins'] / $gp) * 100, 1);
                $class = '';
                if ($rank <= 4)
                  $class = 'playoff-indicator';
                elseif ($rank > $total_women - 2)
                  $class = 'danger-indicator';
                ?>
                <tr class="<?= $class ?>">
                   <td>
                    <div class="team-cell">
                      <div class="rank-box rank-<?= $rank ?>"><?= $rank ?></div>
                      <?php if($division_women !== 'Division 2'): ?>
                      <img src="../../../admin/uploads/<?= $row['logo'] ? sanitize($row['logo']) : 'default-logo.png' ?>"
                        class="team-logo-h" alt="">
                      <?php endif; ?>
                      <a href="team.php?id=<?= $row['team_id'] ?>" class="team-link"><?= sanitize($row['name']) ?></a>
                    </div>
                  </td>
                  <td><?= (int) $row['games_played'] ?></td>
                  <td class="win-text"><?= (int) $row['wins'] ?></td>
                  <td class="loss-text"><?= (int) $row['losses'] ?></td>
                  <td><small><?= $win_pct ?>%</small></td>
                  <td><span class="pts-pill"><?= (int) $row['points'] ?></span></td>
                </tr>
              <?php endwhile; ?>
            <?php endif; ?>
          </tbody>
        </table>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

</div>

<div class="standings-footer">
  <div class="legend-pill">
    <div class="l-color" style="background: var(--rbl-green);"></div><span>Playoff Bound</span>
  </div>
  <div class="legend-pill">
    <div class="l-color" style="background: #ef4444;"></div><span>Relegation Risk</span>
  </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>