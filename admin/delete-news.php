<?php require_once __DIR__ . '/../includes/bootstrap.php';
require_login();

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    die('Invalid request');
}
$id = (int) $_GET['id'];

try {
    $stmt = $db->prepare("SELECT title FROM news WHERE id=? LIMIT 1");
    $stmt->execute([$id]);
    $news = $stmt->fetch();

    if ($news) {
        $title = $news['title'];
        $del = $db->prepare("DELETE FROM news WHERE id=? LIMIT 1");
        $del->execute([$id]);
        audit_log($db, 'Delete News', "Deleted news article: $title (ID: $id)");
    }
} catch (PDOException $e) {
    error_log("Delete News Error: " . $e->getMessage());
}

redirect('news.php');
