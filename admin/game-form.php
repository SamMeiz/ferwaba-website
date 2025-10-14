<?php require_once __DIR__ . '/../includes/config.php';
require_login();

$id = isset($_GET['id']) && ctype_digit($_GET['id']) ? (int)$_GET['id'] : 0;
$editing = $id > 0;

$home_team_id = $away_team_id = null;
$game_date = date('Y-m-d');
$location = '';
$home_score = 0; $away_score = 0;
$division = 'Division 1'; $gender = 'Men'; $status = 'Scheduled';
$highlight_url = '';
$error='';

$teams = $mysqli->query("SELECT id,name,division,gender FROM teams ORDER BY name ASC");

if ($editing) {
  $stmt = $mysqli->prepare("SELECT * FROM games WHERE id=? LIMIT 1");
  $stmt->bind_param('i',$id);
  $stmt->execute();
  $res = $stmt->get_result();
  if ($g = $res->fetch_assoc()) {
    $home_team_id = (int)$g['home_team_id'];
    $away_team_id = (int)$g['away_team_id'];
    $game_date = $g['game_date'];
    $location = $g['location'];
    $home_score = (int)$g['home_score'];
    $away_score = (int)$g['away_score'];
    $division = $g['division'];
    $gender = $g['gender'];
    $status = $g['status'];
    $highlight_url = $g['highlight_url'];
  } else { die('Game not found'); }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $home_team_id = isset($_POST['home_team_id']) && ctype_digit($_POST['home_team_id']) ? (int)$_POST['home_team_id'] : null;
  $away_team_id = isset($_POST['away_team_id']) && ctype_digit($_POST['away_team_id']) ? (int)$_POST['away_team_id'] : null;
  $game_date = $_POST['game_date'] ?? $game_date;
  $location = trim($_POST['location'] ?? '');
  $home_score = (int)($_POST['home_score'] ?? 0);
  $away_score = (int)($_POST['away_score'] ?? 0);
  $division = in_array(($_POST['division'] ?? ''), ['Division 1','Division 2']) ? $_POST['division'] : 'Division 1';
  $gender = in_array(($_POST['gender'] ?? ''), ['Men','Women']) ? $_POST['gender'] : 'Men';
  $status = in_array(($_POST['status'] ?? ''), ['Scheduled','Completed']) ? $_POST['status'] : 'Scheduled';
  $highlight_url = trim($_POST['highlight_url'] ?? '');

  if (!$home_team_id || !$away_team_id || $home_team_id===$away_team_id) {
    $error = 'Select distinct Home and Away teams.';
  }

  if (!$error) {
    if ($editing) {
      $stmt = $mysqli->prepare("UPDATE games SET home_team_id=?,away_team_id=?,game_date=?,location=?,home_score=?,away_score=?,division=?,gender=?,status=?,highlight_url=? WHERE id=? LIMIT 1");
      $stmt->bind_param('iissiiisssi', $home_team_id,$away_team_id,$game_date,$location,$home_score,$away_score,$division,$gender,$status,$highlight_url,$id);
      if ($stmt->execute()) {
        recalc_standings_for_game_change($mysqli, $id);
        redirect('games.php');
      } else { $error='Failed to save game.'; }
    } else {
      $stmt = $mysqli->prepare("INSERT INTO games(home_team_id,away_team_id,game_date,location,home_score,away_score,division,gender,status,highlight_url) VALUES(?,?,?,?,?,?,?,?,?,?)");
      $stmt->bind_param('iissiiisss', $home_team_id,$away_team_id,$game_date,$location,$home_score,$away_score,$division,$gender,$status,$highlight_url);
      if ($stmt->execute()) {
        $newId = $stmt->insert_id;
        recalc_standings_for_game_change($mysqli, $newId);
        redirect('games.php');
      } else { $error='Failed to create game.'; }
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $editing? 'Edit':'Add'; ?> Game - FERWABA</title>
  <link rel="stylesheet" href="<?php echo asset_url('../css/style.css'); ?>">
</head>
<body>
<div class="container" style="max-width:840px;margin:24px auto">
  <div class="card"><div class="card-body">
    <h2 style="margin:0 0 12px"><?php echo $editing? 'Edit':'Add'; ?> Game</h2>
    <?php if($error): ?><div style="color:#b91c1c;margin-bottom:8px"><?php echo sanitize($error); ?></div><?php endif; ?>
    <form method="post">
      <div class="grid col-2" style="margin-bottom:8px">
        <div>
          <label>Home Team</label>
          <select name="home_team_id" required style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:8px">
            <?php $teams->data_seek(0); while($t=$teams->fetch_assoc()): ?>
            <option value="<?php echo (int)$t['id']; ?>" <?php echo ($home_team_id==(int)$t['id'])?'selected':''; ?>><?php echo sanitize($t['name']); ?></option>
            <?php endwhile; ?>
          </select>
        </div>
        <div>
          <label>Away Team</label>
          <select name="away_team_id" required style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:8px">
            <?php $teams->data_seek(0); while($t=$teams->fetch_assoc()): ?>
            <option value="<?php echo (int)$t['id']; ?>" <?php echo ($away_team_id==(int)$t['id'])?'selected':''; ?>><?php echo sanitize($t['name']); ?></option>
            <?php endwhile; ?>
          </select>
        </div>
      </div>
      <div class="grid col-3" style="margin-bottom:8px">
        <div>
          <label>Date</label>
          <input type="date" name="game_date" value="<?php echo sanitize($game_date); ?>" required style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:8px">
        </div>
        <div>
          <label>Division</label>
          <select name="division" style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:8px">
            <option <?php echo $division==='Division 1'?'selected':''; ?>>Division 1</option>
            <option <?php echo $division==='Division 2'?'selected':''; ?>>Division 2</option>
          </select>
        </div>
        <div>
          <label>Gender</label>
          <select name="gender" style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:8px">
            <option <?php echo $gender==='Men'?'selected':''; ?>>Men</option>
            <option <?php echo $gender==='Women'?'selected':''; ?>>Women</option>
          </select>
        </div>
      </div>
      <div style="margin-bottom:8px">
        <label>Location</label>
        <input type="text" name="location" value="<?php echo sanitize($location); ?>" style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:8px">
      </div>
      <div class="grid col-3" style="margin-bottom:8px">
        <div>
          <label>Home Score</label>
          <input type="number" name="home_score" value="<?php echo (int)$home_score; ?>" min="0" style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:8px">
        </div>
        <div>
          <label>Away Score</label>
          <input type="number" name="away_score" value="<?php echo (int)$away_score; ?>" min="0" style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:8px">
        </div>
        <div>
          <label>Status</label>
          <select name="status" style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:8px">
            <option <?php echo $status==='Scheduled'?'selected':''; ?>>Scheduled</option>
            <option <?php echo $status==='Completed'?'selected':''; ?>>Completed</option>
          </select>
        </div>
      </div>
      <div style="margin-bottom:12px">
        <label>Highlight (YouTube URL or embed)</label>
        <input type="text" name="highlight_url" value="<?php echo sanitize($highlight_url); ?>" placeholder="https://www.youtube.com/watch?v=..." style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:8px">
      </div>
      <div>
        <button class="btn" type="submit">Save</button>
        <a class="btn" href="games.php" style="margin-left:8px">Cancel</a>
      </div>
    </form>
  </div></div>
</div>
</body>
</html>


