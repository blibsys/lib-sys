<?php

require_once('../../../private/initialise.php');

if(is_post_request()) {

    // Handle form values sent by edit/new.php

	$creator_id = $_POST['creator_id'] ?? '';
	$creator_name = $_POST['creator_name'] ?? '';
	
	$result = insert_creator($creator_id, $creator_name);
	$new_id = mysqli_insert_id($db);
	redirect_to(url_for('admin/creators/show.php?id=' . $creator_id));
	
} else {
  redirect_to(url_for('/admin/creators/new.php'));
}

?>
