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
</form>

<div class="card">
  <table>
    <thead>
      <tr><th>Photo</th><th>Name</th><th>Position</th><th>Jersey</th><th>Club</th><th>Actions</th></tr>
    </thead>
    <tbody>
      <?php while($p = $players->fetch_assoc()): ?>
      <tr>
        <td>
          <?php if ($p['photo']): ?>
            <img src="uploads/<?php echo sanitize($p['photo']); ?>" style="width:50px;height:50px;border-radius:50%;object-fit:cover;">
          <?php endif; ?>
        </td>
        <td><?php echo sanitize($p['name']); ?></td>
        <td><?php echo sanitize($p['position']); ?></td>
        <td><?php echo sanitize($p['jersey_number']); ?></td>
        <td><?php echo sanitize($p['club']); ?></td>
        <td><a href="delete.php?table=national_players&id=<?php echo $p['id']; ?>&team_id=<?php echo $team_id; ?>" onclick="return confirm('Delete player?')">Delete</a></td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>


