<?php require_once('../../../private/init.php'); ?>

<?php

$id = $_GET['id'] ?? '1';

$creator = find_creator_by_id($id);

?>

<?php $page_title = 'Show Creator'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>
<main aria-label="main content">
<div id="content">

	<a class="back-link" href="<?php echo url_for('/admin/creators/index.php'); ?>">← Back to List</a>
	
	<div class="creator show">
	
	<!--Creator_ID: <?php echo h($id); ?>-->
	
	<div class="attributes">
		<div class="form-row">
	<dl>
	  <dt>Creator ID</dt>
	  <dd><?php echo h($creator['creator_id']); ?></dd>
	</dl>
	</div>
	<div class="form-row">
	<dl>
	  <dt>Creator name</dt>
	  <dd><?php echo h($creator['creator_name']); ?></dd>
	</dl>
	</div>	  
   </div>
  </div>

</div>
</main>
<?php include(SHARED_PATH . '/admin_footer.php'); ?>


	