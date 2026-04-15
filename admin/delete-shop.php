<?php require_once __DIR__ . '/../includes/bootstrap.php';
require_login();

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    die('Invalid request');
}
$id = (int) $_GET['id'];

try {
    $stmt = $db->prepare("SELECT name FROM shop_items WHERE id=? LIMIT 1");
    $stmt->execute([$id]);
    $item = $stmt->fetch();

    if ($item) {
        $name = $item['name'];
        $del = $db->prepare("DELETE FROM shop_items WHERE id=? LIMIT 1");
        $del->execute([$id]);
        audit_log($db, 'Delete Shop Item', "Deleted shop item: $name (ID: $id)");
    }
} catch (PDOException $e) {
    error_log("Delete Shop Error: " . $e->getMessage());
}

redirect('shop.php');
?>