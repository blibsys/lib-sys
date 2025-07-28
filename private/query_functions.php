<?php

    //find all records
	function find_all_items() {
	global $db;
	
//set function to call reusable query. Space at end of first line prior to concatenation v important
	
	$sql = "SELECT * FROM items ";
	$sql .= "ORDER BY item_id ASC";
	//echo $sql;
	$result = mysqli_query($db, $sql);
	confirm_result_set($result);
	return $result;
}

	function find_all_users() {
	global $db;
	
	$sql = "SELECT * FROM users ";
	$sql .= "ORDER BY user_id ASC";
	$result = mysqli_query($db, $sql);
	confirm_result_set($result);
	return $result;
}

	function find_all_courses() {
	global $db;
	
	$sql = "SELECT * FROM courses ";
	$sql .= "ORDER BY course_id ASC";
	$result = mysqli_query($db, $sql);
	confirm_result_set($result);
	return $result;
}

	function find_all_creators() {
	global $db;
	
	$sql = "SELECT * FROM creators ";
	$sql .= "ORDER BY creator_id ASC";
	$result = mysqli_query($db, $sql);
	confirm_result_set($result);
	return $result;
}

	function find_all_pubs() {
	global $db;
	
	$sql = "SELECT * FROM publishers ";
	$sql .= "ORDER BY publisher_id ASC";
	$result = mysqli_query($db, $sql);
	confirm_result_set($result);
	return $result;
}

	function find_all_circ() {
	global $db;
	
	$sql = "SELECT * FROM circulation ";
	$sql .= "ORDER BY circulation_id ASC";
	$result = mysqli_query($db, $sql);
	confirm_result_set($result);
	return $result;
}

	function find_all_itemcreators() {
	global $db;
	
	$sql = "SELECT * FROM item_creators ";
	$sql .= "ORDER BY item_id ASC";
	$result = mysqli_query($db, $sql);
	confirm_result_set($result);
	return $result;
}
	function find_all_cats() {
	global $db;

	$sql = "SELECT DISTINCT category FROM items ";
	$sql .= "ORDER BY category ASC";
	$result = mysqli_query($db, $sql);
	confirm_result_set($result);
	return $result;
	}

	function find_items_by_cat($cat) {
	global $db;	
	$sql = "SELECT * FROM items ";
	$sql .= "WHERE category='" . db_escape($db, $cat) . "' ";
	$sql .= "ORDER BY item_id ASC";
	$result = mysqli_query($db, $sql);
	confirm_result_set($result);
	return $result;
	}

	

    //find single record 
	function find_item_by_id($id) {
    global $db;
	$sql  = "SELECT i.item_id, i.title, i.item_status, i.item_edition, i.isbn, i.item_type, ";
	$sql .= "i.publication_year, i.item_copy, i.publisher_id, i.category, ";
	$sql .= "GROUP_CONCAT(c.creator_name ORDER BY c.creator_name SEPARATOR ', ') AS creators ";
	$sql .= "FROM items i ";
	$sql .= "LEFT JOIN item_creators ic ON ic.item_id = i.item_id ";
	$sql .= "LEFT JOIN creators c ON c.creator_id = ic.creator_id ";
	$sql .= "WHERE i.item_id='" . db_escape($db, $id) . "' ";
	$sql .= "GROUP BY i.item_id, i.title, i.item_edition, i.isbn, i.item_type, i.publication_year, i.item_copy";
	$result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $item = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $item;
	}
	
	function find_user_by_id($id) {
	//show single user record via 'view' link (adds course name)
	global $db;
 	$sql = "SELECT u.*, c.course_name ";
	$sql .= "FROM users u ";
    $sql .= "JOIN courses c ON c.course_id = u.course_id ";
    $sql .= "WHERE u.user_id='" . db_escape($db, $id) . "' ";
    //$sql .= "GROUP BY u.user_id"; 
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $user = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $user;
	}

	function find_course_by_id($id) {
	//show single course record via 'view' link 
	global $db;
	
	$sql = "SELECT * FROM courses ";
	$sql .= "WHERE course_id='" . db_escape($db, $id) . "'";
	$result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $course = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $course; // returns an assoc. array
	}
	
	function find_creator_by_id($id) {
		//show single creator record via 'view' link 
	global $db;
	
	$sql = "SELECT * FROM creators ";
	$sql .= "WHERE creator_id='" . db_escape($db, $id) . "'";
	$result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $creator = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $creator; // returns an assoc. array
	}
	
	function find_pub_by_id($id) {
	global $db;
	$sql = "SELECT * FROM publishers ";
	$sql .= "WHERE publisher_id='" . db_escape($db, $id) . "'";
	$result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $pub = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $pub; // returns an assoc. array
	}

	function find_circ_by_id($id) {
	global $db;
	$sql = "SELECT * FROM circulation c ";
	$sql .="JOIN users u ON u.user_id = c.user_id ";
	$sql .="JOIN items i ON i.item_id = c.item_id ";
	$sql .= "WHERE circulation_id='" . db_escape($db, $id) . "' ";
	// .= "GROUP BY c.user_id";
	$result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $circ = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $circ; // returns an assoc. array
	}
	
	function find_icreator_by_id($id) {
	//show single itemcreator record via 'view' link (add item title and creator name) need to change this so we see all item creators in one view
	global $db;
	
	$sql = "SELECT * FROM item_creators ic ";
	$sql .= "LEFT JOIN items i on i.item_id = ic.item_id ";
	$sql .= "LEFT JOIN creators c on c.creator_id = ic.creator_id ";
	$sql .= "WHERE ic.item_id='" . db_escape($db, $id) . "' ";
	//$sql .= "GROUP BY ic.item_id";
	$result = mysqli_query($db, $sql);
    confirm_result_set($result);
    
    $icreator = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $icreator; // returns an assoc. array
	} 
	

	//INSERT
	function insert_item($item)
	 { global $db;

		$errors = validate_item($item);
		if(!empty($errors)) {
			return $errors;
		}	
	  
	  	$sql = "INSERT INTO items ";
		$sql .= "(title, item_edition, isbn, item_type, publication_year, item_copy, publisher_id, category, item_status) ";
		$sql .= "VALUES (";
		$sql .= "'" . db_escape($db, $item['title']) . "',";
		$sql .= "'" . db_escape($db, $item['item_edition']) . "',";
		$sql .= "'" . db_escape($db, $item['isbn']) . "',";
		$sql .= "'" . db_escape($db, $item['item_type']) . "',";
		$sql .= "'" . db_escape($db, $item['publication_year']) . "',";
		$sql .= "'" . db_escape($db, $item['item_copy']) . "',";
		$sql .= "'" . db_escape($db, $item['publisher_id']) . "',";
		$sql .= "'" . db_escape($db, $item['category']) . "',";
		$sql .= "'" . db_escape($db, $item['item_status']) . "'";
		$sql .= ")";
		$result = mysqli_query($db, $sql);
		//for INSERT statements, $result is true/false
		//echo $sql . "<br>";
		//echo mysqli_error($db);
		if($result) {
			return true;
		} else {
		  // INSERT failed
		  echo mysqli_error($db);
		  db_disconnect($db);
		  exit;
		}
	}	  
	
	function insert_user($user)
   	{	global $db;
   	
   		$errors = validate_user($user);
    	if(!empty($errors)) {
    		return $errors;
    	}
		
		$sql = "INSERT INTO users ";
		$sql .= "(first_name, last_name, user_start_date, user_end_date, user_type, email, course_id) ";
		$sql .= "VALUES (";
		$sql .= "'" . db_escape($db, $user['first_name']) . "',";
		$sql .= "'" . db_escape($db, $user['last_name']) . "',";
		$sql .= "'" . db_escape($db, $user['user_start_date']) . "',";
		$sql .= "'" . db_escape($db, $user['user_end_date']) . "',";
		$sql .= "'" . db_escape($db, $user['user_type']) . "',";
		$sql .= "'" . db_escape($db, $user['email']) . "',";
		$sql .= "'" . db_escape($db, $user['course_id']) . "'";
		$sql .= ")";
			$result = mysqli_query($db, $sql);
		//for INSERT statements, $result is true/false
		if($result) {
			return true;
		} else {
		  //INSERT failed
		  echo mysqli_error($db);
		  db_disconnect($db);
		  exit;
		}		
	}
	
	function insert_course($course){
		global $db;
		
	 	$errors = validate_course($course);
	 	if(!empty($errors)) {
	 	   return $errors;
	    }
			
		$sql = "INSERT INTO courses ";
		$sql .= "(course_id, course_name) ";
		$sql .= "VALUES (";
		$sql .= "'" . db_escape($db, $course['course_id']) . "',";
		$sql .= "'" . db_escape($db, $course['course_name']) . "'";
		$sql .= ")";
		$result = mysqli_query($db, $sql);
		//for INSERT statements, $result is true/false
		if($result) {
			return true;
		} else {
		  //INSERT failed
		  echo mysqli_error($db);
		  db_disconnect($db);
		  exit;
		}
	}
	
	function insert_creator($creator){
		global $db;
		
		$errors = validate_creator_insert($creator);
		if(!empty($errors)) {
	 	   return $errors;
	    }
	    
		$sql = "INSERT INTO creators ";
		$sql .= "(creator_id, creator_name) ";
		$sql .= "VALUES (";
		$sql .= "'" . db_escape($db, $creator['creator_id']) . "',";
		$sql .= "'" . db_escape($db, $creator['creator_name']) . "'";
		$sql .= ")";
		$result = mysqli_query($db, $sql);
		//for INSERT statements, $result is true/false
		if($result) {
			return true;
		} else {
		  //INSERT failed
		  echo mysqli_error($db);
		  db_disconnect($db);
		  exit;
		}
	}
	
	function insert_publisher($pub){
		global$db;
		
		$errors = validate_publisher($pub);
		if(!empty($errors)) {
			return $errors;
		}
		
		$sql = "INSERT INTO publishers ";
		$sql .= "(publisher_name) ";
		$sql .= "VALUES (";
		//$sql .= "'" . db_escape($db, $pub['publisher_id]) . "',";
		$sql .= "'" . db_escape($db, $pub['publisher_name']) . "'";
		$sql .= ")";
			$result = mysqli_query($db, $sql);
		//for INSERT statements, $result is true/false
		if($result) {
			return true;
		} else {
		  //INSERT failed
		  echo mysqli_error($db);
		  db_disconnect($db);
		  exit;
		}
	}
	
		
	//UPDATE	
	function update_item($item) {
		global $db;

		$errors = validate_item($item);
		if(!empty($errors)) {
			return $errors;
		}	
		
		$sql = "UPDATE items SET ";
		$sql .= "title='" . db_escape($db, $item['title']) . "', ";
		$sql .= "item_edition='" . db_escape($db, $item['item_edition']) . "', ";
		$sql .= "isbn='" . db_escape($db, $item['isbn']) . "', ";
		$sql .= "item_type='" . db_escape($db, $item['item_type']) . "', ";
		$sql .= "publication_year='" . db_escape($db, $item['publication_year']) . "', ";
		$sql .= "item_copy='" . db_escape($db, $item['item_copy']) . "', ";
		$sql .= "publisher_id='" . db_escape($db, $item['publisher_id']) . "', ";
		$sql .= "category='" . db_escape($db, $item['category']) . "', ";
		$sql .= "item_status='" . db_escape($db, $item['item_status']) . "' ";	
		$sql .= "WHERE item_id='" . db_escape($db, $item['id']) . "'";
		$sql .= "LIMIT 1";
	
		$result = mysqli_query($db, $sql);
		// for UPDATE statements, $result is true/false
		if($result) {
		  return true;
		} else {
		  // update failed
		  echo mysqli_error($db);
		  db_disconnect($db);
		 // echo $sql;
		  exit;
		}
	}
	
	function update_user($user) {
    	global $db;
    	
    	$errors = validate_user($user);
    	if(!empty($errors)) {
    		return $errors;
    	}
    	
    	$sql = "UPDATE users SET ";
		$sql .= "first_name='" . db_escape($db, $user['first_name']) . "', ";
		$sql .= "last_name='" . db_escape($db, $user['last_name']) . "', ";
		$sql .= "user_start_date='" . db_escape($db, $user['user_start_date']) . "', ";
		$sql .= "user_end_date='" . db_escape($db, $user['user_end_date']) . "', ";
		$sql .= "user_type='" . db_escape($db, $user['user_type']) . "', ";
		$sql .= "email='" . db_escape($db, $user['email']) . "', ";
		$sql .= "course_id='" . db_escape($db, $user['course_id']) . "' ";
		$sql .= "WHERE user_id='" . db_escape($db, $user['id']) . "'";
		$sql .= "LIMIT 1";
		
		$result = mysqli_query($db, $sql);
		// for UPDATE statements, $result is true/false
		if($result) {
		  return true;
		} else {
		  // update failed
		  echo mysqli_error($db);
		  db_disconnect($db);
		  exit;
		  
		}
	}
	
	function update_course($course) {
	 	global $db;
	 	
	 	$errors = validate_course($course);
	 	if(!empty($errors)) {
	 	   return $errors;
	    }
	 	
	 	$sql = "UPDATE courses SET ";
		$sql .= "course_name='" . db_escape($db, $course['course_name']) . "' ";
		$sql .= "WHERE course_id='" . db_escape($db, $course['course_id']) . "'";
		$sql .= "LIMIT 1";
	
		$result = mysqli_query($db, $sql);
		// for UPDATE statements, $result is true/false
		if($result) {
		  return true;
		} else {
		  // update failed
		  echo mysqli_error($db);
		  db_disconnect($db);
		  exit;
		  
		}
	}
			
	function update_creator($creator) {
		global $db;
		
		$errors = validate_creator_update($creator);
		if(!empty($errors)) {
	 	   return $errors;
	    }
		
		$sql = "UPDATE creators SET ";
		$sql .= "creator_name='" . db_escape($db, $creator['creator_name']) . "' ";
		$sql .= "WHERE creator_id='" . db_escape($db, $creator['creator_id']) . "'";
		$sql .= "LIMIT 1";
	
		$result = mysqli_query($db, $sql);
		// for UPDATE statements, $result is true/false
		if($result) {
		  return true;
		} else {
		  // update failed
		  echo mysqli_error($db);
		  db_disconnect($db);
		  exit;
		  
		}
	}
	
	function update_publisher($pub) {
		global $db;
		
		$errors = validate_publisher($pub);
		if(!empty($errors)) {
			return $errors;
		}
		
		$sql = "UPDATE publishers SET ";
		$sql .= "publisher_name='" . db_escape($db, $pub['publisher_name']) . "' ";
		$sql .= "WHERE publisher_id='" . db_escape($db, $pub['id']) . "'";
		$sql .= "LIMIT 1";
	
		$result = mysqli_query($db, $sql);
		// for UPDATE statements, $result is true/false
		if($result) {
		  return true;
		} else {
		  // update failed
		  echo mysqli_error($db);
		  db_disconnect($db);
		  exit;
		  
		}
	}
	
	
	//DELETE
	function delete_item($id) {
		global $db;
	
	$sql = "DELETE FROM items ";
	$sql .= "WHERE item_id='" . db_escape($db, $id) . "' ";
	$sql .= "LIMIT 1";
	
	$result = mysqli_query($db, $sql);
	
	if ($result) {
	   return true;
	 } else {
	 // DELETE failed
	 echo mysql_error($db);
	 db_disconnect($db);
	 exit;
	 }
  }
  
  	function delete_user($id) {
  		global $db;
	
		$sql = "DELETE FROM users ";
		$sql .= "WHERE user_id='" . db_escape($db, $id) . "' ";
		$sql .= "LIMIT 1";
		
		$result = mysqli_query($db, $sql);
		
		if ($result) {
		   return true;
		 } else {
		 // DELETE failed
		 echo mysql_error($db);
		 db_disconnect($db);
		 exit;
		 }
	  }
	
	   
	  
 
	  function delete_course($id) {
	global $db;

	$errors = validate_course_delete($id);
	if (!empty($errors)) {
		return $errors;
	}

	$sql = "DELETE FROM courses ";
	$sql .= "WHERE course_id='" . db_escape($db, $id) . "' ";
	$sql .= "LIMIT 1";

	$result = mysqli_query($db, $sql);

	if ($result) {
		return true;
	} else {
		echo mysqli_error($db);
		db_disconnect($db);
		exit;
	}
}

    function delete_creator($id){
     	global $db;
	
		$sql = "DELETE FROM creators ";
		$sql .= "WHERE creator_id='" . db_escape($db, $id) . "' ";
		$sql .= "LIMIT 1";
		
		$result = mysqli_query($db, $sql);
		
		//for DELETE statements, $result is true/false
		if($result) {
		  return true;
		} else {
		//delete failed
		  echo mysqli_error($db);
		  db_disconnect($db);
		  exit;
	   }
	}
	
	function delete_publisher($id) {
		global $db;
		
		$sql = "DELETE FROM publishers ";
		$sql .= "WHERE publisher_id='" . db_escape($db, $id) . "' ";
		$sql .= "LIMIT 1";
		
		$result = mysqli_query($db, $sql);
		
		//for DELETE statements, $result is true/false
		if($result) {
		  return true;
		} else {
		//delete failed
		  echo mysqli_error($db);
		  db_disconnect($db);
		  exit;
	   }
	}
	
	
	//validation
	
	function validate_item($item) {
	  $errors = [];
	  //title
	  if(!has_presence($item['title'])) {
	  $errors[] = "Title cannot be blank.";
	} elseif(!has_length($item['title'], ['min' => 1, 'max' => 255])) {
	  $errors[] = "Title must be between 1 and 255 characters.";
	}
	  //item_edition
	  	$edition_int = (int) $item['item_edition'];
      if($edition_int <= 0) {
      $errors[] = "Edition must be greater than zero.";
    }
      if($edition_int > 999) {
      $errors[] = "Edition must be less than 999.";
    }
	  //isbn
	  if(!has_presence($item['isbn'])) {
	  $errors[] = "ISBN cannot be blank.";
	} elseif(!has_length($item['isbn'], ['min' => 10, 'max' => 17])) {
	  $errors[] = "ISBN must be between 10 and 17 characters.";

	// Item type
      $allowed_types = ['book', 'journal', 'programme', 'dvd', 'other'];
      if(!in_array($item['item_type'], $allowed_types)) {
      $errors[] = "Invalid item type selected.";
 }
	}
	  //publication_year
	  if(!has_numbers_only($item['publication_year'])) {
	  $errors[] = "Publication year must be a number.";
	} elseif(!has_presence($item['publication_year'])) {
	  $errors[] = "Publication year cannot be blank.";
	} elseif(!has_length($item['publication_year'], ['min' => 4, 'max' => 4])) {
	  $errors[] = "Publication year must be exactly 4 digits.";
	}
	  //item_copy
	  if(!has_presence($item['item_copy'])) {
	  $errors[] = "Number of copies cannot be blank.";
	} elseif(!is_numeric($item['item_copy']) || (int)$item['item_copy'] <= 0) {
	  $errors[] = "Number of copies must be a positive number.";
	}
	  //publisher_id
	  if(!has_presence($item['publisher_id'])) {
	  $errors[] = "Publisher cannot be blank.";
	} else {
  	$publisher_id = db_escape($db, $item['publisher_id']);
  	$sql = "SELECT COUNT(*) FROM publishers WHERE publisher_id = '{$publisher_id}'";
  	$result = mysqli_query($db, $sql);
  	if($result) {
    $row = mysqli_fetch_row($result);
    if($row[0] == 0) {
      $errors[] = "Selected publisher does not exist.";
    }
    mysqli_free_result($result);
  } else {
    $errors[] = "Database error validating publisher.";
  }
  } 
	  //category
	  if(!has_presence($item['category'])) {
	  $errors[] = "Category cannot be blank.";
	} elseif(!has_length($item['category'], ['min' => 1, 'max' => 80])) {
	  $errors[] = "Category must be between 1 and 80 characters.";
	} 
	return $errors;
	}	

	function validate_user($user) {
	  $errors = [];
	  //first_name
	  if(!has_presence($user['first_name'])) {
      $errors[] = "First name cannot be blank.";
    } elseif(!has_length($user['first_name'], ['min' => 1, 'max' => 80])) {
      $errors[] = "First name name must be between 1 and 80 characters.";
    }
      //last_name
	  if(!has_presence($user['last_name'])) {
      $errors[] = "Last name cannot be blank.";
    } elseif(!has_length($user['last_name'], ['min' => 1, 'max' => 80])) {
      $errors[] = "Last name name must be between 1and 80 characters.";
    }
      //user_start_date
     if (!has_valid_date_format($user['user_start_date'])) {
     $errors[] = "Use date format yyyy-mm-dd.";
     }
        //user_end_date
     if (!has_valid_date_format($user['user_end_date'])) {
     $errors[] = "Use date format yyyy-mm-dd.";
     }
      //email
      if (!has_valid_email_format($user['email'])) {
      $errors[] = "Enter a valid email address.";
      }
	return $errors;
	}
	
	function validate_course($course) {
	  $errors = [];
    // course_id
    if(is_blank($course['course_id'])) {
      $errors[] = "Course id cannot be blank.";
    } elseif(!has_length($course['course_id'], ['min' => 4, 'max' => 20])) {
      $errors[] = "Course id must be between 4 and 20 characters.";
    }
    // course_name
    if(is_blank($course['course_name'])) {
      $errors[] = "Course name cannot be blank.";
    } elseif(!has_length($course['course_name'], ['min' => 4, 'max' => 80])) {
      $errors[] = "Course name must be between 4 and 80 characters.";
    }
	$current_id = $course['id'] ?? '0'; // if id is not set, use '0' to avoid errors
	// Check for unique course_id
	// Note: we pass $current_id to allow the current record to be ignored in the uniqueness check
	// This is useful when editing a record, so it doesn't conflict with itself
    if(!has_unique_course_id($course['course_id'], $current_id)) {
	  $errors[] = "Course id must be unique.";
	}
    
    return $errors; 
    }
	
	function validate_creator_insert($creator) {
	  $errors = [];
   // creator_id
    if(is_blank($creator['creator_id'])) {
      $errors[] = "Creator id cannot be blank.";
    } elseif(!has_length($creator['creator_id'], ['min' => 4, 'max' => 20])) {
      $errors[] = "Creator id must be between 4 and 20 characters.";
    }
    $current_id = $creator['id'] ?? '0';
    if(!has_unique_creator_id($creator['creator_id'], $current_id)) {
	  $errors[] = "Creator id must be unique.";
	}
    // creator_name
    if(is_blank($creator['creator_name'])) {
      $errors[] = "Creator name cannot be blank.";
    } elseif(!has_length($creator['creator_name'], ['min' => 2, 'max' => 100])) {
      $errors[] = "Creator name must be between 2 and 100 characters.";
    }
    return $errors; 
    }

	function validate_creator_update($creator) {
	  $errors = [];
    // creator_name
    if(is_blank($creator['creator_name'])) {
      $errors[] = "Creator name cannot be blank.";
    } elseif(!has_length($creator['creator_name'], ['min' => 2, 'max' => 100])) {
      $errors[] = "Creator name must be between 2 and 100 characters.";
    }
    return $errors; 
    }
	
	function validate_publisher($pub) {
	   $errors = [];
	   
	  if(!has_presence($pub['publisher_name'])) {
      $errors[] = "Publisher name cannot be blank.";
    } elseif(!has_length($pub['publisher_name'], ['min' => 2, 'max' => 100])) {
      $errors[] = "Publisher name must be between 2 and 100 characters.";
    }
	return $errors;
	   }
	
	function validate_course_delete($course_id) {
		$errors = [];
		// Check if the course has any users associated with it
		if(has_users_with_course_id($course_id)) {
			$errors[] = "Cannot delete course with users assigned to it.";
		}
		return $errors;
	}	

	



	/* 
	   // position
    // Make sure we are working with an integer
    $postion_int = (int) $subject['position'];
    if($postion_int <= 0) {
      $errors[] = "Position must be greater than zero.";
    }
    if($postion_int > 999) {
      $errors[] = "Position must be less than 999.";
    }

    // visible
    // Make sure we are working with a string
    $visible_str = (string) $subject['visible'];
    if(!has_inclusion_of($visible_str, ["0","1"])) {
      $errors[] = "Visible must be true or false.";
    }

    return $errors;
  }
	*/
		

?>	