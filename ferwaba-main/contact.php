<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Ferwaba</title>
    <meta name="description" content="Get in touch with Inkingi Art Space. Visit our gallery, inquire about artworks, or learn about our programs and events.">
    <meta name="keywords" content="contact, art gallery, visit, inquiries, Inkingi Art Space, location, hours">
    
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Navigation -->
      <nav class="navbar">
        <div class="nav-container">
            <div class="nav-logo">
                <a href="index.php" class="nav-brand">
                    <img src="assets/images/logo.png" alt="Ferwaba Logo" class="nav-logo-img" />
                </a>
            </div>
            <div class="nav-menu" id="nav-menu">
                <a href="index.php" class="nav-link">Home</a>
                <a href="about.php" class="nav-link">About</a>
                <a href="contact.php" class="nav-link active">Contact</a>
                <a href="staff.php" class="nav-link">Staff</a>
                <a href="national-team.php" class="nav-link highlight">National Team</a>
                <a href="competitions.php" class="nav-link">Competitions</a>
                
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

            <!-- Contact Form -->
            <div class="contact-form-container" style="flex: 1; min-width: 300px; padding: 30px; background-color: #f9f9f9; border-radius: 12px; box-shadow: 0 8px 20px rgba(0,0,0,0.1);">
    <h2 style="text-align:center; font-size: 28px; margin-bottom: 25px; color: #1a1a1a;">Send Us a Message</h2>
    <form class="contact-form" action="mailto:info@ferwaba.rw" method="POST" enctype="text/plain">
        <div class="form-group" style="display:flex; align-items:center; margin-bottom: 15px;">
            <label for="name" style="flex:0 0 120px; margin-right:10px; font-weight:600;">Full Name *</label>
            <input type="text" id="name" name="name" required 
                   style="flex:1; padding:10px; border:1px solid #ccc; border-radius:6px; font-size:16px;">
        </div>
        <div class="form-group" style="display:flex; align-items:center; margin-bottom: 15px;">
            <label for="email" style="flex:0 0 120px; margin-right:10px; font-weight:600;">Email *</label>
            <input type="email" id="email" name="email" required
                   style="flex:1; padding:10px; border:1px solid #ccc; border-radius:6px; font-size:16px;">
        </div>
        <div class="form-group" style="display:flex; align-items:center; margin-bottom: 15px;">
            <label for="subject" style="flex:0 0 120px; margin-right:10px; font-weight:600;">Subject *</label>
            <input type="text" id="subject" name="subject" required
                   style="flex:1; padding:10px; border:1px solid #ccc; border-radius:6px; font-size:16px;">
        </div>
        <div class="form-group" style="display:flex; align-items:flex-start; margin-bottom: 20px;">
            <label for="message" style="flex:0 0 120px; margin-right:10px; font-weight:600; padding-top:10px;">Message *</label>
            <textarea id="message" name="message" rows="6" required
                      style="flex:1; padding:10px; border:1px solid #ccc; border-radius:6px; font-size:16px; resize: vertical;"></textarea>
        </div>
        <div class="form-actions" style="text-align:center;">
            <button type="submit" 
                    style="background-color:#0077cc; color:#fff; font-size:18px; padding:12px 25px; border:none; border-radius:8px; cursor:pointer; transition:0.3s;">
                <i class="fas fa-paper-plane"></i> Send Message
            </button>
        </div>
    </form>
</div>


        </div>
    </section>

    <!-- Embedded Map -->
    <section class="map-section">
    <div class="container">
        <h3>Our Location</h3>

        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3987.528944789665!2d30.1128779!3d-1.9530892!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x19dca700506d750d%3A0xc2003608f4f76438!2sFERWABA!5e0!3m2!1sen!2srw!4v1731613500000!5m2!1sen!2srw"
            width="100%"
            height="600"
            style="border:0; border-radius:12px;"
            allowfullscreen=""
            loading="lazy">
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
                <p>Rwanda Basketball Federation dedicated to promoting and developing basketball excellence across the nation.</p>
                <div class="social-links">
                    <a href="https://www.instagram.com/ferwaba" target="_blank" class="social-link"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.facebook.com/ferwaba" target="_blank" class="social-link"><i class="fab fa-facebook"></i></a>
                    <a href="https://www.twitter.com/ferwaba" target="_blank" class="social-link"><i class="fab fa-twitter"></i></a>
                    <a href="https://www.youtube.com/@ferwaba" target="_blank" class="social-link"><i class="fab fa-youtube"></i></a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="footer-section">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="rbl.php">RBL</a></li>
                    <li><a href="gmc.php">GMC</a></li>
                    <li><a href="legacy.php">Legacy Cup</a></li>
                    <li><a href="teams.php">National Teams</a></li>
                    <li><a href="about.php">About</a></li>
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
                            width="100%"
                            height="250"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>

        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <p>&copy; 2025 Ferwaba - Rwanda Basketball Federation. All rights reserved.</p>
        </div>
    </div>
</footer>

    <script src="assets/js/main.js"></script>
    <script>
        // Contact form functionality
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('contact-form');
            
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Get form data
                const formData = new FormData(form);
                const data = Object.fromEntries(formData);
                
                // Basic validation
                if (!data.name || !data.email || !data.subject || !data.message) {
                    alert('Please fill in all required fields.');
                    return;
                }
                
                // Email validation
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(data.email)) {
                    alert('Please enter a valid email address.');
                    return;
                }
                
                // In a real application, this would send the data to the server
                alert('Thank you for your message! We will get back to you soon.');
                form.reset();
            });
            
            // FAQ accordion functionality
            const faqItems = document.querySelectorAll('.faq-item');
            
            faqItems.forEach(item => {
                const question = item.querySelector('.faq-question');
                const answer = item.querySelector('.faq-answer');
                const icon = question.querySelector('i');
                
                question.addEventListener('click', function() {
                    const isOpen = answer.style.display === 'block';
                    
                    // Close all other FAQ items
                    faqItems.forEach(otherItem => {
                        if (otherItem !== item) {
                            otherItem.querySelector('.faq-answer').style.display = 'none';
                            otherItem.querySelector('.faq-question i').style.transform = 'rotate(0deg)';
                        }
                    });
                    
                    // Toggle current item
                    if (isOpen) {
                        answer.style.display = 'none';
                        icon.style.transform = 'rotate(0deg)';
                    } else {
                        answer.style.display = 'block';
                        icon.style.transform = 'rotate(180deg)';
                    }
                });
            });
        });
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
