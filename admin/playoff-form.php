<?php require_once __DIR__ . '/../includes/config.php';
require_login();

$id = isset($_GET['id']) && ctype_digit($_GET['id']) ? (int)$_GET['id'] : 0;
$editing = $id > 0;

$stage = 'Quarterfinal';
$start_date = date('Y-m-d');
$end_date = date('Y-m-d');
$home_team_id = $away_team_id = null;
$home_score = 0; $away_score = 0;
$winner_team_id = null;
$status = 'Pending';
$error='';

$teams = $mysqli->query("SELECT id,name FROM teams ORDER BY name ASC");

if ($editing) {
  $stmt = $mysqli->prepare("SELECT * FROM playoffs WHERE id=? LIMIT 1");
  $stmt->bind_param('i',$id);
  $stmt->execute();
  $res = $stmt->get_result();
  if ($p=$res->fetch_assoc()) {
    $stage = $p['stage'];
    $start_date = $p['start_date'];
    $end_date = $p['end_date'];
    $home_team_id = $p['home_team_id'];
    $away_team_id = $p['away_team_id'];
    $home_score = (int)$p['home_score'];
    $away_score = (int)$p['away_score'];
    $winner_team_id = $p['winner_team_id'];
    $status = $p['status'];
  } else { die('Not found'); }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stage = in_array(($_POST['stage'] ?? ''), ['Quarterfinal','Semifinal','Final','3rd Place']) ? $_POST['stage'] : 'Quarterfinal';
  $start_date = $_POST['start_date'] ?? $start_date;
  $end_date = $_POST['end_date'] ?? $end_date;
  $home_team_id = isset($_POST['home_team_id']) && ctype_digit($_POST['home_team_id']) ? (int)$_POST['home_team_id'] : null;
  $away_team_id = isset($_POST['away_team_id']) && ctype_digit($_POST['away_team_id']) ? (int)$_POST['away_team_id'] : null;
  $home_score = (int)($_POST['home_score'] ?? 0);
  $away_score = (int)($_POST['away_score'] ?? 0);
  $winner_team_id = isset($_POST['winner_team_id']) && ctype_digit($_POST['winner_team_id']) ? (int)$_POST['winner_team_id'] : null;
  $status = in_array(($_POST['status'] ?? ''), ['Pending','Completed']) ? $_POST['status'] : 'Pending';

  if (!$home_team_id || !$away_team_id || $home_team_id===$away_team_id) {
    $error = 'Select distinct teams for the matchup.';
  }
  if ($winner_team_id && $winner_team_id!==$home_team_id && $winner_team_id!==$away_team_id) {
    $error = 'Winner must be one of the teams.';
  }

  if (!$error) {
    if ($editing) {
      $stmt = $mysqli->prepare("UPDATE playoffs SET stage=?,start_date=?,end_date=?,home_team_id=?,away_team_id=?,home_score=?,away_score=?,winner_team_id=?,status=? WHERE id=? LIMIT 1");
      $stmt->bind_param('sssiiiiisi', $stage,$start_date,$end_date,$home_team_id,$away_team_id,$home_score,$away_score,$winner_team_id,$status,$id);
      if ($stmt->execute()) { redirect('playoffs.php'); } else { $error='Save failed.'; }
    } else {
      $stmt = $mysqli->prepare("INSERT INTO playoffs(stage,start_date,end_date,home_team_id,away_team_id,home_score,away_score,winner_team_id,status) VALUES(?,?,?,?,?,?,?,?,?)");
      $stmt->bind_param('sssiiiiis', $stage,$start_date,$end_date,$home_team_id,$away_team_id,$home_score,$away_score,$winner_team_id,$status);
      if ($stmt->execute()) { redirect('playoffs.php'); } else { $error='Create failed.'; }
    }
  }
}
?>
<!DOCTYPE html>
<html lang=\"en\">
<head>
  <meta charset=\"UTF-8\">
  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
  <title><?php echo $editing? 'Edit':'Add'; ?> Playoff - FERWABA</title>
  <link rel=\"stylesheet\" href=\"<?php echo asset_url('../css/style.css'); ?>\">
