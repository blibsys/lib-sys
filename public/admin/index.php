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
	   <li><a href="<?php echo url_for('/admin/creators/index.php'); 
      ?>">Creators</a></li>
	  <li><a href="<?php echo url_for ('/admin/publishers/index.php'); 
	  ?>">Publishers</a></li>
	   <li><a href="<?php echo url_for('/admin/courses/index.php'); 
      ?>">Courses</a></li>
      <li><a href="<?php echo url_for ('/admin/itemcreators/index.php'); 
	  ?>">Item Creators</a></li>
	  <li><a href="<?php echo url_for ('/admin/circulation/index.php'); 
	  ?>">Circulation</a></li>
	  
    </ul>
   </div>
  
</div>

<?php include(SHARED_PATH . '/admin_footer.php'); ?>
