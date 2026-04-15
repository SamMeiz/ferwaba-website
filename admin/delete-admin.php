<?php require_once __DIR__ . '/../includes/bootstrap.php';
require_login();
require_superadmin();

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
  die('Invalid request');
}
$id = (int) $_GET['id'];

if ($id === (int) $_SESSION['admin_id']) {
  die('Cannot delete yourself');
}

try {
  $stmt = $db->prepare("SELECT full_name FROM admins WHERE id=? LIMIT 1");
  $stmt->execute([$id]);
  $admin = $stmt->fetch();

  if ($admin) {
    $name = $admin['full_name'];
    $del = $db->prepare("DELETE FROM admins WHERE id=? LIMIT 1");
    $del->execute([$id]);
    audit_log($db, 'Delete Admin', "Deleted administrator: $name (ID: $id)");
  }
} catch (PDOException $e) {
  error_log("Delete Admin Error: " . $e->getMessage());
}

redirect('admins.php');
?>