<?php 
require_once('../../../private/initialise.php'); 

if(!isset($_GET['id'])) {
	redirect_to(url_for('/admin/courses/index.php'));
}

$id = $_GET['id'];

if(is_post_request()) {
		
	$course = [];
	$course['id'] = $id;
	$course['course_name']= $_POST['course_name'] ?? '';
	
	$sql = "UPDATE courses SET ";
	$sql .= "course_name='" . $course['course_name'] . "' ";
	$sql .= "WHERE course_id='" . $id . "'";
	$sql .= "LIMIT 1";

	$result = mysqli_query($db, $sql);
	// for UPDATE statements, $result is true/false
	if($result) {
	  redirect_to(url_for('/admin/courses/show.php?id=' . $id));
	} else {
	  // update failed
	  echo mysqli_error($db);
	  db_disconnect($db);
	  exit;
	  
	}

} else {
	
	$course = find_course_by_id($id);

}   
?>
	
	<?php $page_title = 'Edit course'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>

<!-- html with embedded php to display a web form for editing course -->
<!-- ("server side script for managing content") -->

<div id="content">

  <a class = "back-link" href="<?php echo url_for('/admin/courses/index.php') ?>">&laquo; Back to List</a>
  
  <div class="course edit">
    <h1>Edit Course</h1>

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

<?php include(SHARED_PATH . '/admin_footer.php'); ?>






















