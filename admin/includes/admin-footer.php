</div><!-- admin-content -->

<footer class="admin-footer">
  <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
    <div>
      <p style="margin: 0; font-weight: 700; color: var(--gray-800);">
        <i class="fas fa-basketball-ball" style="color: var(--primary);"></i>
        FERWABA Management System
      </p>
      <p style="margin: 4px 0 0 0; font-size: 12px; color: var(--gray-600);">
        Rwanda Basketball Federation - Official Administrative Platform
      </p>
    </div>
    <div style="text-align: right;">
      <p style="margin: 0; font-size: 12px; color: var(--gray-600);">
        &copy; <?php echo date('Y'); ?> FERWABA. All rights reserved.
      </p>
      <p style="margin: 4px 0 0 0; font-size: 11px; color: var(--gray-500);">
        Version 2.0 | Powered by Rwanda Sports Technology
      </p>
    </div>
  </div>
</footer>
</main>

<!-- Mobile Sidebar Toggle -->
<button class="sidebar-toggle" id="sidebarToggle"
  onclick="document.getElementById('adminSidebar').classList.toggle('open')">
  <i class="fas fa-bars"></i>
</button>

<script>
  // Auto-refresh time every minute
  setInterval(function () {
    const timeElements = document.querySelectorAll('.admin-topbar .page-title p');
    if (timeElements.length > 0) {
      const now = new Date();
      const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
      const dateStr = now.toLocaleDateString('en-US', options);
      const timeStr = now.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit', hour12: true });
      timeElements[0].innerHTML = `<i class="fas fa-calendar-day"></i> ${dateStr} <span style="margin-left: 12px;"><i class="fas fa-clock"></i> ${timeStr}</span>`;
    }
  }, 60000);
</script>
</body>

</html>