

<?php 
require_once('../../../private/init.php'); 

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
    $_SESSION['message'] = 'Course updated successfully.';
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
	<?php include(SHARED_PATH . '/header.php'); ?>

<!-- html with embedded php to display a web form for editing course -->
<!-- ("server side script for managing content") -->
<main aria-label="main content">
<div id="content">
 
  <a class = "back-link" href="<?php echo url_for('/admin/courses/index.php') ?>">← Back to List</a>
  
  <div class="course edit">
    <h2>Edit Course</h2>

   <?php echo display_errors($errors); ?>

    <form class "admin-form1" action="<?php echo url_for('/admin/courses/edit.php?id=' . h(u($id))); ?>" method="post">
    <div class="form-row">  
    <dl>
        <dt>Course ID</dt>
        <dd><?php echo h($course['course_id']) ?></dd>
      </dl>
    </div>
    <div class="form-row">
      <dl>
        <dt>Course name</dt>
        <dd><input type="text" name="course_name" value="<?php echo h($course['course_name']); ?>" /></dd>
      </dl>
    </div>
 	   <div id="operations">
        <input type="submit" value="Edit Course" />
      </div>
    </form>

  </div>

</div>
</main>
<?php include(SHARED_PATH . '/footer.php'); ?>
























