<?php 
  require_once __DIR__ . '/../includes/config.php';
require_login();

$id = isset($_GET['id']) && ctype_digit($_GET['id']) ? (int)$_GET['id'] : 0;
$editing = $id > 0;

// Fetch players for dropdown
$players = $mysqli->query("SELECT id, name FROM players ORDER BY name ASC");

// If editing, load existing stats
if ($editing) {
  $stmt = $mysqli->prepare("SELECT * FROM player_stats WHERE id=? LIMIT 1");
  $stmt->bind_param('i', $id);
  $stmt->execute();
  $stat = $stmt->get_result()->fetch_assoc();
  if (!$stat) redirect('stats-list.php');
} else {
  $stat = [
    'player_id' => '',
    'games_played' => 0,
    'total_points' => 0,
    'total_rebounds' => 0,
    'total_assists' => 0,
    'total_steals' => 0,
    'total_blocks' => 0,
    'fg_made' => 0,
    'fg_attempted' => 0,
    'three_made' => 0,
    'three_attempted' => 0,
    'ft_made' => 0,
    'ft_attempted' => 0
  ];
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $fields = [
    'player_id','games_played','total_points','total_rebounds','total_assists',
    'total_steals','total_blocks','fg_made','fg_attempted','three_made',
    'three_attempted','ft_made','ft_attempted'
  ];
  foreach ($fields as $f) $stat[$f] = (int)($_POST[$f] ?? 0);

  if ($editing) {
    $stmt = $mysqli->prepare("UPDATE player_stats SET 
      player_id=?, games_played=?, total_points=?, total_rebounds=?, total_assists=?, 
      total_steals=?, total_blocks=?, fg_made=?, fg_attempted=?, three_made=?, 
      three_attempted=?, ft_made=?, ft_attempted=? WHERE id=?");
    $stmt->bind_param(
      'iiiiiiiiiiiiii',
      $stat['player_id'], $stat['games_played'], $stat['total_points'], $stat['total_rebounds'],
      $stat['total_assists'], $stat['total_steals'], $stat['total_blocks'],
      $stat['fg_made'], $stat['fg_attempted'], $stat['three_made'], $stat['three_attempted'],
      $stat['ft_made'], $stat['ft_attempted'], $id
    );
  } else {
    $stmt = $mysqli->prepare("INSERT INTO player_stats 
      (player_id, games_played, total_points, total_rebounds, total_assists, total_steals, 
      total_blocks, fg_made, fg_attempted, three_made, three_attempted, ft_made, ft_attempted)
      VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param(
      'iiiiiiiiiiiii',
      $stat['player_id'], $stat['games_played'], $stat['total_points'], $stat['total_rebounds'],
      $stat['total_assists'], $stat['total_steals'], $stat['total_blocks'],
      $stat['fg_made'], $stat['fg_attempted'], $stat['three_made'], $stat['three_attempted'],
      $stat['ft_made'], $stat['ft_attempted']
    );
  }

  if ($stmt->execute()) redirect('stats-list.php');
}
?>
<head>
<link rel="stylesheet" href="../css/style.css">
</head>
<section class="section-title">
  <h2><?php echo $editing ? '✏️ Edit Player Stats' : '➕ Add Player Stats'; ?></h2>
  <p class="muted">Manage detailed game performance statistics for each player.</p>
</section>

<div class="card" style="max-width:900px;margin:auto;">
  <div class="card-body">
    <form method="post" class="grid col-2" style="gap:16px;">
      <label>
        <span>Player</span>
        <select name="player_id" required>
          <option value="">Select Player</option>
          <?php while($p = $players->fetch_assoc()): ?>
            <option value="<?php echo $p['id']; ?>" <?php if($p['id'] == $stat['player_id']) echo 'selected'; ?>>
              <?php echo sanitize($p['name']); ?>
            </option>
          <?php endwhile; ?>
        </select>
      </label>

      <label><span>Games Played</span><input type="number" name="games_played" value="<?php echo $stat['games_played']; ?>"></label>
      <label><span>Total Points</span><input type="number" name="total_points" value="<?php echo $stat['total_points']; ?>"></label>
      <label><span>Total Rebounds</span><input type="number" name="total_rebounds" value="<?php echo $stat['total_rebounds']; ?>"></label>
      <label><span>Total Assists</span><input type="number" name="total_assists" value="<?php echo $stat['total_assists']; ?>"></label>
      <label><span>Total Steals</span><input type="number" name="total_steals" value="<?php echo $stat['total_steals']; ?>"></label>
      <label><span>Total Blocks</span><input type="number" name="total_blocks" value="<?php echo $stat['total_blocks']; ?>"></label>
      <label><span>FG Made</span><input type="number" name="fg_made" value="<?php echo $stat['fg_made']; ?>"></label>
      <label><span>FG Attempted</span><input type="number" name="fg_attempted" value="<?php echo $stat['fg_attempted']; ?>"></label>
      <label><span>3P Made</span><input type="number" name="three_made" value="<?php echo $stat['three_made']; ?>"></label>
      <label><span>3P Attempted</span><input type="number" name="three_attempted" value="<?php echo $stat['three_attempted']; ?>"></label>
      <label><span>FT Made</span><input type="number" name="ft_made" value="<?php echo $stat['ft_made']; ?>"></label>
      <label><span>FT Attempted</span><input type="number" name="ft_attempted" value="<?php echo $stat['ft_attempted']; ?>"></label>

      <div style="grid-column:1/-1;text-align:right;margin-top:10px;">
        <a href="stats-list.php" class="btn btn-secondary">⬅ Back</a>
        <button class="btn btn-primary" type="submit">💾 Save Stats</button>
      </div>
    </form>
  </div>
</div>
