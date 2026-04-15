<?php
$page_title = (isset($_GET['id']) && ctype_digit($_GET['id'])) ? 'Edit Admin' : 'Add Admin';
require_once __DIR__ . '/includes/admin-header.php';
require_superadmin();

$id = isset($_GET['id']) && ctype_digit($_GET['id']) ? (int) $_GET['id'] : 0;
$editing = $id > 0;

$full_name = '';
$email = '';
$role = 'SubAdmin';
$is_active = 1;
$error = '';
$csrf_token = generate_csrf_token();

try {
  if ($editing) {
    $stmt = $db->prepare("SELECT full_name, email, role, is_active FROM admins WHERE id=? LIMIT 1");
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    if ($row) {
      $full_name = $row['full_name'];
      $email = $row['email'];
      $role = $row['role'];
      $is_active = (int) $row['is_active'];
    } else {
      die('Admin not found');
    }
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf_token();
    $full_name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $role = ($_POST['role'] ?? '') === 'SuperAdmin' ? 'SuperAdmin' : 'SubAdmin';
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    $password = trim($_POST['password'] ?? '');

    if (!$full_name || !$email || (!$editing && !$password)) {
      $error = 'Name, email, and password (for new admin) are required.';
    } elseif ($password) {
      // VULN-009 FIX: Enforce strong password policy
      $pwError = validate_password_strength($password);
      if ($pwError) {
          $error = $pwError;
      }
    }

    if (!$error) {
      if ($editing) {
        if ($id === (int) $_SESSION['admin_id'] && $role !== ($_SESSION['admin_role'] ?? '')) {
          $error = 'You cannot change your own role.';
        } else {
          if ($password !== '') {
            $stmt = $db->prepare("UPDATE admins SET full_name=?, email=?, role=?, is_active=?, password=? WHERE id=? LIMIT 1");
            $hashed = hash_password($password);
            $stmt->execute([$full_name, $email, $role, $is_active, $hashed, $id]);
          } else {
            $stmt = $db->prepare("UPDATE admins SET full_name=?, email=?, role=?, is_active=? WHERE id=? LIMIT 1");
            $stmt->execute([$full_name, $email, $role, $is_active, $id]);
          }
          audit_log($db, 'Edit Admin', "Updated administrator: $full_name (ID: $id)");
          redirect('admins.php');
        }
      } else {
        $stmt = $db->prepare("INSERT INTO admins(full_name, email, password, role, is_active) VALUES(?,?,?,?,?)");
        $hashed = hash_password($password);
        $stmt->execute([$full_name, $email, $hashed, $role, $is_active]);
        $newId = $db->lastInsertId();
        audit_log($db, 'Add Admin', "Created administrator: $full_name (ID: $newId)");
        redirect('admins.php');
      }
    }
  }
} catch (PDOException $e) {
  error_log("Admin Form Error: " . $e->getMessage());
  $error = 'Failed to save admin (email may be taken).';
}
?>

<div class="page-header">
  <div>
    <h1><?php echo $editing ? 'Edit Admin' : 'Add New Admin'; ?></h1>
    <p><?php echo $editing ? 'Update administrator details' : 'Create a new administrator account'; ?></p>
  </div>
  <div class="section-actions">
    <a href="admins.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to Admins</a>
  </div>
</div>

<?php if ($error): ?>
  <div class="message message-error">
    <i class="fas fa-exclamation-circle"></i>
    <?php echo sanitize($error); ?>
  </div>
<?php endif; ?>

<div class="form-container">
  <form method="post">
    <!-- Generate a new token if we were just POSTed to rotate it (VULN-013 fix) -->
    <input type="hidden" name="csrf_token" value="<?php echo sanitize(generate_csrf_token()); ?>">
    <div class="form-grid">
      <div class="form-group">
        <label for="full_name"><i class="fas fa-user"></i> Full Name</label>
        <input type="text" id="full_name" name="full_name" value="<?php echo sanitize($full_name); ?>" required
          placeholder="Enter full name">
      </div>

      <div class="form-group">
        <label for="email"><i class="fas fa-envelope"></i> Email Address</label>
        <input type="email" id="email" name="email" value="<?php echo sanitize($email); ?>" required
          placeholder="admin@ferwaba.rw">
      </div>

      <div class="form-group">
        <label for="password"><i class="fas fa-lock"></i> Password <?php if ($editing): ?><span class="form-hint">(leave
              blank to keep current)</span><?php endif; ?></label>
        <input type="password" id="password" name="password" <?php echo !$editing ? 'required' : ''; ?>
          minlength="12" placeholder="Enter password (min 12 chars)">
        <span class="form-hint"><i class="fas fa-info-circle"></i> Min 12 chars &mdash; must include uppercase, lowercase, number &amp; special char</span>
      </div>

      <div class="form-group">
        <label for="role"><i class="fas fa-shield-alt"></i> Role</label>
        <select id="role" name="role">
          <option value="SubAdmin" <?php echo $role === 'SubAdmin' ? 'selected' : ''; ?>>SubAdmin</option>
          <option value="SuperAdmin" <?php echo $role === 'SuperAdmin' ? 'selected' : ''; ?>>SuperAdmin</option>
        </select>
      </div>

      <div class="form-group full-width">
        <div class="checkbox-group">
          <input type="checkbox" id="is_active" name="is_active" <?php echo $is_active ? 'checked' : ''; ?>>
          <label for="is_active"><i class="fas fa-check-circle"></i> Account is active</label>
        </div>
      </div>
    </div>

    <div class="form-actions">
      <button type="submit" class="btn btn-success">
        <i class="fas fa-save"></i>
        <?php echo $editing ? 'Update Admin' : 'Create Admin'; ?>
      </button>
      <a href="admins.php" class="btn btn-secondary">
        <i class="fas fa-times"></i>
        Cancel
      </a>
    </div>
  </form>
</div>

<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>
