<?php 
	if(!isset($page_title)) { $page_title = 'Admin Area'; }
?>
<?php
// Sample user info - replace with real logic as needed
$user_logged_in = true;
$user_name = "Abbie Bowers";?>

<!doctype html>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>BOVTS Library - <?php echo h($page_title); ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Google Fonts: Inter -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&family=Titillium+Web:wght@400;600;700&family=Merriweather:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" media="all" href="<?php echo url_for('/stylesheets/user.css?v=1.2'); ?>" />
</head>
<body>
  <header>
    <nav class="navbar" aria-label="Main navigation">
      <div class="nav-left">
        <a href="/" aria-label="Library Home" style="text-decoration:none;">
          <span class="logo" aria-hidden="true">
            <img src="<?php echo url_for('/images/logo.svg'); ?>" alt="BOVTS Library Logo" /> 
          </span>
        </a>
        <span class="nav-title">Library</span>
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
