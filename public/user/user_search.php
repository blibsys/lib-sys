<?php require_once('../../private/initialise.php'); ?>

<?php $page_title = 'Homepage'; ?>
<?php include(SHARED_PATH . '/user_header.php'); ?>

  <!-- Notifications area (ARIA live region for accessibility) -->
  <!--<div class="notifications-area" aria-live="polite" aria-atomic="true">
    <?php foreach ($notifications as $note): ?>
      <span role="status"><?php echo h($note); ?></span>
    <?php endforeach; ?>
  </div>-->

  <!-- Central catalogue search bar -->
  <main aria-label="main content">
    <section class="search-section" aria-label="Library catalogue search">
      <label for="catalogue-search" class="search-label">Search the Library Catalogue</label>
      <form class="search-form" action="search.php" method="get" role="search" aria-label="Catalogue search form">
        <input
          id="catalogue-search"
          name="q"
          class="search-input"
          type="search"
          placeholder="Search by title, author, keyword..."
          aria-label="Search the library catalogue"
          required
        >
        <button class="search-submit" type="submit" aria-label="Search">
          <!-- Accessible SVG search icon -->
          <svg viewBox="0 0 24 24" width="22" height="22" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
            <circle cx="11" cy="11" r="7" stroke="white" stroke-width="2"/>
            <line x1="17.5" y1="17.5" x2="21" y2="21" stroke="white" stroke-width="2" stroke-linecap="round"/>
          </svg>
        </button>
      </form>
    </section>
  </main>
</body>
</html>


...
<form method="GET" action="search.php">
  <input type="text" name="query" placeholder="Search...">
  <input type="submit" value="Search">
</form>