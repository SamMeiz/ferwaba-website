<?php
require_once __DIR__ . '/../includes/config.php';
require_login();

$id = isset($_GET['id']) && ctype_digit($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    $stmt = $mysqli->prepare("DELETE FROM standings WHERE id=? LIMIT 1");
    $stmt->bind_param('i', $id);
    $stmt->execute();
}

header('Location: standings-list.php');
exit;
?>
