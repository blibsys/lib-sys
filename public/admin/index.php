<?php require_once('../../private/initialise.php'); ?>
 
<?php $page_title = 'Admin Menu'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>

<div id="content">
  <div id="main-menu">
    <h2>Modules</h2>
    <ul>
      <li><a href="<?php echo url_for('/admin/items/index.php'); 
      ?>">Items</a></li>
	  <li><a href="<?php echo url_for ('/admin/users/index.php'); 
	  ?>">Users</a></li>
    </ul>
   </div>
  
</div>

<?php include(SHARED_PATH . '/admin_footer.php'); ?>
