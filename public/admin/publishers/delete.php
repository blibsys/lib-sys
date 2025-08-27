<?php require_once('../../../private/init.php'); 

if(!isset($_GET['id'])) {
  redirect_to(url_for('/admin/publishers/index.php'));
}
$id = $_GET['id'];

if(is_post_request()) {
	
	$result = delete_publisher($id);
  $_SESSION['message'] = 'Publisher deleted successfully.';
	redirect_to(url_for('/admin/publishers/index.php'));
	
	} else {
	$pub = find_pub_by_id($id);
	}

?>

<?php $page_title = 'Delete publisher'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>
<main aria-label="main content">
<div id="content">

  <a class="back-link" href="<?php echo url_for('/admin/publishers/index.php'); ?>">← Back to List</a>

  <div class="publisher delete">
    <h1>Delete Publisher</h1>
    <p class ="delete-message">Are you sure you want to delete this publisher?</p>
    <p class="item"><?php echo h($pub['publisher_id'] . ' - ' . $pub['publisher_name']); ?></p>

    <form action="<?php echo url_for('/admin/publishers/delete.php?id=' . h(u($pub['publisher_id']))); ?>" method="post">
      <div id="operations">
        <input type="submit" name="commit" value="Delete Publisher" />
      </div>
    </form>
  </div>

</div>
</main>
<?php include(SHARED_PATH . '/footer.php'); ?>
