<?php
require_once __DIR__ . '/../includes/bootstrap.php';

// VULN-007 FIX: Contact form now uses server-side processing instead of mailto: action
$contact_error = '';
$contact_success = '';
$contact_name = $contact_email = $contact_subject = $contact_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contact_name    = trim($_POST['name'] ?? '');
    $contact_email   = trim($_POST['email'] ?? '');
    $contact_subject = trim($_POST['subject'] ?? '');
    $contact_message = trim($_POST['message'] ?? '');

    // Honeypot check (bot trap)
    if (!empty($_POST['_hp'])) {
        // Silent exit for bots — pretend success
        $contact_success = true;
    } elseif (!$contact_name || !$contact_email || !$contact_subject || !$contact_message) {
        $contact_error = 'Please fill in all required fields.';
    } elseif (!filter_var($contact_email, FILTER_VALIDATE_EMAIL)) {
        $contact_error = 'Please enter a valid email address.';
    } elseif (strlen($contact_message) > 5000) {
        $contact_error = 'Message is too long (max 5000 characters).';
    } else {
        // Log contact inquiry to DB (if table exists) and DELIVER email to info@ferwaba.rw
        $to = "info@ferwaba.rw";
        $headers = "From: $contact_email\r\nReply-To: $contact_email\r\nX-Mailer: PHP/" . phpversion();
        $mail_subject = "FERWABA Contact Inquiry: " . $contact_subject;
        $mail_body = "Name: $contact_name\nEmail: $contact_email\n\nMessage:\n$contact_message";
        
        try {
            $stmt = $db->prepare("INSERT INTO contact_messages (name, email, subject, message, ip_address) VALUES (?, ?, ?, ?, ?)");
            $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
            $stmt->execute([$contact_name, $contact_email, $contact_subject, $contact_message, $ip]);
        } catch (PDOException $e) {
            error_log("Contact form DB save error (table might not exist): " . $e->getMessage());
        }
        
        // Always send the email
        mail($to, $mail_subject, $mail_body, $headers);
        $contact_success = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Ferwaba</title>
    <meta name="description"
        content="Contact FERWABA, the Rwanda Basketball Federation, for partnerships, competitions, teams, and official inquiries.">
    <meta name="keywords"
        content="FERWABA contact, Rwanda Basketball Federation contact, Rwanda basketball, partnerships, competitions, inquiries">

    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-logo">
                <a href="index" class="nav-brand">
                    <img src="assets/images/logo.png" alt="Ferwaba Logo" class="nav-logo-img" />
                </a>
            </div>
            <div class="nav-menu" id="nav-menu">
                <a href="index" class="nav-link">Home</a>
                <a href="about" class="nav-link">About</a>
                <a href="contact" class="nav-link active">Contact</a>
                <a href="staff" class="nav-link">Staff</a>
                <a href="national-team" class="nav-link highlight">National Team</a>
                <a href="competitions" class="nav-link">Competitions</a>
            </div>
            <div class="nav-toggle" id="nav-toggle">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </div>
    </nav><br><br>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1>Contact FERWABA</h1>
            <p>Reach out to the Rwanda Basketball Federation for inquiries, collaborations, or support.</p>
        </div>
    </section>

    <!-- Contact Info + Form Side-by-Side -->
    <section class="contact-section" style="padding: 60px 0;">
        <div class="container" style="display: flex; flex-wrap: wrap; gap: 40px;">

            <!-- Contact Info -->
            <div class="contact-info" style="flex: 1; min-width: 300px;">
                <div class="contact-card" style="margin-bottom: 20px;">
                    <div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <h3>Head Office</h3>
                    <p>Kigali Arena, KG 17 Avenue, Kigali</p>
                </div>
                <div class="contact-card" style="margin-bottom: 20px;">
                    <div class="contact-icon"><i class="fas fa-phone"></i></div>
                    <h3>Phone</h3>
                    <p>+250 791 586 243</p>
                </div>
                <div class="contact-card">
                    <div class="contact-icon"><i class="fas fa-envelope"></i></div>
                    <h3>Email</h3>
                    <p>info@ferwaba.rw</p>
                </div>
            </div>

            <!-- Contact Form — VULN-007 FIX: now server-side PHP, no mailto: action -->
            <div class="contact-form-container"
                style="flex: 1; min-width: 300px; padding: 30px; background-color: #f9f9f9; border-radius: 12px; box-shadow: 0 8px 20px rgba(0,0,0,0.1);">
                <h2 style="text-align:center; font-size: 28px; margin-bottom: 25px; color: #1a1a1a;">Send Us a Message</h2>

                <?php if (!empty($contact_success)): ?>
                    <div style="background:#d4edda; color:#155724; padding:15px; border-radius:8px; margin-bottom:20px; text-align:center;">
                        <i class="fas fa-check-circle"></i> Thank you! Your message has been received. We'll get back to you soon.
                    </div>
                <?php elseif ($contact_error): ?>
                    <div style="background:#f8d7da; color:#721c24; padding:15px; border-radius:8px; margin-bottom:20px;">
                        <i class="fas fa-exclamation-circle"></i> <?php echo sanitize($contact_error); ?>
                    </div>
                <?php endif; ?>

                <?php if (empty($contact_success)): ?>
                <form id="contact-form" method="POST" action="">
                    <!-- Honeypot field — hidden from real users, bots fill it in -->
                    <input type="text" name="_hp" style="display:none;" tabindex="-1" autocomplete="off">

                    <div class="form-group" style="display:flex; align-items:center; margin-bottom: 15px;">
                        <label for="name" style="flex:0 0 120px; margin-right:10px; font-weight:600;">Full Name *</label>
                        <input type="text" id="name" name="name" required value="<?php echo sanitize($contact_name); ?>"
                            style="flex:1; padding:10px; border:1px solid #ccc; border-radius:6px; font-size:16px;">
                    </div>
                    <div class="form-group" style="display:flex; align-items:center; margin-bottom: 15px;">
                        <label for="email" style="flex:0 0 120px; margin-right:10px; font-weight:600;">Email *</label>
                        <input type="email" id="email" name="email" required value="<?php echo sanitize($contact_email); ?>"
                            style="flex:1; padding:10px; border:1px solid #ccc; border-radius:6px; font-size:16px;">
                    </div>
                    <div class="form-group" style="display:flex; align-items:center; margin-bottom: 15px;">
                        <label for="subject" style="flex:0 0 120px; margin-right:10px; font-weight:600;">Subject *</label>
                        <input type="text" id="subject" name="subject" required value="<?php echo sanitize($contact_subject); ?>"
                            style="flex:1; padding:10px; border:1px solid #ccc; border-radius:6px; font-size:16px;">
                    </div>
                    <div class="form-group" style="display:flex; align-items:flex-start; margin-bottom: 20px;">
                        <label for="message"
                            style="flex:0 0 120px; margin-right:10px; font-weight:600; padding-top:10px;">Message *</label>
                        <textarea id="message" name="message" rows="6" required
                            style="flex:1; padding:10px; border:1px solid #ccc; border-radius:6px; font-size:16px; resize: vertical;"><?php echo sanitize($contact_message); ?></textarea>
                    </div>
                    <div class="form-actions" style="text-align:center;">
                        <button type="submit"
                            style="background-color:#0077cc; color:#fff; font-size:18px; padding:12px 25px; border:none; border-radius:8px; cursor:pointer; transition:0.3s;">
                            <i class="fas fa-paper-plane"></i> Send Message
                        </button>
                    </div>
                </form>
                <?php endif; ?>
            </div>


        </div>
    </section>

    <!-- Embedded Map -->
    <section class="map-section">
        <div class="container">
            <h3>Our Location</h3>

            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3987.528944789665!2d30.1128779!3d-1.9530892!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x19dca700506d750d%3A0xc2003608f4f76438!2sFERWABA!5e0!3m2!1sen!2srw!4v1731613500000!5m2!1sen!2srw"
                width="100%" height="600" style="border:0; border-radius:12px;" allowfullscreen="" loading="lazy">
            </iframe>

        </div>
    </section>

</body>




<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="footer-content">

            <!-- Ferwaba Intro Section -->
            <div class="footer-section">
                <h3>Ferwaba</h3>
                <p>Rwanda Basketball Federation dedicated to promoting and developing basketball excellence across the
                    nation.</p>
                <div class="social-links">
                    <a href="https://www.instagram.com/ferwaba" target="_blank" class="social-link"><i
                            class="fab fa-instagram"></i></a>
                    <a href="https://www.facebook.com/ferwaba" target="_blank" class="social-link"><i
                            class="fab fa-facebook"></i></a>
                    <a href="https://www.twitter.com/ferwaba" target="_blank" class="social-link"><i
                            class="fab fa-twitter"></i></a>
                    <a href="https://www.youtube.com/@ferwaba" target="_blank" class="social-link"><i
                            class="fab fa-youtube"></i></a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="footer-section">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="rbl">RBL</a></li>
                    <li><a href="gmc">GMC</a></li>
                    <li><a href="legacy">Legacy Cup</a></li>
                    <li><a href="teams">National Teams</a></li>
                    <li><a href="about">About</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="footer-section">
                <h4>Contact Info</h4>
                <p><i class="fas fa-map-marker-alt"></i> KG 17 Ave, Kigali</p>
                <p><i class="fas fa-phone"></i> (+250) 791586243</p>
                <p><i class="fas fa-envelope"></i> info@ferwaba.rw</p>
            </div>

            <!-- Google Maps -->
            <div class="footer-section">
                <h4>Visit Us</h4>

                <div class="map-wrapper" style="
                    display:flex;
                    justify-content:center;
                    align-items:center;
                    width:100%;
                    margin:auto;
                ">
                    <div class="map-container" style="
                        width:100%;
                        max-width:600px;
                        border-radius:12px;
                        overflow:hidden;
                        margin:auto;
                    ">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3987.5289447897!2d30.11545!3d-1.95308!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x19dca700506d750d%3A0xc2003608f4f76438!2sFERWABA!5e0!3m2!1sen!2srw!4v1731610000000!5m2!1sen!2srw"
                            width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>

        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <p>&copy; 2025 Ferwaba - Rwanda Basketball Federation. All rights reserved.</p>
            <div style="margin-top:8px; display:flex; justify-content:center; gap:16px; flex-wrap:wrap;">
                <a href="privacy" style="color:rgba(255,255,255,0.8); text-decoration:none;">Privacy Policy</a>
                <a href="terms" style="color:rgba(255,255,255,0.8); text-decoration:none;">Terms of Use</a>
                <a href="accessibility" style="color:rgba(255,255,255,0.8); text-decoration:none;">Accessibility</a>
            </div>
        </div>
    </div>
</footer>

<script src="assets/js/main.js"></script>
<script>
    // Mobile navigation toggle
    const navToggle = document.getElementById('nav-toggle');
    const navMenu = document.getElementById('nav-menu');

    if (navToggle) {
        navToggle.addEventListener('click', () => {
            navMenu.classList.toggle('active');
            navToggle.classList.toggle('active');
        });
    }
</script>
</body>

</html>
