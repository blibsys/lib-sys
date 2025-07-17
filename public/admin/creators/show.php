<?php require_once('../../../private/initialise.php'); ?>

<?php
$id = $_GET['id'] ?? '1';
?>

<?php $page_title = 'Show Creator'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>

<div id="content">

	<a class="back-link" href="<?php echo url_for('/admin/creators/index.php');
	?>">&laquo; Back to List</a>
	
	<div class="creator show">
	
	  Creator_ID: <?php echo h($id); ?>
	  
	</div>

</div>

<?php include(SHARED_PATH . '/admin_footer.php'); ?>


