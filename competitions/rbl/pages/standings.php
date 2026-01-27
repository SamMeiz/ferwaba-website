<?php require_once __DIR__ . '/../includes/header.php'; ?>

<style>
/* Professional Standings Page */
.page-header {
  background: linear-gradient(135deg, #1a365d 0%, #2c5282 100%);
  padding: 60px 40px;
  margin: -20px -16px 40px -16px;
  border-radius: 0 0 24px 24px;
  text-align: center;
}
.page-header h1 {
  font-size: 42px;
  font-weight: 800;
  color: #fff;
  margin: 0 0 8px 0;
}
.page-header p {
  color: rgba(255,255,255,0.8);
  font-size: 16px;
  margin: 0;
}

.standings-container {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 32px;
}

.standings-card {
  background: #fff;
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 8px 30px rgba(0,0,0,0.08);
}

.standings-header {
  background: linear-gradient(135deg, #1a365d 0%, #2c5282 100%);
  padding: 24px 28px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.standings-header.women {
  background: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%);
}

.standings-title {
  display: flex;
  align-items: center;
  gap: 12px;
}

.standings-title i {
  font-size: 24px;
  color: #fbbf24;
}

.standings-title h3 {
  color: #fff;
  font-size: 20px;
  font-weight: 700;
  margin: 0;
}

.division-select {
  padding: 10px 16px;
  border: 2px solid rgba(255,255,255,0.3);
  border-radius: 10px;
  background: rgba(255,255,255,0.1);
  color: #fff;
  font-size: 14px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s ease;
}

.division-select:hover {
  background: rgba(255,255,255,0.2);
  border-color: rgba(255,255,255,0.5);
}

.division-select option {
  background: #1a365d;
  color: #fff;
}

.standings-table {
  width: 100%;
  border-collapse: collapse;
}

.standings-table th {
  background: #f8fafc;
  padding: 14px 16px;
  text-align: left;
  font-size: 12px;
  font-weight: 700;
  color: #64748b;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  border-bottom: 2px solid #e5e7eb;
}

.standings-table td {
  padding: 16px;
  border-bottom: 1px solid #f1f5f9;
  font-size: 14px;
  color: #1a1a1a;
}

.standings-table tbody tr {
  transition: background 0.2s ease;
}

.standings-table tbody tr:hover {
  background: #f8fafc;
}

.standings-table tbody tr:last-child td {
  border-bottom: none;
}

.team-cell {
  display: flex;
  align-items: center;
  gap: 12px;
}

.team-rank {
  width: 28px;
  height: 28px;
  background: #f1f5f9;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 800;
  font-size: 13px;
  color: #64748b;
}

.rank-1, .rank-2, .rank-3 {
  background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
  color: #1a365d;
}

.team-logo {
  width: 36px;
  height: 36px;
  border-radius: 10px;
  object-fit: cover;
  border: 2px solid #e5e7eb;
}

.team-name-link {
  font-weight: 600;
  color: #1a365d;
  text-decoration: none;
  transition: color 0.2s ease;
}

.team-name-link:hover {
  color: #fbbf24;
}

.stat-cell {
  font-weight: 600;
  text-align: center;
}

.win-cell {
  color: #16a34a;
}

.loss-cell {
  color: #dc2626;
}

.pts-cell {
  background: #f8fafc;
  font-weight: 800;
  color: #1a365d;
}

.playoff-zone {
  background: rgba(34, 197, 94, 0.08) !important;
}

.danger-zone {
  background: rgba(239, 68, 68, 0.08) !important;
}

.view-more-btn {
  display: block;
  width: 100%;
  padding: 16px;
  background: #f8fafc;
  border: none;
  font-size: 14px;
  font-weight: 600;
  color: #1a365d;
  cursor: pointer;
  transition: all 0.2s ease;
}

.view-more-btn:hover {
  background: #1a365d;
  color: #fff;
}

@media (max-width: 1024px) {
  .standings-container {
    grid-template-columns: 1fr;
  }
}

@media (max-width: 768px) {
  .page-header {
    padding: 40px 20px;
    margin: -20px -16px 30px -16px;
  }
  .page-header h1 {
    font-size: 28px;
  }
  .standings-header {
    flex-direction: column;
    gap: 16px;
    text-align: center;
  }
  .standings-table th,
  .standings-table td {
    padding: 12px 10px;
    font-size: 12px;
  }
  .team-logo {
    width: 28px;
    height: 28px;
  }
}
</style>

<div class="page-header">
  <h1><i class="fas fa-trophy"></i> League Standings</h1>
  <p>Current rankings for Rwanda Basketball League 2025-2026 Season</p>
</div>

<div class="standings-container">

<!-- MEN SECTION -->
<div class="standings-card">
  <div class="standings-header">
    <div class="standings-title">
      <i class="fas fa-mars"></i>
      <h3>Men's Division</h3>
    </div>
    <form method="get">
      <select name="division_men" class="division-select" onchange="this.form.submit()">
        <option value="Division 1" <?= ($_GET['division_men'] ?? 'Division 1') === 'Division 1' ? 'selected' : '' ?>>Division 1</option>
        <option value="Division 2" <?= ($_GET['division_men'] ?? '') === 'Division 2' ? 'selected' : '' ?>>Division 2</option>
      </select>
    </form>
  </div>

<?php
$division_men = ($_GET['division_men'] ?? 'Division 1');
$gender_men = 'Men';

$stmt_men = $mysqli->prepare("
    SELECT s.*, t.name, t.logo, t.id AS team_id
    FROM standings s
    JOIN teams t ON t.id = s.team_id
    WHERE s.division=? AND s.gender=?
    ORDER BY s.points DESC, s.wins DESC, t.name ASC
");
$stmt_men->bind_param('ss', $division_men, $gender_men);
$stmt_men->execute();
$res_men = $stmt_men->get_result();
?>

  <table class="standings-table">
    <thead>
      <tr>
        <th>Team</th>
        <th>GP</th>
        <th>W</th>
        <th>L</th>
        <th>Pts</th>
        <th>Win%</th>
        <th>GB</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $count = 0;
      $leader = $res_men->fetch_assoc();
      $leader_wins = $leader['wins'] ?? 0;
      $leader_losses = $leader['losses'] ?? 0;
      $res_men->data_seek(0);
      $total_teams = $res_men->num_rows;

      while($row = $res_men->fetch_assoc()):
        $count++;
        $gp = max(1, (int)$row['games_played']);
        $win_pct = round(((int)$row['wins'] / $gp) * 100, 1);
        $gb = round((($leader_wins - (int)$row['wins']) + ((int)$row['losses'] - $leader_losses)) / 2, 1);
        
        $row_class = '';
        if($count <= 4) $row_class = 'playoff-zone';
        elseif($count > $total_teams - 2) $row_class = 'danger-zone';
      ?>
      <tr class="<?= $row_class ?>">
        <td>
          <div class="team-cell">
            <span class="team-rank <?= $count <= 3 ? 'rank-'.$count : '' ?>"><?= $count ?></span>
            <?php if($row['logo']): ?>
              <img src="../../../admin/uploads/<?= sanitize($row['logo']) ?>" class="team-logo" alt="">
            <?php endif; ?>
            <a href="team.php?id=<?= $row['team_id'] ?>" class="team-name-link">
              <?= sanitize($row['name']) ?>
            </a>
          </div>
        </td>
        <td class="stat-cell"><?= (int)$row['games_played'] ?></td>
        <td class="stat-cell win-cell"><?= (int)$row['wins'] ?></td>
        <td class="stat-cell loss-cell"><?= (int)$row['losses'] ?></td>
        <td class="stat-cell pts-cell"><?= (int)$row['points'] ?></td>
        <td class="stat-cell"><?= $win_pct ?>%</td>
        <td class="stat-cell"><?= $gb == 0 ? '-' : $gb ?></td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<!-- WOMEN SECTION -->
<div class="standings-card">
  <div class="standings-header women">
    <div class="standings-title">
      <i class="fas fa-venus"></i>
      <h3>Women's Division</h3>
    </div>
    <form method="get">
      <select name="division_women" class="division-select" onchange="this.form.submit()">
        <option value="Division 1" <?= ($_GET['division_women'] ?? 'Division 1') === 'Division 1' ? 'selected' : '' ?>>Division 1</option>
        <option value="Division 2" <?= ($_GET['division_women'] ?? '') === 'Division 2' ? 'selected' : '' ?>>Division 2</option>
      </select>
    </form>
  </div>

<?php
$division_women = ($_GET['division_women'] ?? 'Division 1');
$gender_women = 'Women';

$stmt_women = $mysqli->prepare("
    SELECT s.*, t.name, t.logo, t.id AS team_id
    FROM standings s
    JOIN teams t ON t.id = s.team_id
    WHERE s.division=? AND s.gender=?
    ORDER BY s.points DESC, s.wins DESC, t.name ASC
");
$stmt_women->bind_param('ss', $division_women, $gender_women);
$stmt_women->execute();
$res_women = $stmt_women->get_result();
?>

  <table class="standings-table">
    <thead>
      <tr>
        <th>Team</th>
        <th>GP</th>
        <th>W</th>
        <th>L</th>
        <th>Pts</th>
        <th>Win%</th>
        <th>GB</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $count = 0;
      $leader = $res_women->fetch_assoc();
      $leader_wins = $leader['wins'] ?? 0;
      $leader_losses = $leader['losses'] ?? 0;
      $res_women->data_seek(0);
      $total_teams = $res_women->num_rows;

      while($row = $res_women->fetch_assoc()):
        $count++;
        $gp = max(1, (int)$row['games_played']);
        $win_pct = round(((int)$row['wins'] / $gp) * 100, 1);
        $gb = round((($leader_wins - (int)$row['wins']) + ((int)$row['losses'] - $leader_losses)) / 2, 1);
        
        $row_class = '';
        if($count <= 4) $row_class = 'playoff-zone';
        elseif($count > $total_teams - 2) $row_class = 'danger-zone';
      ?>
      <tr class="<?= $row_class ?>">
        <td>
          <div class="team-cell">
            <span class="team-rank <?= $count <= 3 ? 'rank-'.$count : '' ?>"><?= $count ?></span>
            <?php if($row['logo']): ?>
              <img src="../../../admin/uploads/<?= sanitize($row['logo']) ?>" class="team-logo" alt="">
            <?php endif; ?>
            <a href="team.php?id=<?= $row['team_id'] ?>" class="team-name-link">
              <?= sanitize($row['name']) ?>
            </a>
          </div>
        </td>
        <td class="stat-cell"><?= (int)$row['games_played'] ?></td>
        <td class="stat-cell win-cell"><?= (int)$row['wins'] ?></td>
        <td class="stat-cell loss-cell"><?= (int)$row['losses'] ?></td>
        <td class="stat-cell pts-cell"><?= (int)$row['points'] ?></td>
        <td class="stat-cell"><?= $win_pct ?>%</td>
        <td class="stat-cell"><?= $gb == 0 ? '-' : $gb ?></td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

</div> <!-- End standings-container -->

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
