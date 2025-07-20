<?php require_once('../../../private/initialise.php'); ?>

<?php

$id = $_GET['id'] ?? '1';

$item = find_item_by_id($id);
if (!$item) {
  echo "<p>Item not found.</p>";
  exit;
}
?>

<?php $page_title = 'Show Item'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>

<div id="content">

	<a class="back-link" href="<?php echo url_for('/admin/items/index.php');
	?>">&laquo; Back to List</a>
	
	<div class="item show">
	
	  <!--<h1>Item id: <?php echo h($item['item_id']); ?></h1>-->
	  
	  <div class="attributes">
	     <dl>
	      <dt>Item id</dt>
	      <dd><?php echo h($item['item_id']); ?></dd>
	    </dl>
	    <dl>
	      <dt>Title</dt>
	      <dd><?php echo h($item['title']); ?></dd>
	    </dl>
	    <dl>
	      <dt>Creators</dt>
	      <dd><?php echo h($item['creators']); ?></dd>
	    </dl>
	    <dl>
	       <dt>Status</dt>
	      <dd><?php echo h($item['item_status']); ?></dd>
	    </dl>
	    <dl>
	      <dt>Type</dt>
	      <dd><?php echo h($item['item_type']); ?></dd>
	    </dl>
	     <dl>
	      <dt>ISBN</dt>
	      <dd><?php echo h($item['isbn']); ?></dd>
	    </dl>
	    <dl>
	      <dt>Edition</dt>
	      <dd><?php echo h($item['item_edition']); ?></dd>
	    </dl>
	    <dl>
	      <dt>Published Year</dt>
	      <dd><?php echo h($item['publication_year']); ?></dd>
	    </dl>
	    <dl>
	      <dt>Publisher id</dt>
	      <dd><?php echo h($item['publisher_id']); ?></dd>
	    </dl>
	    <dl>
	      <dt>Category</dt>
	      <dd><?php echo h($item['category']); ?></dd>
	    </dl>
	    <dl>
	      <dt>Copy</dt>
	      <dd><?php echo h($item['item_copy']); ?></dd>
	    </dl>
        <dl>
	      <dt>Created</dt>
	      <dd><?php echo h($item['created_at'] ?? ''); ?></dd>
	    </dl>
	    <dl>
	      <dt>Updated</dt>
	      <dd><?php echo h($item['updated_at'] ?? ''); ?><dd>
	    </dl> 
	   </div>
	  
	</div>

</div>

<?php include(SHARED_PATH . '/admin_footer.php'); ?>


