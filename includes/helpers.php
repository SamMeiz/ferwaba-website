<?php
// FERWABA Helper Functions

/**
 * Get base URL of the application
 */
function base_url(): string
{
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $docRoot = isset($_SERVER['DOCUMENT_ROOT']) ? realpath($_SERVER['DOCUMENT_ROOT']) : false;
    $projectRoot = realpath(__DIR__ . '/..');
    if ($docRoot && $projectRoot && strpos($projectRoot, $docRoot) === 0) {
        $webPath = str_replace('\\', '/', substr($projectRoot, strlen($docRoot)));
        $webPath = '/' . ltrim($webPath, '/');
        return $protocol . $host . rtrim($webPath, '/') . '/';
    }
    $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
    $dir = rtrim(str_replace('\\', '/', dirname($scriptName)), '/.');
    return $protocol . $host . ($dir ? $dir . '/' : '/');
}

/**
 * Sanitize output to prevent XSS
 */
function sanitize(string $value): string
{
    return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
}

/**
 * Securely hash password using bcrypt
 */
function hash_password(string $password): string
{
    return password_hash($password, PASSWORD_BCRYPT);
}

/**
 * Verify password
 */
function verify_password(string $password, string $hash): bool
{
    $info = password_get_info($hash);
    if (!empty($info['algo'])) {
        return password_verify($password, $hash);
    }

    $hashValue = strtolower($hash);
    if (strlen($hashValue) === 40 && ctype_xdigit($hashValue)) {
        return hash_equals($hashValue, sha1($password));
    }

    if (strlen($hashValue) === 32 && ctype_xdigit($hashValue)) {
        return hash_equals($hashValue, md5($password));
    }

    return false;
}

function client_ip(): string
{
    return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
}

function log_login_attempt(PDO $db, string $ip, bool $success): void
{
    try {
        $stmt = $db->prepare("INSERT INTO login_attempts (ip_address, is_successful) VALUES (?, ?)");
        $stmt->execute([$ip, $success ? 1 : 0]);
    } catch (PDOException $e) {
        error_log("Login attempt logging failed: " . $e->getMessage());
    }
}

function is_ip_rate_limited(PDO $db, string $ip, int $limit = 20, int $period = 300): bool
{
    $limit = max(1, (int) $limit);
    $period = max(1, (int) $period);
    $stmt = $db->prepare("SELECT COUNT(*) FROM login_attempts WHERE ip_address=? AND is_successful=0 AND attempt_time > DATE_SUB(NOW(), INTERVAL $period SECOND)");
    $stmt->execute([$ip]);
    $count = (int) $stmt->fetchColumn();
    return $count >= $limit;
}

/**
 * Redirect to a path
 */
function redirect(string $path): void
{
    if (preg_match('~^https?://~', $path)) {
        header('Location: ' . $path);
    } else {
        $trimmed = ltrim($path, '/');
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
        if (strpos($scriptName, '/admin/') !== false) {
            if ($trimmed !== '' && strpos($trimmed, 'admin/') !== 0 && strpos($trimmed, '../') !== 0 && strpos($trimmed, './') !== 0) {
                $trimmed = 'admin/' . $trimmed;
            }
        }
        header('Location: ' . asset_url($trimmed));
    }
    exit;
}

/**
 * Get asset URL
 */
function asset_url(string $path): string
{
    $trimmed = ltrim($path, '/');
    return base_url() . $trimmed;
}

/**
 * Check if admin is logged in
 */
function is_logged_in(): bool
{
    return isset($_SESSION['admin_id']);
}

/**
 * Require admin login
 */
function require_login(): void
{
    if (!is_logged_in()) {
        header('Location: ' . base_url() . 'admin/login.php');
        exit;
    }
}

/**
 * Get current admin role
 */
function current_admin_role(): ?string
{
    return $_SESSION['admin_role'] ?? null;
}

/**
 * Require SuperAdmin role
 */
function require_superadmin(): void
{
    if (current_admin_role() !== 'SuperAdmin') {
        http_response_code(403);
        die('Forbidden: SuperAdmin only');
    }
}

/**
 * Generate CSRF token
 */
function generate_csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verify CSRF token
 */
function verify_csrf_token(string $token): bool
{
    if (!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
        return false;
    }
    return true;
}

/**
 * Audit Log function
 */
