<?php require_once('../../../private/init.php');
if(isset($_SESSION['role']) && strtolower($_SESSION['role']) !== 'admin') {
  //if user not admin
  echo "You do not have permission to access this page.";
  exit; 
}
$id = $_GET['id'] ?? '1';

$course = find_course_by_id($id);

?>

<?php $page_title = 'Show Course'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<main aria-label="main content">
<div id="content">

	<a class="back-link" href="<?php echo url_for('/admin/courses/index.php'); ?>">← Back to List</a>
	
	<div class="course show">
		 <h2>Course Detail</h2>
	<div class="card">
	<div class="attributes">
	<div class="form-row">
	<dl>
	  <dt>Course ID</dt>
	  <dd><?php echo h($course['course_id']); ?></dd>
	</dl>
	</div>
	<div class="form-row">
	<dl>
	  <dt>Course name</dt>
	  <dd><?php echo h($course['course_name']); ?></dd>
	</dl>
   </div>
  </div>
  </div>
 </div>
</div>
</main>
<?php include(SHARED_PATH . '/footer.php'); ?>


