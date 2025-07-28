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
    <title>BOVTS Library - <?php echo h($page_title); ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css?family=Inter:400,500,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" media="all" href="<?php echo url_for('/stylesheets/admin.css?v=1.1'); ?>" />
  </head>

  <body>
    <div class="page-wrapper">
    <header>
       <nav class="navbar" aria-label="Main navigation">


      <div class="nav-left">
       <!-- <a href="/" aria-label="Library Home" style="text-decoration:none;"></a>-->
          <!-- Logo: replace with logo -->
          <!--<span class="logo" aria-hidden="true"> </span>-->
          <a href="<?php echo url_for ('admin/index.php'); ?>" class="menu-btn" role="button" aria-label="menu">Menu</a>
      </div>
            <div class="nav-title">BOVTS Library Admin Area</div>
      <div class="nav-right">
        <?php if ($user_logged_in): ?>
          <span class="user-details" aria-label="Logged in user">
            <span class="user-icon" aria-hidden="true"> </span>
            <span><?php echo h($user_name); ?></span>
          </span>
        <a href="<?php echo url_for('/user_home.php'); ?>" class="user-home-btn" role="button" aria-label="user home">User home</a>

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