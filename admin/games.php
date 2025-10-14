<?php require_once __DIR__ . '/../includes/config.php';
require_login();

$games = $mysqli->query("SELECT g.*, th.name as home_name, ta.name as away_name FROM games g JOIN teams th ON th.id=g.home_team_id JOIN teams ta ON ta.id=g.away_team_id ORDER BY g.game_date DESC, g.id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Games - FERWABA</title>
  <link rel="stylesheet" href="<?php echo asset_url('../css/style.css'); ?>">
</head>
<body>
<div class="container" style="margin:20px auto">
  <div class="section-title">
    <h2>Games</h2>
    <a class="btn" href="game-form.php">Add Game</a>
  </div>
  <div class="card">
    <table>
      <thead>
        <tr><th>Date</th><th>Match</th><th>Division</th><th>Gender</th><th>Status</th><th>Score</th><th>Actions</th></tr>
      </thead>
      <tbody>
        <?php while($g=$games->fetch_assoc()): ?>
        <tr>
          <td><?php echo sanitize($g['game_date']); ?></td>
          <td><?php echo sanitize($g['home_name'].' vs '.$g['away_name']); ?></td>
          <td><?php echo sanitize($g['division']); ?></td>
          <td><?php echo sanitize($g['gender']); ?></td>
          <td><?php echo sanitize($g['status']); ?></td>
          <td><?php echo (int)$g['home_score'].' - '.(int)$g['away_score']; ?></td>
          <td>
            <a href="game-form.php?id=<?php echo (int)$g['id']; ?>">Edit</a>
            <a href="delete-game.php?id=<?php echo (int)$g['id']; ?>" onclick="return confirm('Delete game? This will recalc standings.')">Delete</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>


