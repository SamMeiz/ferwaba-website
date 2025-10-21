<?php require_once __DIR__ . '/../includes/config.php';
require_login();

$coaches = $mysqli->query("SELECT c.id,c.name,c.role,c.nationality,c.photo,t.name AS team_name FROM coaches c LEFT JOIN teams t ON t.id=c.team_id ORDER BY t.name ASC, c.role ASC, c.name ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Coaches - FERWABA</title>
  <link rel="stylesheet" href="<?php echo asset_url('../css/style.css'); ?>">
</head>
<body>
<div class="container" style="margin:20px auto">
  <div class="section-title">
    <h2>Coaches</h2>
    <a href="javascript:history.back()" class="btn" style="background:#6b7280;margin-left:8px;">⬅️ Back</a>
    <a class="btn" href="coach-form.php">Add Coach</a>
  </div>
  <div class="card">
    <table>
      <thead>
        <tr><th>Photo</th><th>Name</th><th>Role</th><th>Team</th><th>Nationality</th><th>Actions</th></tr>
      </thead>
      <tbody>
        <?php while($c=$coaches->fetch_assoc()): ?>
        <tr>
          <td><?php if($c['photo']): ?><img src="/admin/uploads/<?php echo sanitize($c['photo']); ?>" alt="photo" style="width:36px;height:36px;object-fit:cover;border-radius:50%"><?php endif; ?></td>
          <td><?php echo sanitize($c['name']); ?></td>
          <td><?php echo sanitize($c['role']); ?></td>
          <td><?php echo sanitize($c['team_name'] ?? ''); ?></td>
          <td><?php echo sanitize($c['nationality']); ?></td>
          <td>
            <a href="coach-form.php?id=<?php echo (int)$c['id']; ?>">Edit</a>
            <a href="delete-coach.php?id=<?php echo (int)$c['id']; ?>" onclick="return confirm('Delete coach?')">Delete</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>