</head>
<body>
<div class=\"container\" style=\"max-width:840px;margin:24px auto\"> 
  <div class=\"card\"><div class=\"card-body\">
    <h2 style=\"margin:0 0 12px\"><?php echo $editing? 'Edit':'Add'; ?> Playoff</h2>
    <?php if($error): ?><div style=\"color:#b91c1c;margin-bottom:8px\"><?php echo sanitize($error); ?></div><?php endif; ?>
    <form method=\"post\">
      <div class=\"grid col-3\" style=\"margin-bottom:8px\">
        <div>
          <label>Stage</label>
          <select name=\"stage\">
            <option <?php echo $stage==='Quarterfinal'?'selected':''; ?>>Quarterfinal</option>
            <option <?php echo $stage==='Semifinal'?'selected':''; ?>>Semifinal</option>
            <option <?php echo $stage==='Final'?'selected':''; ?>>Final</option>
            <option <?php echo $stage==='3rd Place'?'selected':''; ?>>3rd Place</option>
          </select>
        </div>
        <div>
          <label>Start Date</label>
          <input type=\"date\" name=\"start_date\" value=\"<?php echo sanitize($start_date); ?>\">
        </div>
        <div>
          <label>End Date</label>
          <input type=\"date\" name=\"end_date\" value=\"<?php echo sanitize($end_date); ?>\">
        </div>
      </div>
      <div class=\"grid col-2\" style=\"margin-bottom:8px\">
        <div>
          <label>Home Team</label>
          <select name=\"home_team_id\" required>
            <?php $teams->data_seek(0); while($t=$teams->fetch_assoc()): ?>
            <option value=\"<?php echo (int)$t['id']; ?>\" <?php echo ($home_team_id==(int)$t['id'])?'selected':''; ?>><?php echo sanitize($t['name']); ?></option>
            <?php endwhile; ?>
          </select>
        </div>
        <div>
          <label>Away Team</label>
          <select name=\"away_team_id\" required>
            <?php $teams->data_seek(0); while($t=$teams->fetch_assoc()): ?>
            <option value=\"<?php echo (int)$t['id']; ?>\" <?php echo ($away_team_id==(int)$t['id'])?'selected':''; ?>><?php echo sanitize($t['name']); ?></option>
            <?php endwhile; ?>
          </select>
        </div>
      </div>
      <div class=\"grid col-3\" style=\"margin-bottom:8px\">
        <div>
          <label>Home Score</label>
          <input type=\"number\" name=\"home_score\" value=\"<?php echo (int)$home_score; ?>\" min=\"0\">
        </div>
        <div>
          <label>Away Score</label>
          <input type=\"number\" name=\"away_score\" value=\"<?php echo (int)$away_score; ?>\" min=\"0\">
        </div>
        <div>
          <label>Status</label>
          <select name=\"status\">
            <option <?php echo $status==='Pending'?'selected':''; ?>>Pending</option>
            <option <?php echo $status==='Completed'?'selected':''; ?>>Completed</option>
          </select>
        </div>
      </div>
      <div class=\"grid col-2\" style=\"margin-bottom:12px\">
        <div>
          <label>Winner</label>
          <select name=\"winner_team_id\">
            <option value=\"\">TBD</option>
            <?php $teams->data_seek(0); while($t=$teams->fetch_assoc()): ?>
            <option value=\"<?php echo (int)$t['id']; ?>\" <?php echo ($winner_team_id==(int)$t['id'])?'selected':''; ?>><?php echo sanitize($t['name']); ?></option>
            <?php endwhile; ?>
          </select>
        </div>
      </div>
      <div>
        <button class=\"btn\" type=\"submit\">Save</button>
        <a class=\"btn\" href=\"/admin/playoffs.php\" style=\"margin-left:8px\">Cancel</a>
      </div>
    </form>
  </div></div>
</div>
</body>
</html>


