<?php require_once __DIR__ . '/../includes/config.php';
require_login();

$players = $mysqli->query("SELECT p.id,p.name,p.position,p.height,p.nationality,p.jersey_number,p.photo,t.name AS team_name FROM players p LEFT JOIN teams t ON t.id=p.team_id ORDER BY t.name ASC, p.jersey_number ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Players - FERWABA</title>
  <link rel="stylesheet" href="<?php echo asset_url('../css/style.css'); ?>">
</head>
<body>
<div class="container" style="margin:20px auto">
  <div class="section-title">
    <h2>Players</h2>
    <a href="javascript:history.back()" class="btn" style="background:#6b7280;margin-left:8px;">⬅️ Back</a>
    <a class="btn" href="player-form.php">Add Player</a>
  </div>
  <div class="card">
    <table>
      <thead>
        <tr><th>Photo</th><th>#</th><th>Name</th><th>Position</th><th>Team</th><th>Nationality</th><th>Actions</th></tr>
      </thead>
      <tbody>
        <?php while($p=$players->fetch_assoc()): ?>
        <tr>
          <td><?php if($p['photo']): ?><img src="/admin/uploads/<?php echo sanitize($p['photo']); ?>" alt="photo" style="width:36px;height:36px;object-fit:cover;border-radius:50%"><?php endif; ?></td>
          <td><?php echo (int)$p['jersey_number']; ?></td>
          <td><?php echo sanitize($p['name']); ?></td>
          <td><?php echo sanitize($p['position']); ?></td>
          <td><?php echo sanitize($p['team_name'] ?? ''); ?></td>
          <td><?php echo sanitize($p['nationality']); ?></td>
          <td>
            <a href="player-form.php?id=<?php echo (int)$p['id']; ?>">Edit</a>
            <a href="delete-player.php?id=<?php echo (int)$p['id']; ?>" onclick="return confirm('Delete player?')">Delete</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>


