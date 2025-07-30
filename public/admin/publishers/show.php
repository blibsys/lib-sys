<?php require_once('../../../private/initialise.php'); ?>

<?php

$id = $_GET['id'] ?? '1';
// Check if the id is set and valid
$pub = find_pub_by_id($id);

?>

<?php $page_title = 'Show publisher'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>
<main aria-label="main content">
<div id="content">

	<a class="back-link" href="<?php echo url_for('/admin/publishers/index.php');?>">← Back to List</a>
	
	<div class="publisher show">
	
	<div class="attributes">
	<dl>
	  <dt>Publisher id</dt>
	  <dd><?php echo h($pub['publisher_id']); ?></dd>
	</dl>
	<dl>
	  <dt>Publisher name</dt>
	  <dd><?php echo h($pub['publisher_name']); ?></dd>
	</dl>
	</div>
	  
	</div>

</div>
</main>
<?php include(SHARED_PATH . '/admin_footer.php'); ?>


