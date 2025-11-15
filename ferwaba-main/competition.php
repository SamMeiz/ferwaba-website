<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Competitions - Ferwaba</title>
    <meta name="description" content="Support Inkingi Art Space in promoting contemporary African art and supporting emerging artists. Make a donation today.">
    <meta name="keywords" content="donate, support art, African art, art gallery, cultural support, art funding">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="Support Our Mission - Inkingi Art Space">
    <meta property="og:description" content="Support Inkingi Art Space in promoting contemporary African art and supporting emerging artists.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://inkingiartspace.com/donations.php">
    
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
                <a href="index.php">
                    <h1>Ferwaba</h1>
                </a>
            </div>
            <div class="nav-menu" id="nav-menu">
                <a href="index.php" class="nav-link">Home</a>
                <a href="about.php" class="nav-link">About</a>
                <a href="contact.php" class="nav-link">Contact</a>
                <a href="staff.php" class="nav-link">Staff</a>
                <a href="national-team.php" class="nav-link highlight">National Team</a>
                <a href="competitions.php" class="nav-link active">Competitions</a>
                
            </div>
            <div class="nav-toggle" id="nav-toggle">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </div>
    </nav>
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1>Support Our Mission</h1>
            <p>Help us continue promoting contemporary African art and supporting emerging artists</p>
        </div>
    </section>

    <!-- Donation Impact -->
    <section class="donation-impact">
        <div class="container">
            <div class="impact-grid">
                <div class="impact-card">
                    <div class="impact-icon">
                        <i class="fas fa-palette"></i>
                    </div>
                    <h3>Support Artists</h3>
                    <p>Your donation helps us provide exhibition opportunities, studio space, and financial support to emerging African artists.</p>
                </div>
                <div class="impact-card">
                    <div class="impact-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h3>Education Programs</h3>
                    <p>Fund educational workshops, artist talks, and community programs that make art accessible to everyone.</p>
                </div>
                <div class="impact-card">
                    <div class="impact-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <h3>Gallery Operations</h3>
                    <p>Help maintain our beautiful gallery space and support the day-to-day operations that make our exhibitions possible.</p>
                </div>
                <div class="impact-card">
                    <div class="impact-icon">
                        <i class="fas fa-globe-africa"></i>
                    </div>
                    <h3>Cultural Impact</h3>
                    <p>Contribute to preserving and promoting African culture through contemporary art and cultural dialogue.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Donation Progress -->
    <section class="donation-progress">
        <div class="container">
            <div class="progress-content">
                <h2>Our Annual Goal</h2>
                <div class="progress-stats">
                    <div class="stat">
                        <span class="stat-number">,000</span>
                        <span class="stat-label">Raised This Year</span>
                    </div>
                    <div class="stat">
                        <span class="stat-number">,000</span>
                        <span class="stat-label">Annual Goal</span>
                    </div>
                </div>
                <div class="progress-bar-container">
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: 50%"></div>
                    </div>
                    <p class="progress-text">50% of our annual goal achieved</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Donation Form -->
    <section class="donation-form-section">
        <div class="container">
            <div class="form-container">
                <div class="form-header">
                    <h2>Make a Donation</h2>
                    <p>Choose your donation amount and help us make a difference</p>
                </div>
                
                <form id="donation-form" class="donation-form" action="process_donation.php" method="POST">
                    <!-- Donation Type -->
                    <div class="form-group">
                        <label>Donation Type</label>
                        <div class="donation-type-options">
                            <label class="radio-option">
                                <input type="radio" name="donation_type" value="one_time" checked>
                                <span class="radio-custom"></span>
                                One-time Donation
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="donation_type" value="monthly">
                                <span class="radio-custom"></span>
                                Monthly Donation
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="donation_type" value="yearly">
                                <span class="radio-custom"></span>
                                Annual Donation
                            </label>
                        </div>
                    </div>

                    <!-- Donation Amount -->
                    <div class="form-group">
                        <label>Donation Amount</label>
                        <div class="amount-options">
                            <label class="amount-option">
                                <input type="radio" name="amount" value="25">
                                <span class="amount-button"></span>
                            </label>
                            <label class="amount-option">
                                <input type="radio" name="amount" value="50">
                                <span class="amount-button"></span>
                            </label>
                            <label class="amount-option">
                                <input type="radio" name="amount" value="100">
                                <span class="amount-button"></span>
                            </label>
                            <label class="amount-option">
                                <input type="radio" name="amount" value="250">
                                <span class="amount-button"></span>
                            </label>
                            <label class="amount-option">
                                <input type="radio" name="amount" value="500">
                                <span class="amount-button"></span>
                            </label>
                            <label class="amount-option">
                                <input type="radio" name="amount" value="custom">
                                <span class="amount-button">Custom</span>
                            </label>
                        </div>
                        <div class="custom-amount" id="custom-amount" style="display: none;">
                            <input type="number" name="custom_amount" placeholder="Enter amount" min="1">
                        </div>
                    </div>

                    <!-- Donor Information -->
                    <div class="form-row">
                        <div class="form-group">
                            <label for="donor_name">Full Name *</label>
                            <input type="text" id="donor_name" name="donor_name" required>
                        </div>
                        <div class="form-group">
                            <label for="donor_email">Email Address *</label>
                            <input type="email" id="donor_email" name="donor_email" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="donor_phone">Phone Number</label>
                            <input type="tel" id="donor_phone" name="donor_phone">
                        </div>
                        <div class="form-group">
                            <label for="donor_organization">Organization (Optional)</label>
                            <input type="text" id="donor_organization" name="donor_organization">
                        </div>
                    </div>

                    <!-- Donation Message -->
                    <div class="form-group">
                        <label for="donation_message">Message (Optional)</label>
                        <textarea id="donation_message" name="donation_message" rows="4" placeholder="Tell us why you're supporting Inkingi Art Space..."></textarea>
                    </div>

                    <!-- Anonymous Donation -->
                    <div class="form-group">
                        <label class="checkbox-option">
                            <input type="checkbox" name="is_anonymous" value="1">
                            <span class="checkbox-custom"></span>
                            Make this donation anonymous
                        </label>
                    </div>

                    <!-- Payment Method -->
                    <div class="form-group">
                        <label>Payment Method</label>
                        <div class="payment-methods">
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="credit_card" checked>
                                <span class="payment-icon"><i class="fas fa-credit-card"></i></span>
                                Credit Card
                            </label>
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="paypal">
                                <span class="payment-icon"><i class="fab fa-paypal"></i></span>
                                PayPal
                            </label>
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="bank_transfer">
                                <span class="payment-icon"><i class="fas fa-university"></i></span>
                                Bank Transfer
                            </label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary btn-large">
                            <i class="fas fa-heart"></i>
                            Donate Now
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Donor Recognition -->
    <section class="donor-recognition">
        <div class="container">
            <div class="section-header">
                <h2>Our Generous Supporters</h2>
                <p>Thank you to all our donors who make our mission possible</p>
            </div>
            
            <div class="donor-levels">
                <div class="donor-level">
                    <h3>Visionary Circle</h3>
                    <p>,000+ annually</p>
                    <div class="donor-list">
                        <span>Anonymous Donor</span>
                        <span>Cultural Foundation</span>
                    </div>
                </div>
                <div class="donor-level">
                    <h3>Patron Circle</h3>
                    <p>,000 - ,999 annually</p>
                    <div class="donor-list">
                        <span>Sarah Johnson</span>
                        <span>Michael Chen</span>
                        <span>Art Enthusiasts Group</span>
                    </div>
                </div>
                <div class="donor-level">
                    <h3>Supporter Circle</h3>
                    <p> -  annually</p>
                    <div class="donor-list">
                        <span>Amara Okafor</span>
                        <span>David Wilson</span>
                        <span>Community Arts Council</span>
                        <span>And 15+ more supporters</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
                <!-- <div class="contact-info"> -->
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
        // Donation form functionality
        document.addEventListener('DOMContentLoaded', function() {
            const amountOptions = document.querySelectorAll('input[name="amount"]');
            const customAmountDiv = document.getElementById('custom-amount');
            const customAmountInput = document.querySelector('input[name="custom_amount"]');
            
            amountOptions.forEach(option => {
                option.addEventListener('change', function() {
                    if (this.value === 'custom') {
                        customAmountDiv.style.display = 'block';
                        customAmountInput.focus();
                    } else {
                        customAmountDiv.style.display = 'none';
                        customAmountInput.value = '';
                    }
                });
            });
            
            // Form validation
            const form = document.getElementById('donation-form');
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Validate required fields
                const requiredFields = form.querySelectorAll('[required]');
                let isValid = true;
                
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        isValid = false;
                        field.classList.add('error');
                    } else {
                        field.classList.remove('error');
                    }
                });
                
                // Validate amount selection
                const selectedAmount = form.querySelector('input[name="amount"]:checked');
                if (!selectedAmount) {
                    isValid = false;
                    alert('Please select a donation amount.');
                }
                
                if (isValid) {
                    // In a real application, this would process the donation
                    alert('Thank you for your donation! You will be redirected to the payment processor.');
                    // window.location.href = 'payment_processor.php';
                } else {
                    alert('Please fill in all required fields.');
                }
            });
            
            // Animate progress bar
            const progressFill = document.querySelector('.progress-fill');
            setTimeout(() => {
                progressFill.style.width = '50%';
            }, 500);
        });
    </script>
</body>
</html>
