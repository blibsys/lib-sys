<?php require_once('../../../private/init.php'); ?>

<?php if(!isset($_GET['id'])) {
  redirect_to(url_for('/admin/creators/index.php'));
}
$id = $_GET['id'];

if(is_post_request()) {
	
	$result = delete_creator($id);
  $_SESSION['message'] = 'Creator deleted successfully.';
	redirect_to(url_for('/admin/creators/index.php'));
	
	} else {
	$creator = find_creator_by_id($id);
	}

?>

<?php $page_title = 'Delete Creator'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>

<main aria-label="main content">
<div id="content">

  <a class="back-link" href="<?php echo url_for('/admin/creators/index.php'); ?>">← Back to List</a>

  <div class="creator delete">
    <h1>Delete Creator</h1>
    <p>!! Are you sure you want to delete this creator? !!</p>
    <p class="item"><?php echo h($creator['creator_id'] . ' - ' . $creator['creator_name']); ?></p>

    <form action="<?php echo url_for('/admin/creators/delete.php?id=' . h(u($creator['creator_id']))); ?>" method="post">
      <div id="operations">
        <input type="submit" name="commit" value="Delete Creator" />
      </div>
    </form>
  </div>

</div>
</main>
<?php include(SHARED_PATH . '/admin_footer.php'); ?>
