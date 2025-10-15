<?php require_once __DIR__ . '/../includes/config.php';
if (is_logged_in()) {
    header("Location: " . asset_url('dashboard.php'));
    exit();
}
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    if ($email && $password) {
        $stmt = $mysqli->prepare("SELECT id, full_name, password, role, is_active FROM admins WHERE email=? LIMIT 1");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($admin = $res->fetch_assoc()) {
            if ((int)$admin['is_active'] !== 1) {
                $error = 'Account is inactive';
            } elseif (hash_password($password) === $admin['password']) {
                $_SESSION['admin_id'] = (int)$admin['id'];
                $_SESSION['admin_name'] = $admin['full_name'];
                $_SESSION['admin_role'] = $admin['role'];
                redirect('/admin/dashboard.php');
            } else {
                $error = 'Invalid credentials';
            }
        } else {
            $error = 'Invalid credentials';
        }
    } else {
        $error = 'Email and password are required';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - FERWABA</title>
  <link rel="stylesheet" href="<?php echo asset_url('../css/style.css'); ?>">
</head>
<body>
<div class="container" style="max-width:420px;margin:60px auto">
  <div class="card">
    <div class="card-body">
      <h2 style="margin:0 0 12px">Admin Login</h2>
      <?php if($error): ?><div style="color:#b91c1c;margin-bottom:8px"><?php echo sanitize($error); ?></div><?php endif; ?>
      <form method="post">
        <div style="margin-bottom:8px">
          <label>Email</label>
          <input type="email" name="email" required style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:8px">
        </div>
        <div style="margin-bottom:12px">
          <label>Password</label>
          <input type="password" name="password" required style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:8px">
        </div>
        <button class="btn" type="submit">Sign In</button>
      </form>
    </div>
  </div>
</div>
</body>
</html>


