<?php require_once('../../../private/init.php'); 

$id = $_GET['id'] ?? '1';

$icontributor = find_icontributor_by_id($id);

?>

<?php $page_title = 'Show Item contributor'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>

<main aria-label="main content">
<div id="content">

<a class="back-link" href="<?php echo url_for('/admin/itemcontributors/index.php');?>">← Back to List</a>
	
	<div class="item contributor show">

<div class="attributes">
  <div class="form-row">
	<dl>
	  <dt>Item</dt>
	  <dd><?php echo h($icontributor['item_id'] . ' - ' . $icontributor['title']); ?></dd>
    </dl>
  </div>
  <div class="form-row">
    <dl>
      <dt>Contributor</dt>
      <dd><?php echo h($icontributor['contributor_id'] . ' - ' . $icontributor['contributor_name']); ?></dd>
    </dl>
    </div>
</div>

	</div>

</div>
</main>
<?php include(SHARED_PATH . '/admin_footer.php'); ?>



	   