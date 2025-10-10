<?php
// FERWABA Basketball League Management System v1.5
// Global configuration, database connection, and common helpers

// Timezone
date_default_timezone_set('Africa/Kigali');

// Session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database credentials (adjust for your local MySQL)
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'ferwaba_db';

$mysqli = @new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($mysqli->connect_errno) {
    die('Database connection failed: ' . $mysqli->connect_error);
}

// Ensure UTF-8
$mysqli->set_charset('utf8mb4');

// Basic helpers
function base_url(): string {
    // Detect base URL from server variables
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
    $dir = rtrim(str_replace('\\', '/', dirname($scriptName)), '/.');
    return $protocol . $host . ($dir ? $dir . '/' : '/');
}

function sanitize(string $value): string {
    return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
}

function redirect(string $path): void {
    if (preg_match('~^https?://~', $path)) {
        header('Location: ' . $path);
    } else {
        header('Location: ' . asset_url(ltrim($path, '/')));
    }
    exit;
}

function is_logged_in(): bool {
    return isset($_SESSION['admin_id']);
}

function require_login(): void {
    if (!is_logged_in()) {
        // Relative to current directory (admin pages use this)
        redirect('login.php');
    }
}

function current_admin_role(): ?string {
    return $_SESSION['admin_role'] ?? null;
}

function require_superadmin(): void {
    if (current_admin_role() !== 'SuperAdmin') {
        http_response_code(403);
        die('Forbidden: SuperAdmin only');
    }
}

// Very simple password hashing per requirement (MD5/SHA1). Prefer SHA1 here.
function hash_password(string $plain): string {
    return sha1($plain);
}

function youtube_embed(string $url): string {
    // Accept full YouTube URL and return iframe embed HTML
    $id = '';
    if (preg_match('~(?:v=|youtu\.be\/|embed\/)([\w-]{11})~', $url, $m)) {
        $id = $m[1];
    }
    if (!$id) { return ''; }
    return '<iframe width="560" height="315" src="https://www.youtube.com/embed/'.sanitize($id).'" title="YouTube video" frameborder="0" allowfullscreen></iframe>';
}

function asset_url(string $path): string {
    // Ensure no leading slash to avoid double slashes when concatenated
    $trimmed = ltrim($path, '/');
    return base_url() . $trimmed;
}

// Ensure a standings row exists for a team/division/gender
function ensure_standings_row(mysqli $db, int $teamId, string $division, string $gender): void {
    $stmt = $db->prepare("SELECT id FROM standings WHERE team_id=? AND division=? AND gender=? LIMIT 1");
    $stmt->bind_param('iss', $teamId, $division, $gender);
    $stmt->execute();
    $res = $stmt->get_result();
    if (!$res->fetch_assoc()) {
        $ins = $db->prepare("INSERT INTO standings(team_id, division, gender) VALUES(?,?,?)");
        $ins->bind_param('iss', $teamId, $division, $gender);
        $ins->execute();
    }
}

// Recalculate standings impact for a single completed game
function apply_game_to_standings(mysqli $db, array $game): void {
    if ($game['status'] !== 'Completed') { return; }
    $homeId = (int)$game['home_team_id'];
    $awayId = (int)$game['away_team_id'];
    $division = $game['division'];
    $gender = $game['gender'];
    $homeScore = (int)$game['home_score'];
    $awayScore = (int)$game['away_score'];

    ensure_standings_row($db, $homeId, $division, $gender);
    ensure_standings_row($db, $awayId, $division, $gender);

    // Determine winner/loser; if tied, treat away as winner by convention
    $homeWon = $homeScore > $awayScore;
    $awayWon = !$homeWon;

    // Update games played
    $db->query("UPDATE standings SET games_played = games_played + 1 WHERE team_id = $homeId AND division='{$db->real_escape_string($division)}' AND gender='{$db->real_escape_string($gender)}'");
    $db->query("UPDATE standings SET games_played = games_played + 1 WHERE team_id = $awayId AND division='{$db->real_escape_string($division)}' AND gender='{$db->real_escape_string($gender)}'");

    if ($homeWon) {
        $db->query("UPDATE standings SET wins = wins + 1, points = points + 2 WHERE team_id = $homeId AND division='{$db->real_escape_string($division)}' AND gender='{$db->real_escape_string($gender)}'");
        $db->query("UPDATE standings SET losses = losses + 1, points = points + 1 WHERE team_id = $awayId AND division='{$db->real_escape_string($division)}' AND gender='{$db->real_escape_string($gender)}'");
    } else {
        $db->query("UPDATE standings SET wins = wins + 1, points = points + 2 WHERE team_id = $awayId AND division='{$db->real_escape_string($division)}' AND gender='{$db->real_escape_string($gender)}'");
        $db->query("UPDATE standings SET losses = losses + 1, points = points + 1 WHERE team_id = $homeId AND division='{$db->real_escape_string($division)}' AND gender='{$db->real_escape_string($gender)}'");
    }
}

// When editing scores or status, we need to reset the prior effect then apply new
function recalc_standings_for_game_change(mysqli $db, int $gameId): void {
    // Fetch current game
    $gRes = $db->query("SELECT * FROM games WHERE id=$gameId LIMIT 1");
    if (!$gRes || !$gRes->num_rows) { return; }
    $game = $gRes->fetch_assoc();

    // To keep it simple and safe: recompute standings for all teams in this division/gender from scratch
    $division = $db->real_escape_string($game['division']);
    $gender = $db->real_escape_string($game['gender']);
    // Reset standings for all teams in this division/gender to zero
    $db->query("UPDATE standings SET games_played=0,wins=0,losses=0,points=0 WHERE division='$division' AND gender='$gender'");

    // Ensure rows exist for all teams in the division/gender
    $teamsRes = $db->query("SELECT id FROM teams WHERE division='$division' AND gender='$gender'");
    while ($t = $teamsRes->fetch_assoc()) {
        ensure_standings_row($db, (int)$t['id'], $game['division'], $game['gender']);
    }

    // Apply all completed games in this division/gender
    $gamesRes = $db->query("SELECT * FROM games WHERE division='$division' AND gender='$gender' AND status='Completed' ORDER BY game_date ASC, id ASC");
    while ($gm = $gamesRes->fetch_assoc()) {
        apply_game_to_standings($db, $gm);
    }
}

?>


