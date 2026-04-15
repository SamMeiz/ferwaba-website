<?php require_once __DIR__ . '/../includes/bootstrap.php';
require_login();

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    die('Invalid request');
}
$id = (int) $_GET['id'];

try {
    $stmt = $db->prepare("SELECT name FROM coaches WHERE id=? LIMIT 1");
    $stmt->execute([$id]);
    $coach = $stmt->fetch();

    if ($coach) {
        $name = $coach['name'];
        $del = $db->prepare("DELETE FROM coaches WHERE id=? LIMIT 1");
        $del->execute([$id]);
        audit_log($db, 'Delete Coach', "Deleted coach: $name (ID: $id)");
    }
} catch (PDOException $e) {
    error_log("Delete Coach Error: " . $e->getMessage());
}

redirect('coaches.php');
?>