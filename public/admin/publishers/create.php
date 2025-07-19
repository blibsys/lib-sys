<?php

require_once('../../../private/initialise.php');

if(is_post_request()) {

    // Handle form values sent by edit/new.php

	$publisher_id = $_POST['publisher_id'] ?? '';
	$publisher_name = $_POST['publisher_name'] ?? '';
	
	$result = insert_publisher($publisher_id, $publisher_name);
	$new_id = mysqli_insert_id($db);
	redirect_to(url_for('admin/publishers/show.php?id=' . $publisher_id));
	
} else {
  redirect_to(url_for('/admin/publishers/new.php'));
}

?>

