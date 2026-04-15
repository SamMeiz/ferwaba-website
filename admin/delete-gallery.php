<?php require_once __DIR__ . '/../includes/bootstrap.php';
require_login();

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    die('Invalid request');
}
$id = (int) $_GET['id'];

try {
    $del = $db->prepare("DELETE FROM gallery WHERE id=? LIMIT 1");
    $del->execute([$id]);
    audit_log($db, 'Delete Gallery', "Deleted gallery item ID: $id");
} catch (PDOException $e) {
    error_log("Delete Gallery Error: " . $e->getMessage());
}

redirect('gallery.php');
