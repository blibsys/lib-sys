<?php require_once('../../../private/init.php');

if(!isset($_GET['id'])) {
  redirect_to(url_for('/admin/auth/index.php'));
}
$id = $_GET['id'];
	$auth = find_auth_by_id($id);

if(is_post_request()) {
	
	$result = delete_auth($id);
  if($result === true) {
    $_SESSION['message'] = 'User login credentials deleted successfully.';
	redirect_to(url_for('/admin/auth/index.php'));
  } else {
    $errors = $result;
  //var_dump($errors);
  }
	} else {

	}

?>

<?php $page_title = 'Delete User Credentials'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>

<main aria-label="main content">
<div id="content">

  <a class="back-link" href="<?php echo url_for('/admin/auth/index.php'); ?>">← Back to List</a>

  <div class="auth delete">
    <h1>Delete User Login Credentials</h1>

  <?php echo display_errors($errors); ?>

    <p class ="delete-message">Are you sure you want to delete log in credentials for user?</p>
    <p class="item"><?php echo h('Authentication ID: ' . $auth['auth_id'] . ' - User: ' . $auth['user_id'] . ' - ' . $auth['first_name'] . ' ' . $auth['last_name']); ?></p>

    <form action="<?php echo url_for('/admin/auth/delete.php?id=' . h(u($auth['auth_id']))); ?>" method="post">
      <div id="operations">
        <input type="submit" name="commit" value="Delete User Login Credentials" />
      </div>
    </form>
  </div>

</div>
</main>
<?php include(SHARED_PATH . '/admin_footer.php'); ?>
