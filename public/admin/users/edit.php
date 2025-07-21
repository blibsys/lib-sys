<?php 
require_once('../../../private/initialise.php'); 

if(!isset($_GET['id'])) {
	redirect_to(url_for('/admin/users/index.php'));
}

$id = $_GET['id'];

if(is_post_request()) {

// Handle form values sent by new.php
		
	$user = [];
	$user['id'] = $id;
	$user['first_name']= $_POST['first_name'] ?? '';
	$user['last_name']= $_POST['last_name'] ?? '';
	$user['user_start_date']= $_POST['user_start_date'] ?? '';
	$user['user_end_date']= $_POST['user_end_date'] ?? '';
	$user['user_type']= $_POST['user_type'] ?? '';
	$user['email']= $_POST['email'] ?? '';

		$result = update_user($user);
	redirect_to(url_for('/admin/users/show.php?id=' . $id));


} else {
	
	$user = find_user_by_id($id);

}   
?>

<?php $page_title = 'Edit User'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>

<!-- html with embedded php to display a web form for editing user -->
<!-- ("server side script for managing content") -->

<div id="content">

  <a class = "back-link" href="<?php echo url_for('/admin/users/index.php') ?>">&laquo; Back to List</a>
  
  <div class="user edit">
    <h1>Edit User</h1>

    <form action="<?php echo url_for('/admin/users/edit.php?id=' . h(u($id))); ?>" method="post">
      <dl>
        <dt>User id</dt>
        <!--user id read only:-->
        <dd><?php echo h($user['user_id']); ?></dd>
      </dl>
      <dl>
        <dt>First name</dt>
        <dd><input type="text" name="first_name" value="<?php echo h($user['first_name']); ?>" /></dd>
      </dl>
      <dl>
        <dt>Last name</dt>
        <dd><input type="text" name="last_name" value="<?php echo h($user['last_name']); ?>" /></dd>
      </dl>
      <dl>
        <dt>Start date</dt>
        <dd><input type="text" name="user_start_date" value="<?php echo h($user['user_start_date']); ?>" /></dd>
      </dl>
       <dl>
        <dt>End date</dt>
        <dd><input type="text" name="user_end_date" value="<?php echo h($user['user_end_date']); ?>" /></dd>
      </dl>
      <dl>
        <dt>User type</dt>
        <dd><input type="text" name="user_type" value="<?php echo h($user['user_type']); ?>" /></dd>
      </dl>
      <dl>
        <dt>Email</dt>
        <dd><input type="text" name="email" value="<?php echo h($user['email']); ?>" /></dd>
      </dl>
      <div id="operations">
        <input type="submit" value="Edit user" />
      </div>
    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/admin_footer.php'); ?>
