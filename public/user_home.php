<?php require_once('../private/initialise.php'); ?>

<?php
// Sample user info - replace with real logic as needed
$user_logged_in = true;
$user_name = "Abbie Bowers";
$notifications = [
  "Welcome back to the library!",
  "Your reserved book is ready for pickup."
]
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>BOVTS Library - <?php echo h($page_title); ?>Home</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Google Fonts: Inter -->
  <link href="https://fonts.googleapis.com/css?family=Inter:400,500,700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" media="all" href="<?php echo url_for('/stylesheets/user.css'); ?>" />
</head>
<body>
  <header>
    <nav class="navbar" aria-label="Main navigation">
      <div class="nav-left">
        <a href="/" aria-label="Library Home" style="text-decoration:none;">
          <!-- Logo: replace with your university/library logo if available -->
          <span class="logo" aria-hidden="true"> </span>
        </a>
        <span class="nav-title">BOVTS Library</span>
      </div>
      <div class="nav-right">
        <?php if ($user_logged_in): ?>
          <span class="user-details" aria-label="Logged in user">
            <span class="user-icon" aria-hidden="true"> </span>
            <span><?php echo h($user_name); ?></span>
          </span>
<a href="<?php echo url_for ('admin/index.php'); ?>" class="admin-btn" role="button" aria-label="Admin home">Admin home</a>
          <form action="logout.php" method="post" style="margin:0;">
            <button class="login-btn" type="submit" aria-label="Log out">Log out</button>
          </form>
        <?php else: ?>
          <form action="login.php" method="get" style="margin:0;">
            <button class="login-btn" type="submit" aria-label="Log in">Log in</button>
          </form>
        <?php endif; ?>

      
      </div>
    </nav>
  </header>

  <!-- Notifications area (ARIA live region for accessibility) -->
  <div class="notifications-area" aria-live="polite" aria-atomic="true">
    <?php foreach ($notifications as $note): ?>
      <span role="status"><?php echo h($note); ?></span>
    <?php endforeach; ?>
  </div>

  <!-- Central catalogue search bar -->
  <main>
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