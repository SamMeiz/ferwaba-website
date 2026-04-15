<?php
require_once __DIR__ . '/../includes/bootstrap.php';
require_login();

$id = isset($_GET['id']) && ctype_digit($_GET['id']) ? (int) $_GET['id'] : 0;
$editing = $id > 0;

$home_team_id = $away_team_id = null;
$game_date = date('Y-m-d');
$game_time = '';
$location = '';
$home_score = 0;
$away_score = 0;
$division = 'Division 1';
$gender = 'Men';
$status = 'Scheduled';
$highlight_url = '';
$live_link = '';
$error = '';
$csrf_token = generate_csrf_token();

try {
  $teams = $db->query("SELECT id, name, division, gender FROM teams ORDER BY name ASC")->fetchAll();

  if ($editing) {
    $stmt = $db->prepare("SELECT * FROM games WHERE id=? LIMIT 1");
    $stmt->execute([$id]);
    $g = $stmt->fetch();
    if ($g) {
      $home_team_id = (int) $g['home_team_id'];
      $away_team_id = (int) $g['away_team_id'];
      $game_date = $g['game_date'];
      $game_time = $g['game_time'];
      $location = $g['location'];
      $home_score = (int) $g['home_score'];
      $away_score = (int) $g['away_score'];
      $division = $g['division'];
      $gender = $g['gender'];
      $status = $g['status'];
      $highlight_url = $g['highlight_url'];
      $live_link = $g['live_link'] ?? '';
    } else {
      die('Game not found');
    }
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf_token();
    $home_team_id = isset($_POST['home_team_id']) && ctype_digit($_POST['home_team_id']) ? (int) $_POST['home_team_id'] : null;
    $away_team_id = isset($_POST['away_team_id']) && ctype_digit($_POST['away_team_id']) ? (int) $_POST['away_team_id'] : null;
    $game_date = $_POST['game_date'] ?? $game_date;
    $game_time = !empty($_POST['game_time']) ? $_POST['game_time'] : null;
    $location = trim($_POST['location'] ?? '');
    $home_score = (int) ($_POST['home_score'] ?? 0);
    $away_score = (int) ($_POST['away_score'] ?? 0);
    $division = in_array(($_POST['division'] ?? ''), ['Division 1', 'Division 2']) ? $_POST['division'] : 'Division 1';
    $gender = in_array(($_POST['gender'] ?? ''), ['Men', 'Women']) ? $_POST['gender'] : 'Men';
    $status = in_array(($_POST['status'] ?? ''), ['Scheduled', 'Live', 'Completed', 'Postponed']) ? $_POST['status'] : 'Scheduled';
    $highlight_url = trim($_POST['highlight_url'] ?? '');
    $live_link = trim($_POST['live_link'] ?? '');

    if (!$home_team_id || !$away_team_id || $home_team_id === $away_team_id) {
      $error = 'Select distinct Home and Away teams.';
    }

    if (!$error) {
      if ($editing) {
        $stmt = $db->prepare("
                    UPDATE games SET 
                        home_team_id=?, away_team_id=?, game_date=?, game_time=?, location=?, 
                        home_score=?, away_score=?, division=?, gender=?, status=?, highlight_url=?, live_link=? 
                    WHERE id=? LIMIT 1
                ");
        $stmt->execute([
          $home_team_id,
          $away_team_id,
          $game_date,
          $game_time,
          $location,
          $home_score,
          $away_score,
          $division,
          $gender,
          $status,
          $highlight_url,
          $live_link,
          $id
        ]);
        audit_log($db, 'Edit Game', "Updated game ID: $id ($status)");
        recalc_standings_for_game_change($db, $id);
      } else {
        $stmt = $db->prepare("
                    INSERT INTO games(
                        home_team_id, away_team_id, game_date, game_time, location, 
                        home_score, away_score, division, gender, status, highlight_url, live_link
                    ) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)
                ");
        $stmt->execute([
          $home_team_id,
          $away_team_id,
          $game_date,
          $game_time,
          $location,
          $home_score,
          $away_score,
          $division,
          $gender,
          $status,
          $highlight_url,
          $live_link
        ]);
        $newId = $db->lastInsertId();
        audit_log($db, 'Add Game', "Created game ID: $newId ($status)");
        recalc_standings_for_game_change($db, $newId);
      }
      redirect('games.php');
    }
  }
} catch (PDOException $e) {
  error_log("Game Form Error: " . $e->getMessage());
  $error = 'A database error occurred: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $editing ? 'Edit' : 'Add'; ?> Game - FERWABA</title>
  <link rel="stylesheet" href="<?php echo asset_url('../css/admin.css'); ?>">
</head>

<body>
  <div class="container" style="max-width:840px;margin:24px auto">
    <div class="card">
      <div class="card-body">
        <h2 style="margin:0 0 12px"><?php echo $editing ? 'Edit' : 'Add'; ?> Game</h2>
        <?php if ($error): ?>
          <div style="color:#b91c1c;margin-bottom:8px"><?php echo sanitize($error); ?></div><?php endif; ?>
        <form method="post" autocomplete="off">
          <input type="hidden" name="csrf_token" value="<?php echo sanitize($csrf_token); ?>">
          <div class="grid col-2" style="margin-bottom:12px">
            <div>
              <label style="display:block;margin-bottom:4px;font-weight:600">Home Team</label>
              <select name="home_team_id" required
                style="width:100%;padding:10px;border:1px solid #e5e7eb;border-radius:8px">
                <?php foreach ($teams as $t): ?>
                  <option value="<?php echo (int) $t['id']; ?>" <?php echo ($home_team_id == (int) $t['id']) ? 'selected' : ''; ?>><?php echo sanitize($t['name']); ?> (<?php echo sanitize($t['gender']); ?>)</option>
                <?php endforeach; ?>
              </select>
            </div>
            <div>
              <label style="display:block;margin-bottom:4px;font-weight:600">Away Team</label>
              <select name="away_team_id" required
                style="width:100%;padding:10px;border:1px solid #e5e7eb;border-radius:8px">
                <?php foreach ($teams as $t): ?>
                  <option value="<?php echo (int) $t['id']; ?>" <?php echo ($away_team_id == (int) $t['id']) ? 'selected' : ''; ?>><?php echo sanitize($t['name']); ?> (<?php echo sanitize($t['gender']); ?>)</option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <div class="grid" style="display:grid;grid-template-columns:1fr 1fr 1fr 1fr;gap:12px;margin-bottom:12px">
            <div>
              <label style="display:block;margin-bottom:4px;font-weight:600">Date</label>
              <input type="date" name="game_date" value="<?php echo sanitize($game_date ?? ''); ?>" required
                style="width:100%;padding:10px;border:1px solid #e5e7eb;border-radius:8px">
            </div>
            <div>
              <label style="display:block;margin-bottom:4px;font-weight:600">Time</label>
              <input type="time" name="game_time" value="<?php echo sanitize($game_time ?? ''); ?>"
                style="width:100%;padding:10px;border:1px solid #e5e7eb;border-radius:8px">
            </div>
            <div>
              <label style="display:block;margin-bottom:4px;font-weight:600">Division</label>
              <select name="division" style="width:100%;padding:10px;border:1px solid #e5e7eb;border-radius:8px">
                <option value="Division 1" <?php echo $division === 'Division 1' ? 'selected' : ''; ?>>Division 1</option>
                <option value="Division 2" <?php echo $division === 'Division 2' ? 'selected' : ''; ?>>Division 2</option>
              </select>
            </div>
            <div>
              <label style="display:block;margin-bottom:4px;font-weight:600">Gender</label>
              <select name="gender" style="width:100%;padding:10px;border:1px solid #e5e7eb;border-radius:8px">
                <option value="Men" <?php echo $gender === 'Men' ? 'selected' : ''; ?>>Men</option>
                <option value="Women" <?php echo $gender === 'Women' ? 'selected' : ''; ?>>Women</option>
              </select>
            </div>
          </div>

          <div style="margin-bottom:12px">
            <label style="display:block;margin-bottom:4px;font-weight:600">Location / Venue</label>
            <input type="text" name="location" value="<?php echo sanitize($location ?? ''); ?>"
              placeholder="e.g. BK Arena" style="width:100%;padding:10px;border:1px solid #e5e7eb;border-radius:8px">
          </div>

          <div class="grid col-3" style="margin-bottom:12px">
            <div>
              <label style="display:block;margin-bottom:4px;font-weight:600">Home Score</label>
              <input type="number" name="home_score" value="<?php echo (int) $home_score; ?>" min="0"
                style="width:100%;padding:10px;border:1px solid #e5e7eb;border-radius:8px">
            </div>
            <div>
              <label style="display:block;margin-bottom:4px;font-weight:600">Away Score</label>
              <input type="number" name="away_score" value="<?php echo (int) $away_score; ?>" min="0"
                style="width:100%;padding:10px;border:1px solid #e5e7eb;border-radius:8px">
            </div>
            <div>
              <label style="display:block;margin-bottom:4px;font-weight:600">Match Status</label>
              <select name="status" style="width:100%;padding:10px;border:1px solid #e5e7eb;border-radius:8px">
                <option value="Scheduled" <?php echo $status === 'Scheduled' ? 'selected' : ''; ?>>Scheduled</option>
                <option value="Live" <?php echo $status === 'Live' ? 'selected' : ''; ?>>Live Currently</option>
                <option value="Completed" <?php echo $status === 'Completed' ? 'selected' : ''; ?>>Completed</option>
                <option value="Postponed" <?php echo $status === 'Postponed' ? 'selected' : ''; ?>>Postponed</option>
              </select>
            </div>
          </div>

          <div class="grid col-2" style="margin-bottom:20px">
            <div>
              <label style="display:block;margin-bottom:4px;font-weight:600">Highlight URL <span
                  style="font-weight:400;color:#6b7280;font-size:12px">(Leave empty if N/A)</span></label>
              <input type="text" name="highlight_url" value="<?php echo sanitize($highlight_url ?? ''); ?>"
                placeholder="YouTube URL or leave empty"
                style="width:100%;padding:10px;border:1px solid #e5e7eb;border-radius:8px">
            </div>
            <div>
              <label style="display:block;margin-bottom:4px;font-weight:600">Live Stream Link <span
                  style="font-weight:400;color:#6b7280;font-size:12px">(Leave empty if N/A)</span></label>
              <input type="text" name="live_link" value="<?php echo sanitize($live_link ?? ''); ?>"
                placeholder="Link or leave empty"
                style="width:100%;padding:10px;border:1px solid #e5e7eb;border-radius:8px">
            </div>
          </div>

          <div style="display:flex;gap:12px;padding-top:10px;border-top:1px solid #f3f4f6">
            <button class="btn btn-primary" type="submit"
              style="padding:12px 30px;background:#1a365d;color:#fff;border:none;border-radius:8px;font-weight:600;cursor:pointer">Save
              Changes</button>
            <a class="btn" href="games.php"
              style="padding:12px 30px;background:#f3f4f6;color:#4b5563;text-decoration:none;border-radius:8px;font-weight:600">Cancel</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>

</html>
