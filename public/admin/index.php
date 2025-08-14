<?php require_once('../../private/init.php'); 

//require_admin(); 
?>

<?php $page_title = 'Admin Menu'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>
<main aria-label="main content">
<div id="content">
  <div id="main-menu">
    <h1>Modules</h1>
    <div class="module-tiles">

      <a class="tile" href="<?php echo url_for('/admin/items/index.php'); ?>">
        <!--<span class="tile-icon"></span>-->
        <span class="tile-title">Items</span>
</a>
      <a class="tile" href="<?php echo url_for('/admin/users/index.php'); ?>">
       <!-- <span class="tile-icon"></span>-->
        <span class="tile-title">Users</span>
      </a>
       <a class="tile" href="<?php echo url_for('/admin/courses/index.php'); ?>">
        <!--<span class="tile-icon"></span>-->
        <span class="tile-title">Courses</span>
      </a>
      <a class="tile" href="<?php echo url_for('/admin/publishers/index.php'); ?>">
       <!-- <span class="tile-icon"></span>-->
        <span class="tile-title">Publishers</span>
      </a>
     <a class="tile" href="<?php echo url_for('/admin/contributors/index.php'); ?>">
       <!-- <span class="tile-icon"></span>-->
        <span class="tile-title">Contributors</span>
      </a>
      <a class="tile" href="<?php echo url_for('/admin/circulation/index.php'); ?>">
       <!-- <span class="tile-icon"></span>-->
        <span class="tile-title">Circulation</span>
      </a>
       <a class="tile" href="<?php echo url_for('/admin/auth/index.php'); ?>">
       <!-- <span class="tile-icon"></span>-->
        <span class="tile-title">User Logins</span>
       </a>
       <a class="tile" href="">
       <!-- <span class="tile-icon"></span>-->
        <span class="tile-title"></span>
      </a>
       <a class="tile" href="">
       <!-- <span class="tile-icon"></span>-->
        <span class="tile-title"></span>
      </a>
        <a class="tile" href="">
       <!-- <span class="tile-icon"></span>-->
        <span class="tile-title"></span>
      </a>
        <!--<a class="tile" href="<?php echo url_for('/admin/itemcontributors/index.php'); ?>">
       <span class="tile-icon"></span>
        <span class="tile-title">Item Contributors</span>
      </a>-->
      </a>
    </div>
  </div>
</div>
</main>
<?php include(SHARED_PATH . '/admin_footer.php'); ?>