

<?php 
require_once('../../../private/initialise.php'); 

if(!isset($_GET['id'])) {
	redirect_to(url_for('/admin/courses/index.php'));
}

$id = $_GET['id'];

if(is_post_request()) {
		
	$course = [];
	$course['course_id'] = $id;
	$course['course_name']= $_POST['course_name'] ?? '';
	
	$result = update_course($course);
	if($result === true) {
		redirect_to(url_for('/admin/courses/show.php?id=' . $id));
	  } else {
	    $errors = $result;
		//var_dump($errors);
	  }
	
} else {
	
	$course = find_course_by_id($id);
	$course_set = find_all_courses();
} 
?>
	<?php $page_title = 'Edit Course'; ?>
	<?php include(SHARED_PATH . '/admin_header.php'); ?>

<!-- html with embedded php to display a web form for editing course -->
<!-- ("server side script for managing content") -->
<main aria-label="main content">
<div id="content">

  <a class = "back-link" href="<?php echo url_for('/admin/courses/index.php') ?>">&laquo; Back to List</a>
  
  <div class="course edit">
    <h1>Edit Course</h1>

   <?php echo display_errors($errors); ?>

    <form action="<?php echo url_for('/admin/courses/edit.php?id=' . h(u($id))); ?>" method="post">
      <dl>
        <dt>Course id</dt>
        <dd><?php echo h($course['course_id']) ?></dd>
      </dl>
      <dl>
        <dt>Course name</dt>
        <dd><input type="text" name="course_name" value="<?php echo h($course['course_name']); ?>" /></dd>
      </dl>
 	   <div id="operations">
        <input type="submit" value="Edit Course" />
      </div>
    </form>

  </div>

</div>
</main>
<?php include(SHARED_PATH . '/admin_footer.php'); ?>
























