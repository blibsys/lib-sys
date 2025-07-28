<?php require_once('../../../private/initialise.php'); ?>

<?php

$id = $_GET['id'] ?? '1';

$course = find_course_by_id($id);

?>

<?php $page_title = 'Show Course'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>

<main aria-label="main content">
<div id="content">

	<a class="back-link" href="<?php echo url_for('/admin/courses/index.php'); ?>">&laquo; Back to List</a>
	
	<div class="course show">
	
	<div class="attributes">
	<dl>
	  <dt>Course id</dt>
	  <dd><?php echo h($course['course_id']); ?></dd>
	</dl>
	<dl>
	  <dt>Course name</dt>
	  <dd><?php echo h($course['course_name']); ?></dd>
	</dl>
	</div>
	 
	</div>

</div>
</main>
<?php include(SHARED_PATH . '/admin_footer.php'); ?>


