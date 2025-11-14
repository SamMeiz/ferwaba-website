<?php
// Admin Dashboard for Inkingi Art Space
session_start();
require_once '../config/database.php';

/**
 * Format a date string into a human-readable format.
 *
 * @param string $date The date string to format.
 * @return string The formatted date.
 */
function formatDate($date) {
    return date('F j, Y', strtotime($date));
}

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

class Database {
    private $host = 'localhost';
    private $db_name = 'inkingi_art';
    private $username = 'root';
    private $password = '';
    private $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}

$db = new Database();
$conn = $db->getConnection();

// Get dashboard statistics
$stats = [];

// Total artworks
$query = $conn->query("SELECT COUNT(*) as count FROM artworks");
$stats['artworks'] = $query->fetch()['count'];

// Total artists
$query = $conn->query("SELECT COUNT(*) as count FROM artists WHERE is_active = 1");
$stats['artists'] = $query->fetch()['count'];

// Total exhibitions
$query = $conn->query("SELECT COUNT(*) as count FROM exhibitions");
$stats['exhibitions'] = $query->fetch()['count'];

// Total donations
$query = $conn->query("SELECT COUNT(*) as count, SUM(amount) as total FROM donations WHERE payment_status = 'completed'");
$result = $query->fetch();
$stats['donations_count'] = $result['count'];
$stats['donations_total'] = $result['total'] ?? 0;

