<?php require_once('../../../private/init.php');
if(isset($_SESSION['role']) && strtolower($_SESSION['role']) !== 'admin') {
  //if user not admin
  echo "You do not have permission to access this page.";
  exit; 
}
if(!isset($_GET['id'])) {
  redirect_to(url_for('/admin/items/index.php'));
}
$id = $_GET['id'];

if(is_post_request()) {
	
	$result = delete_item($id);
  $_SESSION['message'] = 'Item was deleted successfully.';
	redirect_to(url_for('/admin/items/index.php'));
	
	} else {
	$item = find_item_by_id($id);
	}

?>

<?php $page_title = 'Delete Item'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<main aria-label="main content">
<div id="content">

  <a class="back-link" href="<?php echo url_for('admin/items/index.php'); ?>">← Back to List</a>

  <div class="item delete">
    <h1>Delete Item</h1>
    <p class ="delete-message">Are you sure you want to delete this item?</p>
    <p class="item"><?php echo h($item['item_id'] . ' - ' . $item['title']); ?></p>

    <form action="<?php echo url_for('/admin/items/delete.php?id=' . h(u($item['item_id']))); ?>" method="post">
      <div id="operations">
        <input type="submit" name="commit" value="Delete Item" />
      </div>
    </form>
  </div>

</div>
</main>
<?php include(SHARED_PATH . '/footer.php'); ?>
