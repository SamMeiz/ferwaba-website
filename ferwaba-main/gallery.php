<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery - Inkingi Art Space</title>
    <meta name="description" content="Explore our curated collection of contemporary African artworks. Filter by artist, medium, style, and more.">
    <meta name="keywords" content="African art gallery, contemporary art, artworks, paintings, sculptures, mixed media">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="Gallery - Inkingi Art Space">
    <meta property="og:description" content="Explore our curated collection of contemporary African artworks.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://inkingiartspace.com/gallery.php">
    
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
                    <h1>Inkingi Art Space</h1>
                </a>
            </div>
            <div class="nav-menu" id="nav-menu">
                <a href="index.php" class="nav-link">Home</a>
                <a href="gallery.php" class="nav-link active">Gallery</a>
                <a href="artists.php" class="nav-link">Artists</a>
                <a href="exhibitions.php" class="nav-link">Exhibitions</a>
                <a href="donations.php" class="nav-link highlight">Donations</a>
                <a href="about.php" class="nav-link">About</a>
                <a href="contact.php" class="nav-link">Contact</a>
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
            <h1>Gallery</h1>
            <p>Explore our curated collection of contemporary African artworks</p>
        </div>
    </section>

    <!-- Gallery Filters -->
    <section class="gallery-filters">
        <div class="container">
            <div class="filters-container">
                <div class="search-box">
                    <input type="text" id="search-input" placeholder="Search artworks...">
                    <i class="fas fa-search"></i>
                </div>
                
                <div class="filter-buttons">
                    <button class="filter-btn active" data-filter="all">All</button>
                    <button class="filter-btn" data-filter="painting">Paintings</button>
                    <button class="filter-btn" data-filter="sculpture">Sculptures</button>
                    <button class="filter-btn" data-filter="mixed-media">Mixed Media</button>
                    <button class="filter-btn" data-filter="photography">Photography</button>
                    <button class="filter-btn" data-filter="digital">Digital Art</button>
                </div>
                
                <div class="filter-dropdowns">
                    <select id="artist-filter">
                        <option value="">All Artists</option>
                        <option value="sarah-mwangi">Sarah Mwangi</option>
                        <option value="kwame-asante">Kwame Asante</option>
                        <option value="amina-okafor">Amina Okafor</option>
                        <option value="john-mutua">John Mutua</option>
                    </select>
                    
                    <select id="price-filter">
                        <option value="">All Prices</option>
                        <option value="0-1000">Under ,000</option>
                        <option value="1000-2500">,000 - ,500</option>
                        <option value="2500-5000">,500 - ,000</option>
                        <option value="5000+">,000+</option>
                    </select>
                    
                    <select id="year-filter">
                        <option value="">All Years</option>
                        <option value="2024">2024</option>
                        <option value="2023">2023</option>
                        <option value="2022">2022</option>
                        <option value="2021">2021</option>
                    </select>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Grid -->
    <section class="gallery-grid-section">
        <div class="container">
            <div class="gallery-stats">
                <p>Showing <span id="artwork-count">24</span> artworks</p>
            </div>
            
            <div class="gallery-grid" id="gallery-grid">
                <!-- Artwork 1 -->
                <div class="artwork-card painting" data-artist="sarah-mwangi" data-price="2500" data-year="2024">
                    <div class="artwork-image">
                        <img src="assets/images/artwork-1.jpg" alt="Harmony in Colors by Sarah Mwangi">
                        <div class="artwork-overlay">
                            <div class="overlay-buttons">
                                <button class="btn btn-outline" onclick="viewArtwork(1)">View Details</button>
                                <button class="btn btn-primary" onclick="inquireArtwork(1)">Inquire</button>
                            </div>
                        </div>
                    </div>
                    <div class="artwork-info">
                        <h3>Harmony in Colors</h3>
                        <p class="artist-name">by Sarah Mwangi</p>
                        <p class="artwork-details">Oil on Canvas  2024  24"  36"</p>
                        <p class="artwork-price">,500</p>
                    </div>
                </div>

                <!-- Artwork 2 -->
                <div class="artwork-card sculpture" data-artist="kwame-asante" data-price="3200" data-year="2023">
                    <div class="artwork-image">
                        <img src="assets/images/artwork-2.jpg" alt="Urban Rhythms by Kwame Asante">
                        <div class="artwork-overlay">
                            <div class="overlay-buttons">
                                <button class="btn btn-outline" onclick="viewArtwork(2)">View Details</button>
                                <button class="btn btn-primary" onclick="inquireArtwork(2)">Inquire</button>
                            </div>
                        </div>
                    </div>
                    <div class="artwork-info">
                        <h3>Urban Rhythms</h3>
                        <p class="artist-name">by Kwame Asante</p>
                        <p class="artwork-details">Bronze Sculpture  2023  18"  12"  8"</p>
                        <p class="artwork-price">,200</p>
                    </div>
                </div>

                <!-- Artwork 3 -->
                <div class="artwork-card mixed-media" data-artist="amina-okafor" data-price="1800" data-year="2024">
                    <div class="artwork-image">
                        <img src="assets/images/artwork-3.jpg" alt="Cultural Heritage by Amina Okafor">
                        <div class="artwork-overlay">
                            <div class="overlay-buttons">
                                <button class="btn btn-outline" onclick="viewArtwork(3)">View Details</button>
                                <button class="btn btn-primary" onclick="inquireArtwork(3)">Inquire</button>
                            </div>
                        </div>
                    </div>
                    <div class="artwork-info">
                        <h3>Cultural Heritage</h3>
                        <p class="artist-name">by Amina Okafor</p>
                        <p class="artwork-details">Mixed Media  2024  30"  24"</p>
                        <p class="artwork-price">,800</p>
                    </div>
                </div>

                <!-- Artwork 4 -->
                <div class="artwork-card painting" data-artist="john-mutua" data-price="4200" data-year="2023">
                    <div class="artwork-image">
                        <img src="assets/images/artwork-4.jpg" alt="African Dreams by John Mutua">
                        <div class="artwork-overlay">
                            <div class="overlay-buttons">
                                <button class="btn btn-outline" onclick="viewArtwork(4)">View Details</button>
                                <button class="btn btn-primary" onclick="inquireArtwork(4)">Inquire</button>
                            </div>
                        </div>
                    </div>
                    <div class="artwork-info">
                        <h3>African Dreams</h3>
                        <p class="artist-name">by John Mutua</p>
                        <p class="artwork-details">Acrylic on Canvas  2023  36"  48"</p>
                        <p class="artwork-price">,200</p>
                    </div>
                </div>

                <!-- Artwork 5 -->
                <div class="artwork-card photography" data-artist="sarah-mwangi" data-price="1200" data-year="2024">
                    <div class="artwork-image">
                        <img src="assets/images/artwork-5.jpg" alt="Street Life by Sarah Mwangi">
                        <div class="artwork-overlay">
                            <div class="overlay-buttons">
                                <button class="btn btn-outline" onclick="viewArtwork(5)">View Details</button>
                                <button class="btn btn-primary" onclick="inquireArtwork(5)">Inquire</button>
                            </div>
                        </div>
                    </div>
                    <div class="artwork-info">
                        <h3>Street Life</h3>
                        <p class="artist-name">by Sarah Mwangi</p>
                        <p class="artwork-details">Digital Photography  2024  20"  30"</p>
                        <p class="artwork-price">,200</p>
                    </div>
                </div>

                <!-- Artwork 6 -->
                <div class="artwork-card digital" data-artist="kwame-asante" data-price="950" data-year="2024">
                    <div class="artwork-image">
                        <img src="assets/images/artwork-6.jpg" alt="Digital Visions by Kwame Asante">
                        <div class="artwork-overlay">
                            <div class="overlay-buttons">
                                <button class="btn btn-outline" onclick="viewArtwork(6)">View Details</button>
                                <button class="btn btn-primary" onclick="inquireArtwork(6)">Inquire</button>
                            </div>
                        </div>
                    </div>
                    <div class="artwork-info">
                        <h3>Digital Visions</h3>
                        <p class="artist-name">by Kwame Asante</p>
                        <p class="artwork-details">Digital Art  2024  24"  18"</p>
                        <p class="artwork-price"></p>
                    </div>
                </div>

                <!-- Add more artworks as needed -->
                <div class="artwork-card painting" data-artist="amina-okafor" data-price="2800" data-year="2023">
                    <div class="artwork-image">
                        <img src="assets/images/artwork-7.jpg" alt="Modern Traditions by Amina Okafor">
                        <div class="artwork-overlay">
                            <div class="overlay-buttons">
                                <button class="btn btn-outline" onclick="viewArtwork(7)">View Details</button>
                                <button class="btn btn-primary" onclick="inquireArtwork(7)">Inquire</button>
                            </div>
                        </div>
                    </div>
                    <div class="artwork-info">
                        <h3>Modern Traditions</h3>
                        <p class="artist-name">by Amina Okafor</p>
                        <p class="artwork-details">Oil on Canvas  2023  28"  36"</p>
                        <p class="artwork-price">,800</p>
                    </div>
                </div>

                <div class="artwork-card sculpture" data-artist="john-mutua" data-price="5500" data-year="2024">
                    <div class="artwork-image">
                        <img src="assets/images/artwork-8.jpg" alt="Spiritual Connection by John Mutua">
                        <div class="artwork-overlay">
                            <div class="overlay-buttons">
                                <button class="btn btn-outline" onclick="viewArtwork(8)">View Details</button>
                                <button class="btn btn-primary" onclick="inquireArtwork(8)">Inquire</button>
                            </div>
                        </div>
                    </div>
                    <div class="artwork-info">
                        <h3>Spiritual Connection</h3>
                        <p class="artist-name">by John Mutua</p>
                        <p class="artwork-details">Wood & Metal  2024  24"  16"  12"</p>
                        <p class="artwork-price">,500</p>
                    </div>
                </div>
            </div>
            
            <div class="load-more-container">
                <button class="btn btn-secondary" id="load-more-btn">Load More Artworks</button>
            </div>
        </div>
    </section>

    <!-- Artwork Modal -->
    <div id="artwork-modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <div class="modal-body">
                <div class="modal-image">
                    <img id="modal-artwork-image" src="" alt="">
                </div>
                <div class="modal-info">
                    <h2 id="modal-artwork-title"></h2>
                    <p id="modal-artist-name"></p>
                    <p id="modal-artwork-details"></p>
                    <p id="modal-artwork-description"></p>
                    <div class="modal-price">
                        <span id="modal-artwork-price"></span>
                    </div>
                    <div class="modal-actions">
                        <button class="btn btn-primary" onclick="inquireArtwork()">Inquire About This Artwork</button>
                        <button class="btn btn-outline" onclick="shareArtwork()">Share</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Inkingi Art Space</h3>
                    <p>Contemporary African Art Gallery dedicated to showcasing exceptional talent and fostering cultural dialogue.</p>
                    <div class="social-links">
                        <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
                <div class="footer-section">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="gallery.php">Gallery</a></li>
                        <li><a href="artists.php">Artists</a></li>
                        <li><a href="exhibitions.php">Exhibitions</a></li>
                        <li><a href="about.php">About</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Contact Info</h4>
                    <div class="contact-info">
                        <p><i class="fas fa-map-marker-alt"></i> Gasabo District, Kacyiru, 24 KG 550 st</p>
                        <p><i class="fas fa-phone"></i>(+250)788299791</p>
                        <p><i class="fas fa-envelope"></i> info@inkingiartspace.com</p>
                    </div>
                </div>
                <div class="footer-section">
                    <h4>Visit Us</h4>
                <div class="map-container" style="border-radius: 12px; overflow: hidden; max-width: 100%; margin: auto;">
                    <iframe
                      src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.709508591165!2d30.081878!3d-1.936026!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x19dca7f283280a65%3A0xc1e7669c3b4abb84!2sInkingi%20Arts%20Space!5e0!3m2!1sen!2srw!4v1726146000000!5m2!1sen!2srw"
                      width="100%"
                      height="350"
                      style="border:0;"
                      allowfullscreen=""
                      loading="lazy"
                      referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                    <div style="text-align: center; margin-top: 10px;">
                    <a href="http://google.com/maps/place/Inkingi+Arts+Space/@-1.949696,30.1006848,12z/data=!4m6!3m5!1s0x19dca7f283280a65:0xc1e7669c3b4abb84!8m2!3d-1.9360256!4d30.0853119!16s%2Fg%2F11vj6076p_?entry=ttu&g_ep=EgoyMDI1MDkwOS4wIKXMDSoASAFQAw%3D%3D" 
                     target="_blank" 
                     style="color: #0077cc; text-decoration: none; font-weight: 600;">
                    📍 Open Inkingi Arts Space on Google Maps
                    </a>
                </div>
                </div>
             </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 Inkingi Art Space. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="assets/js/main.js"></script>
    <script>
        // Gallery-specific JavaScript
        let currentArtworkId = null;
        
        function viewArtwork(id) {
            currentArtworkId = id;
            // In a real application, this would fetch artwork details from the database
            const modal = document.getElementById('artwork-modal');
            const artworkData = getArtworkData(id);
            
            document.getElementById('modal-artwork-image').src = artworkData.image;
            document.getElementById('modal-artwork-title').textContent = artworkData.title;
            document.getElementById('modal-artist-name').textContent = 'by ' + artworkData.artist;
            document.getElementById('modal-artwork-details').textContent = artworkData.details;
            document.getElementById('modal-artwork-description').textContent = artworkData.description;
            document.getElementById('modal-artwork-price').textContent = artworkData.price;
            
            modal.style.display = 'block';
        }
        
        function closeModal() {
            document.getElementById('artwork-modal').style.display = 'none';
        }
        
        function inquireArtwork(id) {
            if (id) currentArtworkId = id;
            // Redirect to contact page with artwork inquiry
            window.location.href = 'contact.php?inquiry=artwork&id=' + currentArtworkId;
        }
        
        function shareArtwork() {
            if (navigator.share) {
                navigator.share({
                    title: document.getElementById('modal-artwork-title').textContent,
                    text: 'Check out this amazing artwork from Inkingi Art Space',
                    url: window.location.href
                });
            } else {
                // Fallback: copy to clipboard
                navigator.clipboard.writeText(window.location.href);
                alert('Link copied to clipboard!');
            }
        }
        
        function getArtworkData(id) {
            // Mock data - in real application, fetch from database
            const artworks = {
                1: {
                    image: 'assets/images/artwork-1.jpg',
                    title: 'Harmony in Colors',
                    artist: 'Sarah Mwangi',
                    details: 'Oil on Canvas  2024  24"  36"',
                    description: 'A vibrant exploration of color and form, this painting captures the essence of contemporary African art through bold brushstrokes and harmonious color relationships.',
                    price: ',500'
                },
                2: {
                    image: 'assets/images/artwork-2.jpg',
                    title: 'Urban Rhythms',
                    artist: 'Kwame Asante',
                    details: 'Bronze Sculpture  2023  18"  12"  8"',
                    description: 'This bronze sculpture explores the dynamic energy of urban life, capturing movement and rhythm in a static form.',
                    price: ',200'
                }
                // Add more artwork data as needed
            };
            return artworks[id] || artworks[1];
        }
        
        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('artwork-modal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
        
        // Update artwork count
        function updateArtworkCount() {
            const visibleArtworks = document.querySelectorAll('.artwork-card:not([style*="display: none"])');
            document.getElementById('artwork-count').textContent = visibleArtworks.length;
        }
        
        // Enhanced filter functionality
        document.addEventListener('DOMContentLoaded', function() {
            const filterButtons = document.querySelectorAll('.filter-btn');
            const artistFilter = document.getElementById('artist-filter');
            const priceFilter = document.getElementById('price-filter');
            const yearFilter = document.getElementById('year-filter');
            const searchInput = document.getElementById('search-input');
            
            function applyFilters() {
                const activeFilter = document.querySelector('.filter-btn.active').getAttribute('data-filter');
                const selectedArtist = artistFilter.value;
                const selectedPrice = priceFilter.value;
                const selectedYear = yearFilter.value;
                const searchTerm = searchInput.value.toLowerCase();
                
                document.querySelectorAll('.artwork-card').forEach(card => {
                    let show = true;
                    
                    // Category filter
                    if (activeFilter !== 'all' && !card.classList.contains(activeFilter)) {
                        show = false;
                    }
                    
                    // Artist filter
                    if (selectedArtist && card.getAttribute('data-artist') !== selectedArtist) {
                        show = false;
                    }
                    
                    // Price filter
                    if (selectedPrice) {
                        const price = parseInt(card.getAttribute('data-price'));
                        if (selectedPrice === '0-1000' && price >= 1000) show = false;
                        if (selectedPrice === '1000-2500' && (price < 1000 || price > 2500)) show = false;
                        if (selectedPrice === '2500-5000' && (price < 2500 || price > 5000)) show = false;
                        if (selectedPrice === '5000+' && price < 5000) show = false;
                    }
                    
                    // Year filter
                    if (selectedYear && card.getAttribute('data-year') !== selectedYear) {
                        show = false;
                    }
                    
                    // Search filter
                    if (searchTerm) {
                        const text = card.textContent.toLowerCase();
                        if (!text.includes(searchTerm)) show = false;
                    }
                    
                    card.style.display = show ? 'block' : 'none';
                });
                
                updateArtworkCount();
            }
            
            filterButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    filterButtons.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    applyFilters();
                });
            });
            
            artistFilter.addEventListener('change', applyFilters);
            priceFilter.addEventListener('change', applyFilters);
            yearFilter.addEventListener('change', applyFilters);
            searchInput.addEventListener('input', applyFilters);
            
            // Load more functionality
            document.getElementById('load-more-btn').addEventListener('click', function() {
                // In a real application, this would load more artworks from the database
                alert('Loading more artworks...');
            });
        });
    </script>
</body>
</html>
