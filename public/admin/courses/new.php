 <?php

require_once('../../../private/initialise.php'); 

if(is_post_request()) {

  // Handle form values sent by new.php

  $course = [];
  $course['course_id'] = $_POST['course_id'] ?? '';
  $course['course_name'] = $_POST['course_name'] ?? '';

  $result = insert_course($course);
  if($result === true) {
  	$new_id = mysqli_insert_id($db);
  	redirect_to(url_for('/admin/courses/show.php?id=' . $course['course_id']));
  } else {
  	$errors = $result;
}
   } else {
	 // display blank form
}
	$course_set = find_all_courses();
	$course_count = mysqli_num_rows($course_set) + 1;
	mysqli_free_result($course_set);

	//$course = [];
	?>

<?php $page_title = 'Add course'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/admin/courses/index.php'); ?>">&laquo; Back to List</a>

  <div class="course new">
    <h1>Add Course</h1>

	<?php echo display_errors($errors);?>
	
    <form action="<?php echo url_for('/admin/courses/new.php'); ?>" method="post">
      <dl>
        <dt>Course id</dt>
        <dd><input type="text" name="course_id" value="<?php echo h($course['course_id'] ?? ''); ?>" /></dd>
      </dl>
      <dl>
        <dt>Course name</dt>
        <dd><input type="text" name="course_name" value="<?php echo h($course['course_name'] ?? ''); ?>" /></dd>
      </dl>
    
      <div id="operations">
        <input type="submit" value="Add Course" />
      </div>
    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/admin_footer.php'); ?> 
