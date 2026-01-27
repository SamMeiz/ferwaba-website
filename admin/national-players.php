<?php
// Check if team_id is provided
if (!isset($_GET['team_id'])) {
    header('Location: national-teams.php');
    exit;
}

$page_title = 'National Team Players';
require_once __DIR__ . '/includes/admin-header.php';

$team_id = (int) ($_GET['team_id'] ?? 0);
if (!$team_id) {
    header('Location: national-teams.php');
    exit;
}

// Fetch team info
$team_result = $mysqli->query("SELECT team_name FROM national_teams WHERE id=$team_id");
if (!$team_result || $team_result->num_rows === 0) {
    header('Location: national-teams.php');
    exit;
}
$team = $team_result->fetch_assoc();

// Handle form submission for adding a new player
$success_message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $position = trim($_POST['position']);
    $club = trim($_POST['club']);
    $jersey_number = (int) ($_POST['jersey_number'] ?? 0);
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
    if ($stmt->execute()) {
        $success_message = 'Player added successfully!';
    }
}

// Fetch all players for this team
$players = $mysqli->query("SELECT id, team_id, name, position, jersey_number, club, photo, created_at 
                           FROM national_players 
                           WHERE team_id=$team_id 
                           ORDER BY jersey_number ASC");
?>

<?php if ($success_message): ?>
    <div class="message message-success">
        <i class="fas fa-check-circle"></i>
        <?php echo $success_message; ?>
    </div>
<?php endif; ?>

<div class="page-header">
    <div>
        <h1><?php echo sanitize($team['team_name']); ?> Roster</h1>
        <p>Manage players for this national team</p>
    </div>
    <div class="section-actions">
        <a href="national-teams.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to Teams</a>
    </div>
</div>

<!-- Add Player Form -->
<div class="form-container" style="max-width: 100%;">
    <h3 style="margin-bottom: 24px; color: var(--gray-900); font-size: 20px;">
        <i class="fas fa-user-plus"></i> Add New Player
    </h3>
    <form method="post" enctype="multipart/form-data">
        <div class="form-grid">
            <div class="form-group">
                <label for="name"><i class="fas fa-user"></i> Player Name</label>
                <input type="text" id="name" name="name" placeholder="Enter player full name" required>
            </div>

            <div class="form-group">
                <label for="position"><i class="fas fa-map-marker-alt"></i> Position</label>
                <select id="position" name="position" required>
                    <option value="">Select Position</option>
                    <option value="Point Guard">Point Guard (PG)</option>
                    <option value="Shooting Guard">Shooting Guard (SG)</option>
                    <option value="Small Forward">Small Forward (SF)</option>
                    <option value="Power Forward">Power Forward (PF)</option>
                    <option value="Center">Center (C)</option>
                </select>
            </div>

            <div class="form-group">
                <label for="jersey_number"><i class="fas fa-hashtag"></i> Jersey Number</label>
                <input type="number" id="jersey_number" name="jersey_number" placeholder="e.g., 23" min="0" max="99">
            </div>

            <div class="form-group">
                <label for="club"><i class="fas fa-building"></i> Club Team</label>
                <input type="text" id="club" name="club" placeholder="Current club team">
            </div>

            <div class="form-group full-width">
                <label for="photo"><i class="fas fa-camera"></i> Player Photo</label>
                <input type="file" id="photo" name="photo" accept="image/*">
                <p class="form-hint">Upload a professional photo of the player (JPG, PNG, or GIF)</p>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Player
            </button>
            <button type="reset" class="btn btn-secondary">
                <i class="fas fa-redo"></i> Reset Form
            </button>
        </div>
    </form>
</div>

<!-- Players Table -->
<div class="admin-card" style="margin-top: 32px;">
    <div class="admin-card-header">
        <h3><i class="fas fa-users"></i> Team Roster</h3>
        <span style="color: var(--gray-500); font-size: 14px;">
            <?php echo $players->num_rows; ?> player<?php echo $players->num_rows !== 1 ? 's' : ''; ?>
        </span>
    </div>
    <div class="table-wrapper">
        <table class="admin-table">
            <thead>
                <tr>
                    <th><i class="fas fa-image"></i> Photo</th>
                    <th><i class="fas fa-hashtag"></i> Jersey</th>
                    <th><i class="fas fa-user"></i> Name</th>
                    <th><i class="fas fa-map-marker-alt"></i> Position</th>
                    <th><i class="fas fa-building"></i> Club</th>
                    <th><i class="fas fa-cogs"></i> Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($players && $players->num_rows > 0): ?>
                    <?php while ($row = $players->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <?php if ($row['photo']): ?>
                                    <img src="uploads/<?php echo sanitize($row['photo']); ?>"
                                        alt="<?php echo sanitize($row['name']); ?>">
                                <?php else: ?>
                                    <div
                                        style="width: 48px; height: 48px; background: var(--gray-200); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--gray-400);">
                                        <i class="fas fa-user"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="status-badge"
                                    style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); color: #fff; font-family: 'Roboto Mono', monospace;">
                                    #<?php echo (int) $row['jersey_number']; ?>
                                </span>
                            </td>
                            <td><strong><?php echo sanitize($row['name']); ?></strong></td>
                            <td><?php echo sanitize($row['position']); ?></td>
                            <td><?php echo sanitize($row['club']); ?></td>
                            <td>
                                <div class="action-links">
                                    <a href="edit-national-player.php?id=<?php echo $row['id']; ?>" class="action-link edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="delete-national-player.php?id=<?php echo $row['id']; ?>&team_id=<?php echo $team_id; ?>"
                                        class="action-link delete"
                                        onclick="return confirm('Are you sure you want to delete this player?')">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <i class="fas fa-users"></i>
                                <h3>No Players Yet</h3>
                                <p>Add players to this national team using the form above</p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>