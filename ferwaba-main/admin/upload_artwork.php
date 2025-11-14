<?php
// Admin Upload Artwork for Inkingi Art Space
session_start();
require_once '../config/database.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

$db = new Database();
$conn = $db->getConnection();

// Get all artists for the dropdown
$artists = $conn->query("SELECT id, name FROM artists WHERE is_active = 1 ORDER BY name")->fetchAll();

// Process form submission
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate inputs
    $title = trim($_POST['title']);
    $artist_id = (int)$_POST['artist_id'];
    $description = trim($_POST['description']);
    $medium = trim($_POST['medium']);
    $dimensions = trim($_POST['dimensions']);
    $year_created = (int)$_POST['year_created'];
    $price = (float)$_POST['price'];
    $is_for_sale = isset($_POST['is_for_sale']) ? 1 : 0;
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    
    // Handle file upload
    if (isset($_FILES['artwork_image']) && $_FILES['artwork_image']['error'] === 0) {
        $upload_dir = '../uploads/artworks/';
        
        // Create directory if it doesn't exist
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        // Generate unique filename
        $file_extension = pathinfo($_FILES['artwork_image']['name'], PATHINFO_EXTENSION);
        $filename = uniqid('artwork_') . '.' . $file_extension;
        $target_file = $upload_dir . $filename;
        
        // Check if file is an image
        $check = getimagesize($_FILES['artwork_image']['tmp_name']);
        if ($check !== false) {
            // Upload file
            if (move_uploaded_file($_FILES['artwork_image']['tmp_name'], $target_file)) {
                $image_url = 'uploads/artworks/' . $filename;
                
                // Get artist name for the alt text
                $artist_stmt = $conn->prepare("SELECT name FROM artists WHERE id = ?");
                $artist_stmt->execute([$artist_id]);
                $artist_name = $artist_stmt->fetch()['name'];
                
                $image_alt = $title . ' by ' . $artist_name;
                
                // Insert into database
                $stmt = $conn->prepare("INSERT INTO artworks (title, artist_id, description, medium, dimensions, 
                                            year_created, price, is_for_sale, is_featured, image_url, image_alt) 
                                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                                            
                $stmt->execute([$title, $artist_id, $description, $medium, $dimensions, 
                              $year_created, $price, $is_for_sale, $is_featured, $image_url, $image_alt]);
                              
                $message = '<div class="alert alert-success">Artwork uploaded successfully!</div>';
            } else {
                $message = '<div class="alert alert-danger">Error uploading file.</div>';
            }
        } else {
            $message = '<div class="alert alert-danger">File is not an image.</div>';
        }
    } else {
        $message = '<div class="alert alert-danger">Please select an image to upload.</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Artwork - Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar (same as dashboard) -->
        <div class="admin-sidebar">
            <div class="admin-logo">
                <h2>Inkingi Admin</h2>
            </div>
            <ul class="admin-nav">
                <li><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="upload_artwork.php" class="active"><i class="fas fa-image"></i> Upload Artwork</a></li>
                <li><a href="upload_artist.php"><i class="fas fa-user-plus"></i> Add Artist</a></li>
                <li><a href="manage_exhibitions.php"><i class="fas fa-calendar-alt"></i> Exhibitions</a></li>
                <li><a href="manage_donations.php"><i class="fas fa-hand-holding-heart"></i> Donations</a></li>
                <li><a href="settings.php"><i class="fas fa-cog"></i> Settings</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>
        
        <!-- Main Content -->
        <div class="admin-main">
            <div class="admin-header">
                <h1>Upload New Artwork</h1>
                <div class="admin-user">
                    <span>Welcome, <?php echo $_SESSION['admin_name']; ?></span>
                    <a href="logout.php" class="logout-btn">Logout</a>
                </div>
            </div>
            
            <div class="admin-content">
                <?php echo $message; ?>
                
                <div class="admin-card">
                    <form action="upload_artwork.php" method="POST" enctype="multipart/form-data" class="admin-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="title">Artwork Title *</label>
                                <input type="text" id="title" name="title" required>
                            </div>
                            <div class="form-group">
                                <label for="artist_id">Artist *</label>
                                <select id="artist_id" name="artist_id" required>
                                    <option value="">Select Artist</option>
                                    <?php foreach ($artists as $artist): ?>
                                    <option value="<?php echo $artist['id']; ?>"><?php echo $artist['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" rows="4"></textarea>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="medium">Medium *</label>
                                <input type="text" id="medium" name="medium" required>
                            </div>
                            <div class="form-group">
                                <label for="dimensions">Dimensions</label>
                                <input type="text" id="dimensions" name="dimensions" placeholder="e.g., 24" × 36"">
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="year_created">Year Created *</label>
                                <input type="number" id="year_created" name="year_created" required>
                            </div>
                            <div class="form-group">
                                <label for="price">Price ($) *</label>
                                <input type="number" id="price" name="price" step="0.01" required>
                            </div>
                        </div>
                        
                        <div class="form-row checkbox-row">
                            <div class="form-group checkbox-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="is_for_sale" checked>
                                    <span>Available for Sale</span>
                                </label>
                            </div>
                            <div class="form-group checkbox-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="is_featured">
                                    <span>Feature on Homepage</span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="artwork_image">Artwork Image *</label>
                            <input type="file" id="artwork_image" name="artwork_image" accept="image/*" required>
                            <p class="form-help">Upload a high-quality image (JPEG, PNG). Recommended size: 1200×800 pixels.</p>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Upload Artwork</button>
                            <a href="dashboard.php" class="btn btn-outline">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>