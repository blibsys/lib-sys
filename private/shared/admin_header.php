<?php 
	if(!isset($page_title)) { $page_title = 'Admin Area'; }
?>

<!doctype html>

<html lang="en">
  <head>
    <title>BOVTS - <?php echo h($page_title); ?></title>
    <meta charset="utf-8">
    <link rel="stylesheet" media="all" href="<?php echo
    url_for('/stylesheets/admin.css'); ?>" />
  </head>

  <body>
    <header>
      <h1>BOVTS Library Admin Area</h1>
    </header>

    <navigation>
      <ul>
        <li><a href="<?php echo url_for('/admin/index.php'); ?>">Menu</a></li>
      </ul>
    </navigation>