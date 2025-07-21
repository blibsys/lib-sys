<?php

require_once('../../../private/initialise.php');

if(is_post_request()) {

  // Handle form values sent by new.php

  $course = [];
  $course['course_id'] = $_POST['course_id'] ?? '';
  $course['course_name'] = $_POST['course_name'] ?? '';

  $result = insert_course($course);
  $new_id = mysqli_insert_id($db);
  redirect_to(url_for('/admin/courses/show.php?id=' . $course['course_id']));

} else {

  redirect_to(url_for('/admin/courses/new.php'));
}

?>
