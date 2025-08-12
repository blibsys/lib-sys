<?php require_once('../../../private/init.php'); ?>

<?php

$id = $_GET['id'] ?? '1';

$contributor = find_contributor_by_id($id);

?>

<?php $page_title = 'Show contributor'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>
<main aria-label="main content">
<div id="content">

	<a class="back-link" href="<?php echo url_for('/admin/contributors/index.php'); ?>">← Back to List</a>
	
	<div class="contributor show">
	
	<!--contributor_ID: <?php echo h($id); ?>-->
	
	<div class="attributes">
		<div class="form-row">
	<dl>
	  <dt>Contributor ID</dt>
	  <dd><?php echo h($contributor['contributor_id']); ?></dd>
	</dl>
	</div>
	<div class="form-row">
	<dl>
	  <dt>Contributor name</dt>
	  <dd><?php echo h($contributor['contributor_name']); ?></dd>
	</dl>
	</div>	  
   </div>
  </div>

</div>
</main>
<?php include(SHARED_PATH . '/admin_footer.php'); ?>


	