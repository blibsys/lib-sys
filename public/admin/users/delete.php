<?php require_once('../../../private/init.php'); ?>

<?php if(!isset($_GET['id'])) {
  redirect_to(url_for('/admin/users/index.php'));
}
$id = $_GET['id'];

if(is_post_request()) {
	
	$result = delete_user($id);
    $_SESSION['message'] = 'User deleted successfully.';
	redirect_to(url_for('/admin/users/index.php'));
	
	} else {
	$user = find_user_by_id($id);
	}

?>

<?php $page_title = 'Delete User'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>
<main aria-label="main content">
<div id="content">

  <a class="back-link" href="<?php echo url_for('/admin/users/index.php'); ?>">← Back to List</a>

  <div class="user delete">
    <h1>Delete User</h1>
    <p>!! Are you sure you want to delete this user? !!</p>
    <p class="item"><?php echo h($user['user_id'] . ' - ' . $user['first_name'] . ' ' . $user['last_name']); ?></p>

    <form action="<?php echo url_for('/admin/users/delete.php?id=' . h(u($user['user_id']))); ?>" method="post">
      <div id="operations">
        <input type="submit" name="commit" value="Delete User" />
      </div>
    </form>
  </div>

</div>
</main>
<?php include(SHARED_PATH . '/admin_footer.php'); ?>