// Recent activities
$recent_artworks = $conn->query("SELECT a.*, ar.name as artist_name FROM artworks a 
                                JOIN artists ar ON a.artist_id = ar.id 
                                ORDER BY a.created_at DESC LIMIT 5")->fetchAll();

$recent_donations = $conn->query("SELECT * FROM donations 
                                 WHERE payment_status = 'completed' 
                                 ORDER BY created_at DESC LIMIT 5")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Inkingi Art Space</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .admin-container {
            display: flex;
            min-height: 100vh;
        }
        
        .admin-sidebar {
            width: 250px;
            background-color: var(--primary-color);
            color: white;
            padding: 2rem 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }
        
        .admin-logo {
            padding: 0 2rem 2rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 2rem;
        }
        
        .admin-logo h2 {
            color: white;
            margin: 0;
        }
        
        .admin-nav {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .admin-nav li {
            margin: 0;
        }
        
        .admin-nav a {
            display: block;
            padding: 1rem 2rem;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: var(--transition);
            border-left: 3px solid transparent;
        }
        
        .admin-nav a:hover,
        .admin-nav a.active {
            background-color: rgba(255,255,255,0.1);
            color: white;
            border-left-color: var(--accent-color);
        }
        
        .admin-nav i {
            width: 20px;
            margin-right: 10px;
        }
        
        .admin-main {
            flex: 1;
            margin-left: 250px;
            padding: 2rem;
            background-color: var(--bg-light);
        }
        
        .admin-header {
            background-color: white;
            padding: 1.5rem 2rem;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-light);
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .admin-header h1 {
            margin: 0;
            color: var(--primary-color);
        }
        
        .admin-user {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .admin-user span {
            color: var(--text-light);
        }
        
        .logout-btn {
            background-color: var(--secondary-color);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: var(--transition);
        }
        
        .logout-btn:hover {
            background-color: #c0392b;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background-color: white;
            padding: 2rem;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-light);
            text-align: center;
            transition: var(--transition);
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-medium);
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.5rem;
            color: white;
        }
        
        .stat-icon.artworks { background-color: var(--accent-color); }
        .stat-icon.artists { background-color: var(--secondary-color); }
        .stat-icon.exhibitions { background-color: #9b59b6; }
        .stat-icon.donations { background-color: #27ae60; }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
            display: block;
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            color: var(--text-light);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.9rem;
        }
        
        .dashboard-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
        }
        
        .dashboard-card {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-light);
            overflow: hidden;
        }
        
        .dashboard-card-header {
            background-color: var(--primary-color);
            color: white;
            padding: 1.5rem;
        }
        
        .dashboard-card-header h3 {
            margin: 0;
            color: white;
        }
        
        .dashboard-card-body {
            padding: 1.5rem;
        }
        
        .activity-item {
            display: flex;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid var(--border-color);
        }
        
        .activity-item:last-child {
            border-bottom: none;
        }
        
        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--bg-light);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            color: var(--primary-color);
        }
        
        .activity-content {
            flex: 1;
        }
        
        .activity-title {
            font-weight: 500;
            margin-bottom: 0.25rem;
        }
        
        .activity-meta {
            color: var(--text-light);
            font-size: 0.9rem;
        }
        
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 2rem;
        }
        
        .quick-action {
            background-color: white;
            padding: 1.5rem;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-light);
            text-align: center;
            text-decoration: none;
            color: var(--text-dark);
            transition: var(--transition);
        }
        
        .quick-action:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-medium);
            color: var(--primary-color);
        }
        
        .quick-action i {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: var(--accent-color);
        }
        
        @media (max-width: 768px) {
            .admin-sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            
            .admin-sidebar.open {
                transform: translateX(0);
            }
            
            .admin-main {
                margin-left: 0;
            }
            
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <nav class="admin-sidebar">
            <div class="admin-logo">
                <h2>Admin Panel</h2>
                    <span>Welcome, <?php echo htmlspecialchars($_SESSION['admin_name'] ?? 'Admin'); ?></span>
            <ul class="admin-nav">
                <li><a href="dashboard.php" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="artworks.php"><i class="fas fa-palette"></i> Artworks</a></li>
                <li><a href="artists.php"><i class="fas fa-user"></i> Artists</a></li>
                <li><a href="exhibitions.php"><i class="fas fa-calendar-alt"></i> Exhibitions</a></li>
                <li><a href="events.php"><i class="fas fa-calendar"></i> Events</a></li>
                <li><a href="donations.php"><i class="fas fa-heart"></i> Donations</a></li>
                <li><a href="reviews.php"><i class="fas fa-star"></i> Reviews</a></li>
                <li><a href="pages.php"><i class="fas fa-file-alt"></i> Pages</a></li>
                <li><a href="settings.php"><i class="fas fa-cog"></i> Settings</a></li>
            </ul>
        </nav>

                    <span class="stat-number"><?php echo number_format($stats['artworks'] ?? 0); ?></span>
        <main class="admin-main">
            <div class="admin-header">
                <h1>Dashboard</h1>
                <div class="admin-user">
                    <span>Welcome, <?php echo htmlspecialchars($_SESSION['admin_name'] ?? 'Admin'); ?></span>
                    <a href="logout.php" class="logout-btn">
                    <span class="stat-number"><?php echo number_format($stats['artists'] ?? 0); ?></span>
                        Logout
                    </a>
                </div>
            </div>

            <!-- Statistics -->
                    <span class="stat-number"><?php echo number_format($stats['exhibitions'] ?? 0); ?></span>
                <div class="stat-card">
                    <div class="stat-icon artworks">
                        <i class="fas fa-palette"></i>
                    </div>
                    <span class="stat-number"><?php echo number_format($stats['artworks'] ?? 0); ?></span>
                    <div class="stat-label">Total Artworks</div>
                    <span class="stat-number">$<?php echo number_format($stats['donations_total'] ?? 0, 2); ?></span>
                <div class="stat-card">
                    <div class="stat-icon artists">
                        <i class="fas fa-user"></i>
                    </div>
                    <span class="stat-number"><?php echo number_format($stats['artists'] ?? 0); ?></span>
                    <div class="stat-label">Active Artists</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon exhibitions">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <span class="stat-number"><?php echo number_format($stats['exhibitions'] ?? 0); ?></span>
                    <div class="stat-label">Exhibitions</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon donations">
                        <i class="fas fa-heart"></i>
                    </div>
                    <span class="stat-number">$<?php echo number_format($stats['donations_total'] ?? 0, 2); ?></span>
                    <div class="stat-label">Total Donations</div>
                                        <div class="activity-title"><?php echo htmlspecialchars($artwork['title'] ?? 'Untitled'); ?></div>
            </div>

                                            <?php echo formatDate($artwork['created_at'] ?? ''); ?>
            <div class="dashboard-grid">
                <div class="dashboard-card">
                    <div class="dashboard-card-header">
                        <h3>Recent Artworks</h3>
                    </div>
                    <div class="dashboard-card-body">
                        <?php if (empty($recent_artworks)): ?>
                            <p>No artworks found.</p>
                        <?php else: ?>
                            <?php foreach ($recent_artworks as $artwork): ?>
                                <div class="activity-item">
                                    <div class="activity-icon">
                                        <i class="fas fa-palette"></i>
                                    </div>
                                    <div class="activity-content">
                                        <div class="activity-title"><?php echo htmlspecialchars($artwork['title'] ?? 'Untitled'); ?></div>
                                        <div class="activity-meta">
                                        <?php echo htmlspecialchars($artist_name); ?>
                                        <?php echo formatDate(['created_at']); ?>
                                        </div>
                                    </div>
                                </div>
                                                        <div class="activity-title"><?php echo '$' . number_format($donation['amount'] ?? 0, 2); ?></div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </main>
                    </div>
                
                    <script src="../assets/js/main.js"></script>
                </body>
                </html>
                ?>

                <div class="dashboard-card">
                    <div class="dashboard-card-header">
                        <h3>Recent Donations</h3>
                    </div>
                    <div class="dashboard-card-body">
                        <?php if (empty($recent_donations)): ?>
                            <p>No donations found.</p>
                        <?php else: ?>
                            <?php foreach ($recent_donations as $donation): ?>
                                <div class="activity-item">
                                    <div class="activity-icon">
                                        <i class="fas fa-heart"></i>
                                    </div>
                                    <div class="activity-content">
                                        <div class="activity-title"><?php echo formatPrice(['amount']); ?></div>
                                        <div class="activity-meta">
                                            <?php echo ['is_anonymous'] ? 'Anonymous' : htmlspecialchars(['donor_name']); ?>  
                                            <?php echo formatDate(['created_at']); ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="quick-actions">
                <a href="artworks.php?action=add" class="quick-action">
                    <i class="fas fa-plus"></i>
                    <h4>Add Artwork</h4>
                    <p>Add a new artwork to the gallery</p>
                </a>
                <a href="artists.php?action=add" class="quick-action">
                    <i class="fas fa-user-plus"></i>
                    <h4>Add Artist</h4>
                    <p>Add a new artist profile</p>
                </a>
                <a href="exhibitions.php?action=add" class="quick-action">
                    <i class="fas fa-calendar-plus"></i>
                    <h4>Create Exhibition</h4>
                    <p>Create a new exhibition</p>
                </a>
                <a href="events.php?action=add" class="quick-action">
                    <i class="fas fa-calendar-plus"></i>
                    <h4>Add Event</h4>
                    <p>Add a new event</p>
                </a>
            </div>
        </main>
    </div>

    <script src="../assets/js/main.js"></script>
</body>
</html>
