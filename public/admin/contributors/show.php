<?php require_once('../../../private/init.php');
if(isset($_SESSION['role']) && strtolower($_SESSION['role']) !== 'admin') {
  //if user not admin
  echo "You do not have permission to access this page.";
  exit; 
}


$id = $_GET['id'] ?? '1';

$contributor = find_contributor_by_id($id);

?>

<?php $page_title = 'Show contributor'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>
<main aria-label="main content">
<div id="content">

	<a class="back-link" href="<?php echo url_for('/admin/contributors/index.php'); ?>">← Back to List</a>
	
	<div class="contributor show">
	
	<!--contributor_ID: <?php echo h($id); ?>-->
	 <h2>Contributor Detail</h2>
	<div class="card">
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
	<div class="form-row">
	<dl>
	  <dt>Role</dt>
	  <dd><?php echo h($contributor['role_name']); ?></dd>
	</dl>
	</div>	  
   </div>
  </div>
</div>

</div>
</main>
<?php include(SHARED_PATH . '/footer.php'); ?>


	