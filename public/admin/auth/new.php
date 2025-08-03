 <?php

require_once('../../../private/init.php'); 

if(is_post_request()) {

  // Handle form values sent by new.php

  $auth = [];
  $auth['user_id'] = $_POST['user_id'] ?? '';
  $auth['username'] = $_POST['username'] ?? '';
  $auth['hashed_password'] = $_POST['hashed_password'] ?? '';
  $auth['created_at'] = $_POST['created_at'] ?? '';
  $auth['updated_at'] = $_POST['updated_at'] ?? '';

  $result = insert_auth($auth);
  if($result === true) {

    $_SESSION['message'] = 'User credentials added successfully.';
  	$new_id = mysqli_insert_id($db);
  	redirect_to(url_for('/admin/auth/show.php?id=' . $new_id));
  } else {
  	$errors = $result;
}
   } else {
	 // display blank form
}
	$auth_set = find_all_auth();
	$auth_count = mysqli_num_rows($auth_set) + 1;
	mysqli_free_result($auth_set);

	//$auth = [];
	?>

<?php $page_title = 'add user authentication'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>
<main aria-label="main content">
<div id="content">

  <a class="back-link" href="<?php echo url_for('/admin/auth/index.php'); ?>">← Back to List</a>

  <div class="auth new">
    <h2>Add User Login Credentials</h2>

	<?php echo display_errors($errors);?>
	
 <form class="admin-form1" action="<?php echo url_for('/admin/auth/new.php'); ?>" method="post">

<div class="form-row">
      <dl>
        <dt>User ID</dt>
        <dd><input type="text" name="user_id" value="<?php echo h($auth['user_id'] ?? ''); ?>" /></dd>
      </dl>
</div>
<div class="form-row">
      <dl>
        <dt>Username</dt>
        <dd><input type="text" name="username" value="<?php echo h($auth['username'] ?? ''); ?>" /></dd>
      </dl>
</div>
<div class="form-row">
      <dl>
        <dt>Hashed password</dt>
        <dd><input type="text" name="hashed password" value="<?php echo h($auth['hashed_password'] ?? ''); ?>" /></dd>
      </dl>
</div>
      <div id="operations">
        <input type="submit" value="Add User Login Credentials" />
      </div>
    </form>

  </div>

</div>
</main>
<?php include(SHARED_PATH . '/admin_footer.php'); ?> 
