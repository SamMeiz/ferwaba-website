<?php
require_once __DIR__ . '/../includes/bootstrap.php';
require_login();

$id = isset($_GET['id']) && ctype_digit($_GET['id']) ? (int) $_GET['id'] : 0;
$editing = $id > 0;

$error = '';
$csrf_token = generate_csrf_token();

try {
  // Fetch all teams
  $teams = $db->query("SELECT id, name FROM teams ORDER BY name ASC")->fetchAll();

  // Fetch existing record if editing
  if ($editing) {
    $stmt = $db->prepare("SELECT * FROM standings WHERE id=?");
    $stmt->execute([$id]);
    $standing = $stmt->fetch();
    if (!$standing) {
      redirect('standings-list.php');
    }
  } else {
    $standing = [
      'team_id' => '',
      'division' => 'Division 1',
      'gender' => 'Men',
      'games_played' => 0,
      'wins' => 0,
      'losses' => 0,
      'points' => 0,
      'team_group' => ''
    ];
  }

  // Handle form submit
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf_token();
    $team_id = (int) ($_POST['team_id'] ?? 0);
    $division = $_POST['division'] ?? 'Division 1';
    $gender = $_POST['gender'] ?? 'Men';
    $team_group = !empty($_POST['team_group']) ? $_POST['team_group'] : null;
    $wins = (int) ($_POST['wins'] ?? 0);
    $losses = (int) ($_POST['losses'] ?? 0);
    $games_played = $wins + $losses;
    $points = ($wins * 2) + ($losses * 1);

    if ($editing) {
      $stmt = $db->prepare("UPDATE standings SET team_id=?, division=?, gender=?, team_group=?, games_played=?, wins=?, losses=?, points=? WHERE id=?");
      $stmt->execute([$team_id, $division, $gender, $team_group, $games_played, $wins, $losses, $points, $id]);
      audit_log($db, 'Edit Standings', "Updated standings for team ID: $team_id (ID: $id)");
    } else {
      $stmt = $db->prepare("INSERT INTO standings (team_id, division, gender, team_group, games_played, wins, losses, points) VALUES (?,?,?,?,?,?,?,?)");
      $stmt->execute([$team_id, $division, $gender, $team_group, $games_played, $wins, $losses, $points]);
      $newId = $db->lastInsertId();
      audit_log($db, 'Add Standings', "Created standings for team ID: $team_id (ID: $newId)");
    }

    redirect('standings-list.php');
  }
} catch (PDOException $e) {
  error_log("Standings Form Error: " . $e->getMessage());
  $error = 'A database error occurred.';
}
?>

<head>
  <link rel="stylesheet" href="../css/admin.css">
</head>

<section class="section-title">
  <h2><?php echo $editing ? "✏️ Edit Standing" : "➕ Add Standing"; ?></h2>
</section>

<form method="post" class="card grid col-2" style="padding:20px;gap:16px;max-width:800px;">
  <input type="hidden" name="csrf_token" value="<?php echo sanitize($csrf_token); ?>">
  <label>Team
    <select name="team_id" required>
      <option value="">Select Team</option>
      <?php foreach ($teams as $t): ?>
        <option value="<?php echo $t['id']; ?>" <?php if ($t['id'] == $standing['team_id'])
             echo 'selected'; ?>>
          <?php echo sanitize($t['name']); ?>
        </option>
      <?php endforeach; ?>
    </select>
  </label>

  <label>Division
    <select name="division">
      <option value="Division 1" <?php if ($standing['division'] == 'Division 1')
        echo 'selected'; ?>>Division 1</option>
      <option value="Division 2" <?php if ($standing['division'] == 'Division 2')
        echo 'selected'; ?>>Division 2</option>
    </select>
  </label>

  <label>Gender
    <select name="gender">
      <option value="Men" <?php if ($standing['gender'] == 'Men')
        echo 'selected'; ?>>Men</option>
      <option value="Women" <?php if ($standing['gender'] == 'Women')
        echo 'selected'; ?>>Women</option>
    </select>
  </label>

  <label>Group (For Div 2)
    <select name="team_group">
      <option value="">No Group</option>
      <option value="Group A" <?php if (($standing['team_group'] ?? '') == 'Group A')
        echo 'selected'; ?>>Group A</option>
      <option value="Group B" <?php if (($standing['team_group'] ?? '') == 'Group B')
        echo 'selected'; ?>>Group B</option>
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

<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>
