<?php

require_once('../../../private/initialise.php');

if(is_post_request()) {

    // Handle form values sent by edit/new.php

	$user_id = $_POST['user_id'] ?? '';
	$first_name = $_POST['first_name'] ?? '';
	$last_name = $_POST['last_name'] ?? '';
	$user_start_date = $_POST['user_start_date'] ?? '';
	$user_end_date = $_POST['user_end_date'] ?? '';
	$user_type = $_POST['user_type'] ?? '';
	$email = $_POST['email'] ?? '';
	$course_id = $_POST['course_id'] ?? '';
	
	$result = insert_user($user_id, $first_name, $last_name, $user_start_date, $user_end_date, $user_type, $email, $course_id);
	$new_id = mysqli_insert_id($db);
	redirect_to(url_for('admin/users/show.php?id=' . $user_id));
	
} else {
  redirect_to(url_for('/admin/users/new.php'));
}

?>

