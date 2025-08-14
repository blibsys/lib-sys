<?php require_once('../../private/init.php'); 

$id = $_GET['id'] ?? '1';
$main_search = $_GET['q'] ?? '';


$item = find_item_by_id($id);
/*if (!$item) {
  echo "<p>Item not found.</p>";
  exit;
}
*/
?>

	<?php $page_title = 'Show Item'; ?>
	<?php include(SHARED_PATH . '/user_header.php'); ?>
<main aria-label="main content">
<div id="content">

	<!--<a class="back-link" href="<?php echo url_for('/user/index.php?q=' . h(u($main_search))); ?>">← Back</a>-->
	  
	<?php $backurl = $_GET['backurl'] ?? url_for('/user/index.php'); ?>
		<a class="back-to-results" href="<?php echo h($backurl); ?>">← Back to results</a>

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
	      <dt>contributors</dt>
	      <dd><?php echo h($item['contributors']); ?></dd>
	    </dl>
		<dl>
	      <dt>Type</dt>
	      <dd><?php echo h($item['item_type']); ?></dd>
	    </dl>
		<dl>
	       <dt>Status</dt>
	      <dd><?php echo h($item['item_status']); ?></dd>
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
	      <dt>Year published</dt>
	      <dd><?php echo h($item['publication_year']); ?></dd>
	    </dl>
	    <dl>
	      <dt>Publisher</dt>
	      <dd><?php echo h($item['publisher_id']); ?></dd>
	    </dl>
	    <dl>
	      <dt>Category</dt>
	      <dd><?php echo h($item['category']); ?></dd>
	    </dl>
	    <dl>
	      <dt>Number of copies</dt>
	      <dd><?php echo h($item['item_copy']); ?></dd>
	    </dl> 
	   </div>

	   <div class="actions">
		<?php if (is_logged_in()): ?>
			<?php if (h($item['item_status']) === 'Available'): ?>
				<a class="action1" href="<?php echo url_for('/user/borrow_item.php?id=' . h($item['item_id']) . '&backurl=' . urlencode($_SERVER['REQUEST_URI'])); ?>">Borrow Item</a>
			<?php else: ?>
				<a class="action1 disabled" href="#">Notify when available</a>
			<?php endif; ?>
		<?php else: ?>
			<a class="action1" href="<?php echo url_for('/login.php'); ?>">Login to Borrow</a>
		<?php endif; ?>
       </div>

	</div>
  </div>
</main>




