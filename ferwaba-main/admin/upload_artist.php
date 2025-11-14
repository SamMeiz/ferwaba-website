<?php
// Admin Upload Artist for Inkingi Art Space
session_start();
require_once '../config/database.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

$db = new Database();
$conn = $db->getConnection();

// Process form submission
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate inputs
    $name = trim($_POST['name']);
    $bio = trim($_POST['bio']);
    $birth_year = (int)$_POST['birth_year'];
    $nationality = trim($_POST['nationality']);
    $art_style = trim($_POST['art_style']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $website = trim($_POST['website']);
    $social_instagram = trim($_POST['social_instagram']);
    $social_facebook = trim($_POST['social_facebook']);
    $social_twitter = trim($_POST['social_twitter']);
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    
    // Handle file upload
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === 0) {
        $upload_dir = '../uploads/artists/';
        
        // Create directory if it doesn't exist
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        // Generate unique filename
        $file_extension = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
        $filename = uniqid('artist_') . '.' . $file_extension;
        $target_file = $upload_dir . $filename;
        
        // Check if file is an image
        $check = getimagesize($_FILES['profile_image']['tmp_name']);
        if ($check !== false) {
            // Upload file
            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file)) {
                $profile_image = 'uploads/artists/' . $filename;
                
                // Insert into database
                $stmt = $conn->prepare("INSERT INTO artists (name, bio, profile_image, website, email, phone, 
                                       social_instagram, social_facebook, social_twitter, birth_year, 
                                       nationality, art_style, is_featured) 
                                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                                       
                $stmt->execute([$name, $bio, $profile_image, $website, $email, $phone, 
                              $social_instagram, $social_facebook, $social_twitter, 
                              $birth_year, $nationality, $art_style, $is_featured]);
                              
                $message = '<div class="alert alert-success">Artist added successfully!</div>';
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
    <title>Add Artist - Admin Dashboard</title>
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
                <li><a href="upload_artwork.php"><i class="fas fa-image"></i> Upload Artwork</a></li>
                <li><a href="upload_artist.php" class="active"><i class="fas fa-user-plus"></i> Add Artist</a></li>
                <li><a href="manage_exhibitions.php"><i class="fas fa-calendar-alt"></i> Exhibitions</a></li>
                <li><a href="manage_donations.php"><i class="fas fa-hand-holding-heart"></i> Donations</a></li>
                <li><a href="settings.php"><i class="fas fa-cog"></i> Settings</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>
        
        <!-- Main Content -->
        <div class="admin-main">
            <div class="admin-header">
                <h1>Add New Artist</h1>
                <div class="admin-user">
                    <span>Welcome, <?php echo $_SESSION['admin_name']; ?></span>
                    <a href="logout.php" class="logout-btn">Logout</a>
                </div>
            </div>
            
            <div class="admin-content">
                <?php echo $message; ?>
                
                <div class="admin-card">
                    <form action="upload_artist.php" method="POST" enctype="multipart/form-data" class="admin-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="name">Artist Name *</label>
                                <input type="text" id="name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="nationality">Nationality *</label>
                                <input type="text" id="nationality" name="nationality" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="bio">Biography *</label>
                            <textarea id="bio" name="bio" rows="4" required></textarea>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="birth_year">Birth Year</label>
                                <input type="number" id="birth_year" name="birth_year">
                            </div>
                            <div class="form-group">
                                <label for="art_style">Art Style *</label>
                                <input type="text" id="art_style" name="art_style" required>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email">
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="tel" id="phone" name="phone">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="website">Website</label>
                            <input type="url" id="website" name="website" placeholder="https://">
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="social_instagram">Instagram</label>
                                <input type="text" id="social_instagram" name="social_instagram" placeholder="@username">
                            </div>
                            <div class="form-group">
                                <label for="social_facebook">Facebook</label>
                                <input type="text" id="social_facebook" name="social_facebook">
                            </div>
                            <div class="form-group">
                                <label for="social_twitter">Twitter</label>
                                <input type="text" id="social_twitter" name="social_twitter" placeholder="@username">
                            </div>
                        </div>
                        
                        <div class="form-row checkbox-row">
                            <div class="form-group checkbox-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="is_featured">
                                    <span>Feature on Homepage</span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="profile_image">Profile Image *</label>
                            <input type="file" id="profile_image" name="profile_image" accept="image/*" required>
                            <p class="form-help">Upload a high-quality portrait image (JPEG, PNG). Recommended size: 800×1000 pixels.</p>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Add Artist</button>
                            <a href="dashboard.php" class="btn btn-outline">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>