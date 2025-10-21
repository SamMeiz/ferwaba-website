<?php
if (!isset($_GET['team_id'])) {
  echo "<div style='margin:20px;color:red'>⚠️ Please add a team first before managing players.</div>";
  exit;
}

require_once __DIR__ . '/../includes/config.php';
require_login();

$team_id = $_GET['team_id'] ?? 0;
if (!$team_id) die("Invalid team.");

$team = $mysqli->query("SELECT team_name FROM national_teams WHERE id=$team_id")->fetch_assoc();
if (!$team) die("Team not found.");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['name']);
  $position = trim($_POST['position']);
  $club = trim($_POST['club']);
  $jersey_number = $_POST['jersey_number'];
  $photo = null;

  if (!empty($_FILES['photo']['name'])) {
    $filename = time().'_'.basename($_FILES['photo']['name']);
    $target = __DIR__ . '/uploads/' . $filename;
    move_uploaded_file($_FILES['photo']['tmp_name'], $target);
    $photo = $filename;
  }

  $stmt = $mysqli->prepare("INSERT INTO national_players (team_id,name,position,jersey_number,club,photo) VALUES (?,?,?,?,?,?)");
  $stmt->bind_param('isisss', $team_id, $name, $position, $jersey_number, $club, $photo);
  $stmt->execute();
}

$players = $mysqli->query("SELECT * FROM national_players WHERE team_id=$team_id ORDER BY jersey_number ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="<?php echo asset_url('../css/style.css'); ?>">
</head>
<section class="section-title">
  <h2><?php echo sanitize($team['team_name']); ?> – Roster</h2>
  <a class="btn" href="national-teams.php">← Back</a>
</section>

<form method="post" enctype="multipart/form-data" class="card" style="margin-bottom:20px;">
  <h3>Add Player</h3>
  <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
    <input type="text" name="name" placeholder="Player name" required>
    <input type="text" name="position" placeholder="Position">
    <input type="number" name="jersey_number" placeholder="Jersey #">
    <input type="text" name="club" placeholder="Club name">
    <input type="file" name="photo" accept="image/*">
  </div>
  <button type="submit" class="btn">Add Player</button>
  <a href="javascript:history.back()" class="btn" style="background:#6b7280;margin-left:8px;">⬅️ Back</a>
</form>

<div class="card">
  <table>
    <thead>
      <tr><th>Photo</th><th>Name</th><th>Position</th><th>Jersey</th><th>Club</th><th>Actions</th></tr>
    </thead>
    <tbody>
  <?php
    $totalTeams = $res->num_rows;
    $rank = 0; // counter to track team position
  ?>
  <?php while($row = $res->fetch_assoc()): ?>
    <?php
      $rank++;
      $gp = max(1, (int)$row['games_played']);
      $win_pct = round(((int)$row['wins'] / $gp) * 100, 2);
      $gb = round((($leader_wins - (int)$row['wins']) + ((int)$row['losses'] - $leader_losses)) / 2, 2);

      // Determine row highlight class
      $rowClass = '';
      if($rank <= 3) {
        $rowClass = 'top-team'; // top 3
      } elseif($rank > $totalTeams - 3) {
        $rowClass = 'bottom-team'; // bottom 3
      }
    ?>
    <tr class="<?= $rowClass ?>">
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
      <td><?= number_format($win_pct, 2) ?>%</td>
      <td><?= number_format($gb, 2) ?></td>
    </tr>
  <?php endwhile; ?>
</tbody>
  </table>
</div>


