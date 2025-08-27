<?php require_once('../../../private/init.php');

if(!isset($_GET['id'])) {
  redirect_to(url_for('/admin/contributors/index.php'));
}
$id = $_GET['id'];

if(is_post_request()) {
	
	$result = delete_contributor($id);
  $_SESSION['message'] = 'contributor deleted successfully.';
	redirect_to(url_for('/admin/contributors/index.php'));
	
	} else {
	$contributor = find_contributor_by_id($id);
	}

?>

<?php $page_title = 'Delete contributor'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<main aria-label="main content">
<div id="content">

  <a class="back-link" href="<?php echo url_for('/admin/contributors/index.php'); ?>">← Back to List</a>

  <div class="contributor delete">
    <h1>Delete Contributor</h1>
    <p class ="delete-message">Are you sure you want to delete this contributor?</p>
    <p class="item"><?php echo h($contributor['contributor_id'] . ' - ' . $contributor['contributor_name']); ?></p>

    <form action="<?php echo url_for('/admin/contributors/delete.php?id=' . h(u($contributor['contributor_id']))); ?>" method="post">
      <div id="operations">
        <input type="submit" name="commit" value="Delete Contributor" />
      </div>
    </form>
  </div>

</div>
</main>
<?php include(SHARED_PATH . '/footer.php'); ?>
