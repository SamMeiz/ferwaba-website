<?php require_once __DIR__ . '/../includes/config.php';
require_login();

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) { die('Invalid request'); }
$id = (int)$_GET['id'];
$stmt = $mysqli->prepare("DELETE FROM gallery WHERE id=? LIMIT 1");
$stmt->bind_param('i',$id);
$stmt->execute();
redirect('/admin/gallery.php');


