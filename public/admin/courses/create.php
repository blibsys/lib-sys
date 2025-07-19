<?php

require_once('../../../private/initialise.php');

//$course_id = '';
//$course_name = '';

if(is_post_request()) {

    // Handle form values sent by edit/new.php

	$course_id = $_POST['course_id'] ?? '';
	$course_name = $_POST['course_name'] ?? '';
	
	$result = insert_course($course_id, $course_name);
	$new_id = mysqli_insert_id($db);
	redirect_to(url_for('admin/courses/show.php?id=' . $course_id));
	
} else {
  redirect_to(url_for('/admin/courses/new.php'));
}

?>


