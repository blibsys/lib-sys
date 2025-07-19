<?php

require_once('../../../private/initialise.php');

if(is_post_request()) {

    // Handle form values sent by edit/new.php

	//$item_id = $_POST['item_id'] ?? '';
	$title = $_POST['title'] ?? '';
	$item_edition = $_POST['item_edition'] ?? '';
	$isbn = $_POST['isbn'] ?? '';
	$item_type = $_POST['item_type'] ?? '';
	$publication_year = $_POST['publication_year'] ?? '';
	$item_copy = $_POST['item_copy'] ?? '';
	$publisher_id = $_POST['publisher_id'] ?? '';
	$category = $_POST['category'] ?? '';
	$item_status = $_POST['item_status'] ?? '';
	
	$result = insert_item($title, $item_edition, $isbn, $item_type, $publication_year, $item_copy, $publisher_id, $category, $item_status);
	$new_id = mysqli_insert_id($db);
	redirect_to(url_for('/admin/items/show.php?id=' . $new_id));

} else {
  redirect_to(url_for('/admin/items/new.php'));
}

?>