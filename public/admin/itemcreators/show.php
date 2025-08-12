<?php require_once('../../../private/init.php'); 

$id = $_GET['id'] ?? '1';

$icreator = find_icreator_by_id($id);

?>

<?php $page_title = 'Show Item Creator'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>

<main aria-label="main content">
<div id="content">

<a class="back-link" href="<?php echo url_for('/admin/itemcreators/index.php');?>">← Back to List</a>
	
	<div class="item creator show">

<div class="attributes">
  <div class="form-row">
	<dl>
	  <dt>Item</dt>
	  <dd><?php echo h($icreator['item_id'] . ' - ' . $icreator['title']); ?></dd>
    </dl>
  </div>
  <div class="form-row">
    <dl>
      <dt>Creator</dt>
      <dd><?php echo h($icreator['creator_id'] . ' - ' . $icreator['creator_name']); ?></dd>
    </dl>
    </div>
</div>

	</div>

</div>
</main>
<?php include(SHARED_PATH . '/admin_footer.php'); ?>



	   