function audit_log(PDO $db, string $action, ?string $details = null): void
{
    try {
        $userId = $_SESSION['admin_id'] ?? null;
        $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
        $stmt = $db->prepare("INSERT INTO audit_logs (user_id, action, details, ip_address) VALUES (?, ?, ?, ?)");
        $stmt->execute([$userId, $action, $details, $ip]);
    } catch (PDOException $e) {
        error_log("Audit log failed: " . $e->getMessage());
    }
}

/**
 * YouTube Embed Helper
 */
function youtube_embed(string $url): string
{
    $id = '';
    if (preg_match('~(?:v=|youtu\.be\/|embed\/)([\w-]{11})~', $url, $m)) {
        $id = $m[1];
    }
    if (!$id) {
        return '';
    }
    return '<iframe width="560" height="315" src="https://www.youtube.com/embed/' . sanitize($id) . '" title="YouTube video" frameborder="0" allowfullscreen></iframe>';
}

// Standings Helpers (Ported from old config.php)

function ensure_standings_row(PDO $db, int $teamId, string $division, string $gender, ?string $team_group = null): void
{
    $stmt = $db->prepare("SELECT id FROM standings WHERE team_id=? AND division=? AND gender=? LIMIT 1");
    $stmt->execute([$teamId, $division, $gender]);
    if ($row = $stmt->fetch()) {
        $upd = $db->prepare("UPDATE standings SET team_group=? WHERE team_id=? AND division=? AND gender=?");
        $upd->execute([$team_group, $teamId, $division, $gender]);
    } else {
        $ins = $db->prepare("INSERT INTO standings(team_id, division, gender, team_group) VALUES(?,?,?,?)");
        $ins->execute([$teamId, $division, $gender, $team_group]);
    }
}

function apply_game_to_standings(PDO $db, array $game): void
{
    if ($game['status'] !== 'Completed') {
        return;
    }
    $homeId = (int) $game['home_team_id'];
    $awayId = (int) $game['away_team_id'];
    $division = $game['division'];
    $gender = $game['gender'];
    $homeScore = (int) $game['home_score'];
    $awayScore = (int) $game['away_score'];

    ensure_standings_row($db, $homeId, $division, $gender);
    ensure_standings_row($db, $awayId, $division, $gender);

    $homeWon = $homeScore > $awayScore;

    // Update games played
    $db->prepare("UPDATE standings SET games_played = games_played + 1 WHERE team_id = ? AND division=? AND gender=?")
        ->execute([$homeId, $division, $gender]);
    $db->prepare("UPDATE standings SET games_played = games_played + 1 WHERE team_id = ? AND division=? AND gender=?")
        ->execute([$awayId, $division, $gender]);

    if ($homeWon) {
        $db->prepare("UPDATE standings SET wins = wins + 1, points = points + 2 WHERE team_id = ? AND division=? AND gender=?")
            ->execute([$homeId, $division, $gender]);
        $db->prepare("UPDATE standings SET losses = losses + 1, points = points + 1 WHERE team_id = ? AND division=? AND gender=?")
            ->execute([$awayId, $division, $gender]);
    } else {
        $db->prepare("UPDATE standings SET wins = wins + 1, points = points + 2 WHERE team_id = ? AND division=? AND gender=?")
            ->execute([$awayId, $division, $gender]);
        $db->prepare("UPDATE standings SET losses = losses + 1, points = points + 1 WHERE team_id = ? AND division=? AND gender=?")
            ->execute([$homeId, $division, $gender]);
    }
}

function recalc_standings_for_game_change(PDO $db, int $gameId): void
{
    $stmt = $db->prepare("SELECT * FROM games WHERE id=? LIMIT 1");
    $stmt->execute([$gameId]);
    $game = $stmt->fetch();
    if (!$game)
        return;

    $division = $game['division'];
    $gender = $game['gender'];

    $db->prepare("UPDATE standings SET games_played=0,wins=0,losses=0,points=0 WHERE division=? AND gender=?")
        ->execute([$division, $gender]);

    $teamsRes = $db->prepare("SELECT id, team_group FROM teams WHERE division=? AND gender=?");
    $teamsRes->execute([$division, $gender]);
    while ($t = $teamsRes->fetch()) {
        ensure_standings_row($db, (int) $t['id'], $division, $gender, $t['team_group']);
    }

    $gamesRes = $db->prepare("SELECT * FROM games WHERE division=? AND gender=? AND status='Completed' ORDER BY game_date ASC, id ASC");
    $gamesRes->execute([$division, $gender]);
    while ($gm = $gamesRes->fetch()) {
        apply_game_to_standings($db, $gm);
    }
}
?>
