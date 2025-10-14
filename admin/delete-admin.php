<?php require_once __DIR__ . '/../includes/config.php';
require_login();
require_superadmin();

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
  die('Invalid request');
}
$id = (int)$_GET['id'];
if ($id === (int)$_SESSION['admin_id']) {
  die('Cannot delete yourself');
}
$stmt = $mysqli->prepare("DELETE FROM admins WHERE id=? LIMIT 1");
$stmt->bind_param('i', $id);
$stmt->execute();
redirect('admins.php');


