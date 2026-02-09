<?php
require_once __DIR__ . '/../includes/config.php';
if (is_logged_in()) {
  header("Location: dashboard.php");
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
      if ((int) $admin['is_active'] !== 1) {
        $error = 'Account is inactive. Please contact SuperAdmin.';
      } elseif (hash_password($password) === $admin['password']) {
        $_SESSION['admin_id'] = (int) $admin['id'];
        $_SESSION['admin_name'] = $admin['full_name'];
        $_SESSION['admin_role'] = $admin['role'];
        header("Location: dashboard.php");
        exit();
      } else {
        $error = 'Invalid email or password.';
      }
    } else {
      $error = 'Invalid email or password.';
    }
  } else {
    $error = 'Please enter both email and password.';
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login - FERWABA</title>
  <link rel="stylesheet" href="../assets/css/admin.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="login-body">
  <div class="login-container">
    <div class="login-card">
      <div class="login-header">
        <div class="logo">
          <i class="fas fa-basketball-ball"></i>
          <span>FERWABA</span>
        </div>
        <p>Admin Panel Login</p>
      </div>
      <div class="login-body-content">
        <?php if ($error): ?>
          <div class="login-error">
            <i class="fas fa-exclamation-circle"></i>
            <?php echo sanitize($error); ?>
          </div>
        <?php endif; ?>

        <form method="post">
          <div class="form-group">
            <label for="email"><i class="fas fa-envelope"></i> Email Address</label>
            <input type="email" id="email" name="email" placeholder="admin@ferwaba.rw" required
              value="<?php echo sanitize($_POST['email'] ?? ''); ?>">
          </div>

          <div class="form-group">
            <label for="password"><i class="fas fa-lock"></i> Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>
          </div>

          <button type="submit" class="btn btn-primary">
            <i class="fas fa-sign-in-alt"></i>
            Sign In
          </button>
        </form>

        <div style="text-align: center; margin-top: 24px; display: flex; justify-content: center; gap: 24px;">
          <a href="../ferwaba-main/index.php"
            style="color: var(--gray-600); font-size: 13px; text-decoration: none; font-weight: 600; display: flex; align-items: center; gap: 6px; transition: color 0.2s;">
            <i class="fas fa-arrow-left"></i> Back to FERWABA
          </a>
          <a href="../competitions/rbl/pages/index.php"
            style="color: var(--primary); font-size: 13px; text-decoration: none; font-weight: 600; display: flex; align-items: center; gap: 6px; transition: color 0.2s;">
            <i class="fas fa-basketball-ball"></i> Back to RBL
          </a>
        </div>
      </div>
    </div>
  </div>
</body>

</html>