<?php
require_once __DIR__ . '/../includes/config.php';
require_login();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$editing = $id > 0;

// Fetch all teams
$teams = $mysqli->query("SELECT id, name FROM teams ORDER BY name ASC");

// Fetch existing record if editing
if ($editing) {
  $stmt = $mysqli->prepare("SELECT * FROM standings WHERE id=?");
  $stmt->bind_param('i', $id);
  $stmt->execute();
  $standing = $stmt->get_result()->fetch_assoc();
} else {
  $standing = [
    'team_id' => '',
    'division' => 'Division 1',
    'gender' => 'Men',
    'games_played' => 0,
    'wins' => 0,
    'losses' => 0,
    'points' => 0
  ];
}

// Handle form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $team_id = (int)($_POST['team_id'] ?? 0);
  $division = $_POST['division'] ?? 'Division 1';
  $gender = $_POST['gender'] ?? 'Men';
  $wins = (int)($_POST['wins'] ?? 0);
  $losses = (int)($_POST['losses'] ?? 0);
  $games_played = $wins + $losses;
  $points = ($wins * 2) + ($losses * 1);

  if ($editing) {
    $stmt = $mysqli->prepare("UPDATE standings SET team_id=?, division=?, gender=?, games_played=?, wins=?, losses=?, points=? WHERE id=?");
    $stmt->bind_param('issiiiii', $team_id, $division, $gender, $games_played, $wins, $losses, $points, $id);
  } else {
    $stmt = $mysqli->prepare("INSERT INTO standings (team_id, division, gender, games_played, wins, losses, points) VALUES (?,?,?,?,?,?,?)");
    $stmt->bind_param('issiiii', $team_id, $division, $gender, $games_played, $wins, $losses, $points);
  }

  if ($stmt->execute()) {
    header("Location: standings-list.php");
    exit;
  } else {
    echo "<p style='color:red;'>Database error: " . $mysqli->error . "</p>";
  }
}
?>
<head>
<link rel="stylesheet" href="../css/style.css">
</head>

<section class="section-title">
  <h2><?php echo $editing ? "✏️ Edit Standing" : "➕ Add Standing"; ?></h2>
</section>

<form method="post" class="card grid col-2" style="padding:20px;gap:16px;max-width:800px;">
  <label>Team
    <select name="team_id" required>
      <option value="">Select Team</option>
      <?php while ($t = $teams->fetch_assoc()): ?>
        <option value="<?php echo $t['id']; ?>" <?php if ($t['id'] == $standing['team_id']) echo 'selected'; ?>>
          <?php echo sanitize($t['name']); ?>
        </option>
      <?php endwhile; ?>
    </select>
  </label>

  <label>Division
    <select name="division">
      <option value="Division 1" <?php if ($standing['division'] == 'Division 1') echo 'selected'; ?>>Division 1</option>
      <option value="Division 2" <?php if ($standing['division'] == 'Division 2') echo 'selected'; ?>>Division 2</option>
    </select>
  </label>

  <label>Gender
    <select name="gender">
      <option value="Men" <?php if ($standing['gender'] == 'Men') echo 'selected'; ?>>Men</option>
      <option value="Women" <?php if ($standing['gender'] == 'Women') echo 'selected'; ?>>Women</option>
    </select>
  </label>

  <label>Wins
    <input type="number" name="wins" value="<?php echo $standing['wins']; ?>" required>
  </label>

  <label>Losses
    <input type="number" name="losses" value="<?php echo $standing['losses']; ?>" required>
  </label>

  <div class="col-span-2">
    <button class="btn" type="submit">💾 Save Standing</button>
    <a href="standings-list.php" class="btn secondary">⬅️ Cancel</a>
  </div>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
