<?php 
	if(!isset($page_title)) { $page_title = 'Login'; }
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
        <a href="<?php echo url_for('/'); ?>" aria-label="Library Home" style="text-decoration:none;">
          <span class="logo" aria-hidden="true">
            <img src="<?php echo url_for('/images/logo.svg'); ?>" alt="BOVTS Library Logo" /> 
          </span>
        </a>
        <span class="nav-title">Library Login</span>
      </div>
    </nav>
  </header>
  
  <?php echo display_session_message(); ?>
