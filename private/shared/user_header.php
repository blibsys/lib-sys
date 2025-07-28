<!doctype html>

<html lang="en">
  <head>
    <title>BOVTS Library <?php if(isset($page_title)) { echo '- ' . h($page_title); } ?></title>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css?family=Inter:400,500,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" media="all" href="<?php echo url_for('/stylesheets/user.css'); ?>" />
  </head>

  <body>

    <header>
      <h1>
        <a href="<?php echo url_for('/index.php'); ?>">
            BOVTS Library
        </a>
      </h1>
    </header>
