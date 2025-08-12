<?php require_once('../../../private/init.php'); 

$id = $_GET['id'] ?? '1';

$item = find_item_by_id($id);
/*if (!$item) {
  echo "<p>Item not found.</p>";
  exit;
}
*/
?>

	<?php $page_title = 'Show Item'; ?>
	<?php include(SHARED_PATH . '/admin_header.php'); ?>
<main aria-label="main content">
<div id="content">

<a class="back-link" href="<?php echo url_for('admin/items/index.php'); ?>">← Back to List</a>
	
	<div class="item show">
	
	  <!--<h1>Item id: <?php echo h($item['item_id']); ?></h1>-->
	  
	  <div class="attributes">
		<div class="form-row">
	     <dl>
	      <dt>Item ID</dt>
	      <dd><?php echo h($item['item_id']); ?></dd>
	    </dl>
		</div>
		<div class="form-row">
	    <dl>
	      <dt>Title</dt>
	      <dd><?php echo h($item['title']); ?></dd>
	    </dl>
		</div>
		<div class="form-row">
	    <dl>
	      <dt>Contributors</dt>
	      <dd><?php echo h($item['contributors']); ?></dd>
	    </dl>
		</div>
		<div class="form-row">
	      <dl>
	      <dt>Type</dt>
	      <dd><?php echo h($item['item_type']); ?></dd>
	    </dl>
		</div>
		<div class="form-row">
			<dl>
	       <dt>Status</dt>
	      <dd><?php echo h($item['item_status']); ?></dd>
	    </dl>
		</div>
		<div class="form-row">
	    <dl>
	      <dt>ISBN</dt>
	      <dd><?php echo h($item['isbn']); ?></dd>
	    </dl>
		</div>
		<div class="form-row">
	    <dl>
	      <dt>Edition</dt>
	      <dd><?php echo h($item['item_edition']); ?></dd>
	    </dl>
		</div>
		<div class="form-row">
	    <dl>
	      <dt>Year published</dt>
	      <dd><?php echo h($item['publication_year']); ?></dd>
	    </dl>
		</div>
		<div class="form-row">
	    <dl>
	      <dt>Publisher</dt>
	      <dd><?php echo h($item['publisher_id']); ?></dd>
	    </dl>
		</div>
		<div class="form-row">
	    <dl>
	      <dt>Category</dt>
	      <dd><?php echo h($item['category']); ?></dd>
	    </dl>
		</div>
		<div class="form-row">
	    <dl>
	      <dt>Number of copies</dt>
	      <dd><?php echo h($item['item_copy']); ?></dd>
	    </dl>
		</div>
		<div class="form-row">
        <dl>
	      <dt>Created</dt>
	      <dd><?php echo h($item['created_at'] ?? ''); ?></dd>
	    </dl>
		</div>
		<div class="form-row">
	    <dl>
	      <dt>Updated</dt>
	      <dd><?php echo h($item['updated_at'] ?? ''); ?></dd>
	    </dl> 
		</div>
	   </div>
	  
	</div>
  </div>
</main>

<?php include(SHARED_PATH . '/admin_footer.php'); ?>


