
<?php require_once('../../../private/init.php');

if(isset($_SESSION['role']) && strtolower($_SESSION['role']) !== 'admin') {
  //if user not admin
  echo "You do not have permission to access this page.";
  exit; 
}
   
$auth_set = find_all_auth(); 

?>

<?php $page_title = 'user authentication'; ?>

<?php include(SHARED_PATH . '/header.php'); ?>
<main aria-label="main content">
<div id="content">
  <div class="auths listing">
    <h1>User Login</h1>

    <div class="back-link-wrapper">
      <a class="back-link" href="<?php echo url_for('/admin/index.php'); ?>">← Back to List</a>
    </div>

    <div class="actions">
      <a class="action1" href="<?php echo url_for('/admin/auth/new.php'); ?>">＋ Add New Login Details</a>
    </div>
      
    <table class = "list">
      <tr>  
        <th>Authentication ID</th>
        <th>User ID</th>
        <th>Role</th>
        <th>Username</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Created At</th>
        <th>Updated At</th>
  	    <th>&nbsp;</th>
  	    <th>&nbsp;</th>
        <th>&nbsp;</th>
  	  </tr>

      <?php while($auth = mysqli_fetch_assoc($auth_set)) { ?>
        <tr>
          <td><?php echo h($auth['auth_id']); ?></td>
          <td><?php echo h($auth['user_id']); ?></td>
          <td><?php echo h($auth['role']); ?></td>
          <td><?php echo h($auth['username']); ?></td>
          <td><?php echo h($auth['first_name']); ?></td>
          <td><?php echo h($auth['last_name']); ?></td>
          <td><?php echo h($auth['email']); ?></td>
          <td><?php echo h($auth['auth_created_at']); ?></td>
          <td><?php echo h($auth['auth_updated_at']); ?></td>
          <td><a class="action2" href="<?php echo url_for('/admin/auth/show.php?Page=1&id=' . h(u($auth['auth_id'])));?>">View</a></td>
          <td><a class="action2" href="<?php echo url_for('/admin/auth/edit.php?id=' . h(u($auth['auth_id']))); ?>""">Edit</a></td>
          <td><a class="action2" href="<?php echo url_for('/admin/auth/delete.php?id=' . h(u($auth['auth_id'])));?>">Delete</a></td>
    	  </tr>
      <?php } ?>
  	</table>

<!-- free up storage of $auth-set query above -->
	<?php
	mysqli_free_result($auth_set);
	?>

  </div>

</div>
</main>
<?php include(SHARED_PATH . '/footer.php'); ?>
