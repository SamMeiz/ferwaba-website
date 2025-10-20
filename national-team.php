<?php require_once __DIR__ . '/includes/header.php'; ?>

<?php
$teamParam = $_GET['team'] ?? 'Senior Men';

// Fetch team info from database
$stmt = $mysqli->prepare("SELECT * FROM national_teams WHERE category=? LIMIT 1");
$stmt->bind_param('s', $teamParam);
$stmt->execute();
$team = $stmt->get_result()->fetch_assoc();

if (!$team) {
    echo "<p>No team found for this category.</p>";
    require_once __DIR__ . '/includes/footer.php';
    exit;
}

// Fetch players for this team
$stmtP = $mysqli->prepare("SELECT * FROM national_players WHERE team_id=? ORDER BY jersey_number ASC");
$stmtP->bind_param('i', $team['id']);
$stmtP->execute();
$players = $stmtP->get_result();

// Fetch coaches for this team
$stmtC = $mysqli->prepare("SELECT * FROM national_coaches WHERE team_id=? ORDER BY FIELD(role,'Head Coach','Assistant Coach','Team Staff'), name ASC");
$stmtC->bind_param('i', $team['id']);
$stmtC->execute();
$coaches = $stmtC->get_result();
?>
<br><br>
<nav class="muted" style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:20px;">
    <?php 
    $opts=['Senior Men','Senior Women','U18 Men','U18 Women','U16 Men','U16 Women']; 
    foreach($opts as $o): ?>
        <a class="btn" href="<?php echo asset_url('national-team.php?team='.urlencode($o)); ?>" style="background:#f3f4f6"><?php echo $o; ?></a>
    <?php endforeach; ?>
</nav>

<section class="section-title" style="text-align:center; width:100%;">
    <?php if (!empty($team['banner_image'])): ?>
        <div style="width:100%; max-width:1600px; aspect-ratio:4/1; overflow:hidden; margin:0 auto; border-radius:12px;">
            <img src="admin/uploads/<?php echo sanitize($team['banner_image']); ?>" 
                 alt="<?php echo sanitize($team['team_name']); ?> Banner"
                 style="width:100%; height:100%; object-fit:cover; object-position:center;">
        </div>
    <?php endif; ?>
</section>

<div class="grid col-2">

    <!-- ROSTER -->
    <div class="card">
        <div class="card-body">
            <h3>Roster</h3>
            <?php if ($players->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>#</th>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Club</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($p = $players->fetch_assoc()): 
                        $photo = !empty($p['photo']) ? 'admin/uploads/'.sanitize($p['photo']) : 'https://via.placeholder.com/80x80?text=Player';
                    ?>
                    <tr>
                        <td><img src="<?php echo $photo; ?>" alt="Player Photo" style="width:60px;height:60px;object-fit:cover;border-radius:50%;"></td>
                        <td><?php echo (int)$p['jersey_number']; ?></td>
                        <td><a href="player-card.php?id=<?php echo $p['id']; ?>"><?php echo sanitize($p['name']); ?></a></td>
                        <td><?php echo sanitize($p['position']); ?></td>
                        <td><?php echo sanitize($p['club']); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <?php else: ?>
                <div class="muted">No players for this team.</div>
            <?php endif; ?>
        </div>
    </div>

    <!-- COACHES -->
    <div class="card">
        <div class="card-body">
            <h3>Coaches</h3>
            <?php if ($coaches->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($c = $coaches->fetch_assoc()): 
                        $cphoto = !empty($c['photo']) ? 'admin/uploads/'.sanitize($c['photo']) : 'https://via.placeholder.com/80x80?text=Coach';
                    ?>
                    <tr>
                        <td><img src="<?php echo $cphoto; ?>" alt="Coach Photo" style="width:60px;height:60px;object-fit:cover;border-radius:50%;"></td>
                        <td><?php echo sanitize($c['name']); ?></td>
                        <td><?php echo sanitize($c['role']); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <?php else: ?>
                <div class="muted">No coaches for this team.</div>
            <?php endif; ?>
        </div>
    </div>

</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
