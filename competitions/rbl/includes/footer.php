</main>

<style>
  /* Professional Government Footer */
  .site-footer {
    background: linear-gradient(180deg, #1a365d 0%, #0f2744 100%);
    color: #fff;
    padding: 0;
    font-family: 'Inter', sans-serif;
    margin-top: 80px;
  }

  .footer-main {
    max-width: 1400px;
    margin: 0 auto;
    padding: 60px 40px 40px;
  }

  .footer-grid {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1fr;
    gap: 60px;
    margin-bottom: 50px;
  }

  .footer-brand h3 {
    font-size: 24px;
    font-weight: 800;
    margin: 0 0 8px 0;
    color: #fff;
  }

  .footer-brand .tagline {
    color: #fbbf24;
    font-size: 13px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 20px;
  }

  .footer-brand p {
    color: rgba(255, 255, 255, 0.85);
    font-size: 14px;
    line-height: 1.7;
    margin-bottom: 24px;
  }

  .footer-social-icons {
    display: flex;
    gap: 12px;
  }

  .footer-social-icons a {
    width: 42px;
    height: 42px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fbbf24 !important;
    font-size: 18px;
    transition: all 0.3s ease;
    text-decoration: none;
    border: 1px solid rgba(251, 191, 36, 0.5);
  }

  .footer-social-icons a i {
    color: #fbbf24 !important;
  }

  .footer-social-icons a:hover {
    background: #fbbf24;
    color: #1a365d;
    transform: translateY(-3px);
  }

  .footer-column h4 {
    font-size: 15px;
    font-weight: 700;
    color: #fff;
    margin: 0 0 20px 0;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .footer-column a {
    display: block;
    color: #fbbf24 !important;
    text-decoration: none !important;
    font-size: 14px;
    padding: 8px 0;
    transition: all 0.2s ease;
    font-weight: 500;
  }

  .footer-column a:hover {
    color: #fcd34d;
    padding-left: 8px;
    text-shadow: 0 0 8px rgba(251, 191, 36, 0.5);
  }

  .footer-column a i {
    margin-right: 8px;
    width: 16px;
  }

  .footer-partners-section {
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    padding-top: 40px;
    margin-bottom: 40px;
  }

  .footer-partners-section h4 {
    font-size: 13px;
    font-weight: 600;
    color: rgba(255, 255, 255, 0.5);
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 20px;
    text-align: center;
  }

  .footer-partners-logos {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 40px;
    flex-wrap: wrap;
  }

  .footer-partners-logos a {
    opacity: 0.7;
    transition: opacity 0.3s ease;
  }

  .footer-partners-logos a:hover {
    opacity: 1;
  }

  .footer-partners-logos img {
    max-height: 50px;
    max-width: 120px;
    object-fit: contain;
    filter: brightness(0) invert(1);
  }

  .footer-bottom-bar {
    background: rgba(0, 0, 0, 0.3);
    padding: 20px 40px;
  }

  .footer-bottom-inner {
    max-width: 1400px;
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
  }

  .footer-bottom-bar p {
    margin: 0;
    color: rgba(255, 255, 255, 0.85);
    font-size: 13px;
  }

  .footer-legal-links {
    display: flex;
    gap: 24px;
  }

  .footer-legal-links a {
    color: #fbbf24 !important;
    text-decoration: none !important;
    font-size: 13px;
    transition: color 0.2s ease;
  }

  .footer-legal-links a:hover {
    color: #fcd34d;
  }

  @media (max-width: 1024px) {
    .footer-grid {
      grid-template-columns: repeat(2, 1fr);
      gap: 40px;
    }
  }

  @media (max-width: 768px) {
    .footer-main {
      padding: 40px 20px 30px;
    }

    .footer-grid {
      grid-template-columns: 1fr;
      gap: 30px;
      text-align: center;
    }

    .footer-social-icons {
      justify-content: center;
    }

    .footer-column a:hover {
      padding-left: 0;
    }

    .footer-bottom-bar {
      padding: 20px;
    }

    .footer-bottom-inner {
      flex-direction: column;
      text-align: center;
    }

    .footer-legal-links {
      flex-wrap: wrap;
      justify-content: center;
    }
  }
</style>

<footer class="site-footer">
  <div class="footer-main">
    <div class="footer-grid">
      <!-- Brand Column -->
      <div class="footer-brand">
        <h3>Rwanda Basketball League</h3>
        <p class="tagline">Official Competition by FERWABA</p>
        <p>The premier professional basketball competition in Rwanda, featuring the best teams and players competing for
          national glory.</p>
        <div class="footer-social-icons">
          <a href="https://www.facebook.com/ferwaba" target="_blank" aria-label="Facebook">
            <i class="fab fa-facebook-f"></i>
          </a>
          <a href="https://twitter.com/ferwaba" target="_blank" aria-label="X / Twitter">
            <i class="fab fa-x-twitter"></i>
          </a>
          <a href="https://www.instagram.com/ferwaba" target="_blank" aria-label="Instagram">
            <i class="fab fa-instagram"></i>
          </a>
          <a href="https://www.tiktok.com/@ferwaba" target="_blank" aria-label="TikTok">
            <i class="fab fa-tiktok"></i>
          </a>
          <a href="https://www.youtube.com/@ferwaba" target="_blank" aria-label="YouTube">
            <i class="fab fa-youtube"></i>
          </a>
        </div>
      </div>

      <!-- Quick Links -->
      <div class="footer-column">
        <h4>Quick Links</h4>
        <a href="games"><i class="fas fa-calendar"></i>Schedule</a>
        <a href="standings"><i class="fas fa-trophy"></i>Standings</a>
        <a href="teams"><i class="fas fa-users"></i>Teams</a>
        <a href="players"><i class="fas fa-user"></i>Players</a>
        <a href="news"><i class="fas fa-newspaper"></i>News</a>
      </div>

      <!-- Competitions -->
      <div class="footer-column">
        <h4>Competitions</h4>
        <a href="../../../ferwaba-main/index">FERWABA Main</a>
        <a href="../../gmc">GMC</a>
        <a href="../../heroes">Heroes Cup</a>
        <a href="playoffs">Playoffs</a>
        <a href="national-team">National Teams</a>
      </div>

      <!-- Resources -->
      <div class="footer-column">
        <h4>Resources</h4>
        <a href="https://ticqet.rw/" target="_blank"><i class="fas fa-ticket-alt"></i>Buy Tickets</a>
        <a href="shop"><i class="fas fa-shopping-bag"></i>Official Shop</a>
        <a href="gallery"><i class="fas fa-images"></i>Gallery</a>
        <a href="../../../ferwaba-main/contact"><i class="fas fa-envelope"></i>Contact Us</a>
      </div>
    </div>

    <!-- Partners Section -->
    <div class="footer-partners-section">
      <h4>Official Partners</h4>
      <div class="footer-partners-logos">
        <?php
        $partners_query = $mysqli->query("SELECT name, logo, website_url FROM partners WHERE is_active = 1 ORDER BY display_order ASC LIMIT 6");
        if ($partners_query && $partners_query->num_rows > 0):
          while ($partner = $partners_query->fetch_assoc()):
            ?>
            <a href="<?php echo !empty($partner['website_url']) ? sanitize($partner['website_url']) : '#'; ?>"
              target="_blank" rel="noopener noreferrer">
              <img src="../../../admin/uploads/<?php echo sanitize($partner['logo']); ?>"
                alt="<?php echo sanitize($partner['name']); ?>">
            </a>
            <?php
          endwhile;
        else:
          echo '<p style="color: rgba(255,255,255,0.5); font-size: 13px;">Partner logos coming soon</p>';
        endif;
        ?>
      </div>
    </div>
  </div>

  <!-- Bottom Bar -->
  <div class="footer-bottom-bar">
    <div class="footer-bottom-inner">
      <p>&copy; <?php echo date('Y'); ?> FERWABA - Federation Rwandaise de Basketball. All rights reserved.</p>
      <div class="footer-legal-links">
        <a href="../../../ferwaba-main/privacy">Privacy Policy</a>
        <a href="../../../ferwaba-main/terms">Terms of Use</a>
        <a href="../../../ferwaba-main/accessibility">Accessibility</a>
      </div>
    </div>
  </div>
</footer>
</body>

</html>