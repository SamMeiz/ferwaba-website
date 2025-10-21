<?php require_once __DIR__ . '/includes/header.php'; ?>

<!-- MEN SECTION -->
<section class="section-title">
  <h2>Rwanda Basketball League - Men's standing</h2>
  <form method="get" style="margin-bottom:12px; max-width:240px;">
    <label for="division_men">Select Division:</label>
    <select name="division_men" id="division_men" onchange="this.form.submit()">
      <option value="Division 1" <?= ($_GET['division_men'] ?? 'Division 1') === 'Division 1' ? 'selected' : '' ?>>Division 1</option>
      <option value="Division 2" <?= ($_GET['division_men'] ?? '') === 'Division 2' ? 'selected' : '' ?>>Division 2</option>
    </select>
  </form>
</section>

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

<div class="card">
  <table>
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

      while($row = $res_men->fetch_assoc()):
        $count++;
        $gp = max(1, (int)$row['games_played']);
        $win_pct = round(((int)$row['wins'] / $gp) * 100, 2);
        $gb = round((($leader_wins - (int)$row['wins']) + ((int)$row['losses'] - $leader_losses)) / 2, 2);

        // Highlight top 3 green, last 3 red
        $total_teams = $res_men->num_rows;
        $row_class = '';
        if($count <= 3) $row_class = 'style="background-color:rgba(0,128,0,0.1);"';
        elseif($count > $total_teams - 3) $row_class = 'style="background-color:rgba(255,0,0,0.1);"';
      ?>
      <tr <?= $row_class ?>>
        <td>
          <a href="team.php?id=<?= $row['team_id'] ?>" style="display:flex;align-items:center;gap:8px">
            <?php if($row['logo']): ?>
              <img src="admin/uploads/<?= sanitize($row['logo']) ?>" style="width:28px;height:28px;border-radius:6px;object-fit:cover">
            <?php endif; ?>
            <?= sanitize($row['name']) ?>
          </a>
        </td>
        <td><?= (int)$row['games_played'] ?></td>
        <td><?= (int)$row['wins'] ?></td>
        <td><?= (int)$row['losses'] ?></td>
        <td><?= (int)$row['points'] ?></td>
        <td><?= number_format($win_pct,2) ?>%</td>
        <td><?= number_format($gb,2) ?></td>
      </tr>
      <?php 
        if($count == 5 && $res_men->num_rows > 5): 
          echo '<tr><td colspan="7" style="text-align:center;"><button onclick="showFull(\'men\')" class="btn">View More</button></td></tr>';
          break;
        endif;
      endwhile; 
      ?>
    </tbody>
  </table>
</div>

<!-- WOMEN SECTION -->
<section class="section-title" style="margin-top:32px;">
  <h2>Rwanda Basketball League - Women's standing</h2>
  <form method="get" style="margin-bottom:12px; max-width:240px;">
    <label for="division_women">Select Division:</label>
    <select name="division_women" id="division_women" onchange="this.form.submit()">
      <option value="Division 1" <?= ($_GET['division_women'] ?? 'Division 1') === 'Division 1' ? 'selected' : '' ?>>Division 1</option>
      <option value="Division 2" <?= ($_GET['division_women'] ?? '') === 'Division 2' ? 'selected' : '' ?>>Division 2</option>
    </select>
  </form>
</section>

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

<div class="card">
  <table>
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

      while($row = $res_women->fetch_assoc()):
        $count++;
        $gp = max(1, (int)$row['games_played']);
        $win_pct = round(((int)$row['wins'] / $gp) * 100, 2);
        $gb = round((($leader_wins - (int)$row['wins']) + ((int)$row['losses'] - $leader_losses)) / 2, 2);

        $total_teams = $res_women->num_rows;
        $row_class = '';
        if($count <= 3) $row_class = 'style="background-color:rgba(0,128,0,0.1);"';
        elseif($count > $total_teams - 3) $row_class = 'style="background-color:rgba(255,0,0,0.1);"';
      ?>
      <tr <?= $row_class ?>>
        <td>
          <a href="team.php?id=<?= $row['team_id'] ?>" style="display:flex;align-items:center;gap:8px">
            <?php if($row['logo']): ?>
              <img src="admin/uploads/<?= sanitize($row['logo']) ?>" style="width:28px;height:28px;border-radius:6px;object-fit:cover">
            <?php endif; ?>
            <?= sanitize($row['name']) ?>
          </a>
        </td>
        <td><?= (int)$row['games_played'] ?></td>
        <td><?= (int)$row['wins'] ?></td>
        <td><?= (int)$row['losses'] ?></td>
        <td><?= (int)$row['points'] ?></td>
        <td><?= number_format($win_pct,2) ?>%</td>
        <td><?= number_format($gb,2) ?></td>
      </tr>
      <?php 
        if($count == 5 && $res_women->num_rows > 5): 
          echo '<tr><td colspan="7" style="text-align:center;"><button onclick="showFull(\'women\')" class="btn">View More</button></td></tr>';
          break;
        endif;
      endwhile; 
      ?>
    </tbody>
  </table>
</div>

<script>
function showFull(section) {
    location.href = location.pathname + (section === 'men' ? '?division_men=<?= $division_men ?>' : '?division_women=<?= $division_women ?>');
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
