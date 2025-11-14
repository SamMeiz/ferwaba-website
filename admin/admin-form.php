<?php require_once __DIR__ . '/../includes/config.php';
require_login();
require_superadmin();

$id = isset($_GET['id']) && ctype_digit($_GET['id']) ? (int)$_GET['id'] : 0;
$editing = $id > 0;

$full_name = '';
$email = '';
$role = 'SubAdmin';
$is_active = 1;
$error = '';

if ($editing) {
  $stmt = $mysqli->prepare("SELECT full_name,email,role,is_active FROM admins WHERE id=? LIMIT 1");
  $stmt->bind_param('i',$id);
  $stmt->execute();
  $res = $stmt->get_result();
  if ($row = $res->fetch_assoc()) {
    $full_name = $row['full_name'];
    $email = $row['email'];
    $role = $row['role'];
    $is_active = (int)$row['is_active'];
  } else {
    die('Admin not found');
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $full_name = trim($_POST['full_name'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $role = $_POST['role'] === 'SuperAdmin' ? 'SuperAdmin' : 'SubAdmin';
  $is_active = isset($_POST['is_active']) ? 1 : 0;
  $password = trim($_POST['password'] ?? '');

  if (!$full_name || !$email || (!$editing && !$password)) {
    $error = 'Name, email, and password (for new admin) are required.';
  } else {
    if ($editing) {
      if ($id === (int)$_SESSION['admin_id'] && $role !== ($_SESSION['admin_role'] ?? '')) {
        $error = 'You cannot change your own role.';
      } else {
        if ($password !== '') {
          $stmt = $mysqli->prepare("UPDATE admins SET full_name=?, email=?, role=?, is_active=?, password=? WHERE id=? LIMIT 1");
          $hashed = hash_password($password);
          $stmt->bind_param('sssisi', $full_name, $email, $role, $is_active, $hashed, $id);
        } else {
          $stmt = $mysqli->prepare("UPDATE admins SET full_name=?, email=?, role=?, is_active=? WHERE id=? LIMIT 1");
          $stmt->bind_param('sssii', $full_name, $email, $role, $is_active, $id);
        }
        if ($stmt->execute()) {
          redirect('admins.php');
        } else {
          $error = 'Failed to save admin (email may be taken).';
        }
      }
    } else {
      $stmt = $mysqli->prepare("INSERT INTO admins(full_name,email,password,role,is_active) VALUES(?,?,?,?,?)");
      $hashed = hash_password($password);
      $stmt->bind_param('sssii', $full_name, $email, $hashed, $role, $is_active);
      if ($stmt->execute()) {
        redirect('admins.php');
      } else {
        $error = 'Failed to create admin (email may be taken).';
      }
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $editing? 'Edit':'Add'; ?> Admin - FERWABA</title>
  <link rel="stylesheet" href="<?php echo asset_url('../css/admin.css'); ?>">
</head>
<body>
<div class="container" style="max-width:640px">
  <div class="section-title">
    <h2><?php echo $editing? 'Edit':'Add'; ?> Admin</h2>
    <a href="admins.php" class="btn btn-secondary">Back</a>
  </div>
  <div class="card">
    <div class="card-body">
      <?php if($error): ?><div class="error"><?php echo sanitize($error); ?></div><?php endif; ?>
      <form method="post">
        <div class="form-group">
          <label>Full Name</label>
          <input type="text" name="full_name" value="<?php echo sanitize($full_name); ?>" required>
        </div>
        <div class="form-group">
          <label>Email</label>
          <input type="email" name="email" value="<?php echo sanitize($email); ?>" required>
        </div>
        <div class="form-group">
          <label>Password <?php if($editing): ?><span class="muted">(leave blank to keep unchanged)</span><?php endif; ?></label>
          <input type="password" name="password" <?php echo !$editing ? 'required' : ''; ?>>
        </div>
        <div class="form-group">
          <label>Role</label>
          <select name="role">
            <option value="SubAdmin" <?php echo $role==='SubAdmin'?'selected':''; ?>>SubAdmin</option>
            <option value="SuperAdmin" <?php echo $role==='SuperAdmin'?'selected':''; ?>>SuperAdmin</option>
          </select>
        </div>
        <div class="form-group">
          <label><input type="checkbox" name="is_active" <?php echo $is_active? 'checked':''; ?>> Active</label>
        </div>
        <div class="action-buttons">
          <button class="btn btn-success" type="submit">Save</button>
          <a class="btn btn-secondary" href="admins.php">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>
</body>
</html>


