<?php require_once('../../../private/initialise.php'); ?>

<?php
$id = $_GET['id'] ?? '1';
?>

<?php $page_title = 'Show ItemCreator'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>

<div id="content">

	<a class="back-link" href="<?php echo url_for('/admin/itemcreators/index.php');
	?>">&laquo; Back to List</a>
	
	<div class="item creator show">
	
	  Item_ID: <?php echo h($id); ?>
	  
	</div>

</div>

<?php include(SHARED_PATH . '/admin_footer.php'); ?>


