<?php require_once __DIR__ . '/../includes/config.php';
require_login();

$res = $mysqli->query("SELECT id,name,gender,division,location,logo FROM teams ORDER BY name ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Teams - FERWABA</title>
  <link rel="stylesheet" href="<?php echo asset_url('../css/style.css'); ?>">
</head>
<body>
<div class="container" style="margin:20px auto">
  <div class="section-title">
    <h2>Teams</h2>
    <a class="btn" href="team-form.php">Add Team</a>
  </div>
  <div class="card">
    <table>
      <thead>
        <tr><th>Logo</th><th>Name</th><th>Gender</th><th>Division</th><th>Location</th><th>Actions</th></tr>
      </thead>
      <tbody>
        <?php while($t = $res->fetch_assoc()): ?>
        <tr>
          <td><?php if($t['logo']): ?><img src="/admin/uploads/<?php echo sanitize($t['logo']); ?>" alt="logo" style="width:40px;height:40px;object-fit:cover;border-radius:6px"><?php endif; ?></td>
          <td><?php echo sanitize($t['name']); ?></td>
          <td><?php echo sanitize($t['gender']); ?></td>
          <td><?php echo sanitize($t['division']); ?></td>
          <td><?php echo sanitize($t['location']); ?></td>
          <td>
            <a href="team-form.php?id=<?php echo (int)$t['id']; ?>">Edit</a>
            <a href="delete-team.php?id=<?php echo (int)$t['id']; ?>" onclick="return confirm('Delete team? This may affect players/coaches.')">Delete</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>


