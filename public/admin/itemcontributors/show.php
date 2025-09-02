<?php require_once('../../../private/init.php'); 
if(isset($_SESSION['role']) && strtolower($_SESSION['role']) !== 'admin') {
  //if user not admin
  echo "You do not have permission to access this page.";
  exit; 
}
$id = $_GET['id'] ?? '1';

$icontributor = find_icontributor_by_id($id);

?>

<?php $page_title = 'Show Item contributor'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<main aria-label="main content">
<div id="content">

<a class="back-link" href="<?php echo url_for('/admin/itemcontributors/index.php');?>">← Back to List</a>
	
	<div class="item contributor show">
 <h2>Item Contributor Detail</h2>
  <div class="card">
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
</div>
</main>
<?php include(SHARED_PATH . '/footer.php'); ?>



	   