<?php 
	if(!isset($page_title)) { $page_title = 'Admin Area'; }
?>
<?php
$user_logged_in = isset($_SESSION['username']);
$user_name = $_SESSION['username'] ?? '';
require_login();
?>

<!doctype html>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>BOVTS Library - <?php echo h($page_title); ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Merriweather:ital,opsz,wght@0,18..144,300..900;1,18..144,300..900&family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&family=Special+Gothic+Expanded+One&family=Titillium+Web:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" media="all" href="<?php echo url_for('/stylesheets/user.css?v=2.2'); ?>" />
</head>
<body>
  <div class="page-wrapper">
  <header>
    <nav class="navbar" aria-label="Main navigation">
      <div class="nav-left">
        <a href="<?php echo url_for('user/index.php'); ?>" class="menu-btn" aria-label="Menu">&#9776;</a>

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

            <?php echo $_SESSION['username'] ?? ''; ?></span>

          </span>
         
         
          <form action="logout.php" method="post" style="margin:0;">
            <a href="<?php echo url_for('/logout.php');?>" class="login-btn" type="submit" aria-label="Log out">Log out</a>
          </form>
        <?php else: ?>
          <form action="login.php" method="get" style="margin:0;">
            <a href="<?php echo url_for('/login.php');?>" class="login-btn" type="submit" aria-label="Log in">Log in</a>
          </form>
        <?php endif; ?>

         <a href="<?php echo url_for ('admin/index.php'); ?>" class="admin-btn" role="button" aria-label="Admin home">Admin home</a>
</div>
    </nav>
    </header>
        <?php echo display_session_message(); ?>   
      
  
