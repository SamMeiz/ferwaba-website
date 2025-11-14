<?php
// Check if team_id is provided
if (!isset($_GET['team_id'])) {
    echo "<div style='margin:20px;color:red'>⚠️ Please add a team first before managing players.</div>";
    exit;
}

require_once __DIR__ . '/../includes/config.php';
require_login();

$team_id = (int)($_GET['team_id'] ?? 0);
if (!$team_id) die("Invalid team.");

// Fetch team info
$team_result = $mysqli->query("SELECT team_name FROM national_teams WHERE id=$team_id");
if (!$team_result || $team_result->num_rows === 0) die("Team not found.");
$team = $team_result->fetch_assoc();

// Handle form submission for adding a new player
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $position = trim($_POST['position']);
    $club = trim($_POST['club']);
    $jersey_number = (int)($_POST['jersey_number'] ?? 0);
    $photo = null;

    // Handle file upload
    if (!empty($_FILES['photo']['name'])) {
        $filename = time() . '_' . basename($_FILES['photo']['name']);
        $target = __DIR__ . '/uploads/' . $filename;
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $target)) {
            $photo = $filename;
        }
    }

    $stmt = $mysqli->prepare("INSERT INTO national_players (team_id, name, position, jersey_number, club, photo) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('isisss', $team_id, $name, $position, $jersey_number, $club, $photo);
    $stmt->execute();
}

// Fetch all players for this team
$players = $mysqli->query("SELECT id, team_id, name, position, jersey_number, club, photo, created_at 
                           FROM national_players 
                           WHERE team_id=$team_id 
                           ORDER BY jersey_number ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo sanitize($team['team_name']); ?> – National Players</title>
    <link rel="stylesheet" href="<?php echo asset_url('../css/admin.css'); ?>">
</head>
<body>
<div class="container" style="margin:20px auto">
    <section class="section-title">
        <h2><?php echo sanitize($team['team_name']); ?> – Roster</h2>
        <a class="btn" href="national-teams.php">← Back</a>
    </section>

    <!-- Add Player Form -->
    <form method="post" enctype="multipart/form-data" class="card" style="margin-bottom:20px;">
        <h3>Add Player</h3>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
            <input type="text" name="name" placeholder="Player name" required>
            <input type="text" name="position" placeholder="Position">
            <input type="number" name="jersey_number" placeholder="Jersey #">
            <input type="text" name="club" placeholder="Club name">
            <input type="file" name="photo" accept="image/*">
        </div>
        <button type="submit" class="btn">Add Player</button>
    </form>

    <!-- Players Table -->
    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Jersey</th>
                    <th>Club</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php if($players && $players->num_rows > 0): ?>
                <?php while($row = $players->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <?php if($row['photo']): ?>
                                <img src="uploads/<?= sanitize($row['photo']); ?>" style="width:40px;height:40px;border-radius:4px;object-fit:cover">
                            <?php else: ?>
                                <span class="muted">—</span>
                            <?php endif; ?>
                        </td>
                        <td><?= sanitize($row['name']); ?></td>
                        <td><?= sanitize($row['position']); ?></td>
                        <td><?= (int)$row['jersey_number']; ?></td>
                        <td><?= sanitize($row['club']); ?></td>
                        <td>
                            <a href="edit-national-player.php?id=<?= $row['id']; ?>" class="btn btn-sm">Edit</a>
                            <a href="delete-national-player.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="6" style="text-align:center;">No players found.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
