<?php
require_once __DIR__ . '/../includes/config.php';
require_login();

$result = $mysqli->query("SELECT * FROM national_teams ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="<?php echo asset_url('../css/style.css'); ?>">
</head>
  <h2>National Teams</h2>
  <a class="btn" href="national-team-form.php">+ Add New Team</a>
</section>

<div class="card">
  <table>
    <thead>
      <tr><th>Banner</th><th>Team</th><th>Category</th><th>Created</th><th>Actions</th></tr>
    </thead>
    <tbody>
      <?php while($t = $result->fetch_assoc()): ?>
      <tr>
        <td>
          <?php if ($t['banner_image']): ?>
            <img src="uploads/<?php echo sanitize($t['banner_image']); ?>" style="width:70px;height:45px;object-fit:cover;border-radius:6px;">
          <?php endif; ?>
        </td>
        <td><?php echo sanitize($t['team_name']); ?></td>
        <td><?php echo sanitize($t['category']); ?></td>
        <td><?php echo sanitize($t['created_at']); ?></td>
        <td>
          <a href="national-team-form.php?id=<?php echo $t['id']; ?>">Edit</a> |
          <a href="national-players.php?team_id=<?php echo $t['id']; ?>">Roster</a> |
          <a href="delete.php?table=national_teams&id=<?php echo $t['id']; ?>" onclick="return confirm('Delete team?')">Delete</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>


