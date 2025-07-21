<?php
require_once('../../../private/initialise.php'); 

if(!isset($_GET['id'])) {
	redirect_to(url_for('/admin/items/index.php'));
}

$id = $_GET['id'];

if(is_post_request()) {
		
	$item = [];
	$item['id'] = $id;
	$item['title']= $_POST['title'] ?? '';
	$item['item_edition']= $_POST['item_edition'] ?? '';
	$item['isbn']= $_POST['isbn'] ?? '';
	$item['item_type']= $_POST['item_type'] ?? '';
	$item['publication_year']= $_POST['publication_year'] ?? '';
	$item['item_copy']= $_POST['item_copy'] ?? '';
	$item['publisher_id']= $_POST['publisher_id'] ?? '';
	$item['category']= $_POST['category'] ?? '';
	$item['item_status']= $_POST['item_status'] ?? '';
	
	$result = update_item($item);
	redirect_to(url_for('admin/items/show.php?id=' . $id));
	
  } else {
	
	$item = find_item_by_id($id);

  }   
  
?>

	<?php $page_title = 'Edit Item'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>

<div id="content">

  <a class = "back-link" href="<?php echo url_for('/admin/items/index.php') ?>">&laquo; Back to List</a>
  
  <div class="item edit">
    <h1>Edit Item</h1>

    <form action="<?php echo url_for('/admin/items/edit.php?id=' . h(u($id))); ?>" method="post">
      <dl>
        <dt>item id</dt>
        <!--item id read only:-->
        <dd><?php echo h($item['item_id']); ?></dd>
      </dl>
      <dl>
        <dt>title</dt>
        <dd><input type="text" name="title" value="<?php echo h($item['title']); ?>" /></dd>
      </dl>
      <dl>
        <dt>Item edition</dt>
        <dd><input type="text" name="item_edition" value="<?php echo h($item['item_edition']); ?>" /></dd>
      </dl>
      <dl>
        <dt>ISBN</dt>
        <dd><input type="text" name="isbn" value="<?php echo h($item['isbn']); ?>" /></dd>
      </dl>
       <dl>
        <dt>Item type</dt>
        <dd><input type="text" name="item_type" value="<?php echo h($item['item_type']); ?>" /></dd>
      </dl>
      <dl>
        <dt>Publication year</dt>
        <dd><input type="text" name="publication_year" value="<?php echo h($item['publication_year']); ?>" /></dd>
      </dl>
      <dl>
        <dt>copy</dt>
        <dd><input type="text" name="item_copy" value="<?php echo h($item['item_copy']); ?>" /></dd>
      </dl>
       <dl>
        <dt>Publisher id</dt>
        <dd><input type="text" name="publisher_id" value="<?php echo h($item['publisher_id']); ?>" /></dd>
      </dl>
       <dl>
        <dt>Category</dt>
        <dd><input type="text" name="category" value="<?php echo h($item['category']); ?>" /></dd>
      </dl>
       <dl>
        <dt>Status</dt>
        <dd><input type="text" name="item_status" value="<?php echo h($item['item_status']); ?>" /></dd>
      </dl>
      <div id="operations">
        <input type="submit" value="Edit Item" />
      </div>
    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/admin_footer.php'); ?>
