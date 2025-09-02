<?php require_once('../../../private/init.php');
if(isset($_SESSION['role']) && strtolower($_SESSION['role']) !== 'admin') {
  //if user not admin
  echo "You do not have permission to access this page.";
  exit; 
}
$id = $_GET['id'] ?? '1';
// Check if the id is set and valid
$pub = find_pub_by_id($id);

?>

<?php $page_title = 'Show publisher'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>
<main aria-label="main content">
<div id="content">

	<a class="back-link" href="<?php echo url_for('/admin/publishers/index.php');?>">← Back to List</a>
	
	<div class="publisher show">
		 <h2>Publisher Detail</h2>
	<div class="card">
	<div class="attributes">
		<div class="form-row">
	<dl>
	  <dt>Publisher id</dt>
	  <dd><?php echo h($pub['publisher_id']); ?></dd>
	</dl>
	</div>
	<div class="form-row">
	<dl>
	  <dt>Publisher name</dt>
	  <dd><?php echo h($pub['publisher_name']); ?></dd>
	</dl>
	</div>
  </div>
 </div>
</div>
</div>
</main>
<?php include(SHARED_PATH . '/footer.php'); ?>


