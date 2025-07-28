<?php 
	if(!isset($page_title)) { $page_title = 'Admin Area'; }
?>

<!doctype html>

<html lang="en">
  <head>
    <title>BOVTS Library - <?php echo h($page_title); ?></title>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css?family=Inter:400,500,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" media="all" href="<?php echo url_for('/stylesheets/admin.css?v=1.1'); ?>" />
  
  
  </head>

  <body>
    <header>
      <h1 id="admin-header">BOVTS Library Admin Area</h1>

      <a href="<?php echo url_for ('admin/index.php'); ?>" class="admin-btn" role="button" aria-label="Admin home">Admin home</a>
      
    </header>

    <nav>
      <ul>
        <li><a href="<?php echo url_for('/admin/index.php'); ?>">Menu</a></li>
      </ul>
    </nav>

