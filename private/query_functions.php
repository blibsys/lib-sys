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

function find_all_contributors() {
    global $db;

    $sql = "SELECT c.contributor_id, c.contributor_name, ";
    $sql .= "GROUP_CONCAT(DISTINCT cr.role_name SEPARATOR ', ') AS roles ";
    $sql .= "FROM contributors c ";
    $sql .= "LEFT JOIN item_contributors ic ON ic.contributor_id = c.contributor_id ";
    $sql .= "LEFT JOIN contributor_roles cr ON cr.role_id = ic.role_id ";
    $sql .= "GROUP BY c.contributor_id, c.contributor_name ";
    $sql .= "ORDER BY c.contributor_name ASC";

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

	function find_all_circulation() {
	global $db;
	
	$sql = "SELECT * FROM circulation ";
	$sql .= "ORDER BY circulation_id ASC";
	$result = mysqli_query($db, $sql);
	confirm_result_set($result);
	return $result;
}

	function find_all_itemcontributors() {
	global $db;
	
	$sql = "SELECT * FROM item_contributors ";
	$sql .= "ORDER BY item_id ASC";
	$result = mysqli_query($db, $sql);
	confirm_result_set($result);
	return $result;
}

	function find_all_auth() {
	global $db;

	$sql = "SELECT a.auth_id, a.user_id, a.username, a.hashed_password, ";
	$sql .= "a.created_at AS auth_created_at, a.updated_at AS auth_updated_at, ";
	$sql .= "u.first_name, u.last_name, u.email, u.role ";
	$sql .= "FROM auth a ";
	$sql .= "LEFT JOIN users u ON u.user_id = a.user_id ";
	$sql .= "ORDER BY a.auth_id ASC";

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

	function find_all_item_types() {
	global $db;

	$sql = "SELECT DISTINCT item_type FROM items ";
	$sql .= "ORDER BY item_type ASC";
	$result = mysqli_query($db, $sql);
	confirm_result_set($result);
	return $result;
	}

	function find_all_item_statuses() {
	global $db;

	$sql = "SELECT DISTINCT item_status FROM items ";
	$sql .= "ORDER BY item_status ASC";
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
    $sql .= "i.publication_year, i.item_copy, i.publisher_id, i.category, i.created_at, i.updated_at, ";
    $sql .= "GROUP_CONCAT(DISTINCT CONCAT(c.contributor_name, ', ', cr.role_name) SEPARATOR '; ') AS contributors ";
    $sql .= "FROM items i ";
    $sql .= "LEFT JOIN item_contributors ic ON ic.item_id = i.item_id ";
    $sql .= "LEFT JOIN contributors c ON c.contributor_id = ic.contributor_id ";
    $sql .= "LEFT JOIN contributor_roles cr ON cr.role_id = ic.role_id ";
    $sql .= "WHERE i.item_id='" . db_escape($db, $id) . "' ";
    $sql .= "GROUP BY i.item_id, i.title, i.item_edition, i.isbn, i.item_type, i.publication_year, i.item_copy, i.created_at, i.updated_at, i.publisher_id, i.category";
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
	
	function find_contributor_by_id($id) {
		//show single contributor record via 'view' link 
	global $db;
	
	$sql = "SELECT c.*, cr.role_name FROM contributors c ";
	$sql .= "LEFT JOIN item_contributors ic ON ic.contributor_id = c.contributor_id ";
	$sql .= "LEFT JOIN contributor_roles cr ON cr.role_id = ic.role_id ";
	$sql .= "WHERE c.contributor_id='" . db_escape($db, $id) . "'";
	$result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $contributor = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $contributor; // returns an assoc. array
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

	function find_circulation_by_id($id) {
	global $db;
	$sql = "SELECT c.*, u.first_name, u.last_name, u.email, i.title ";
	$sql .= "FROM circulation c ";
	$sql .= "LEFT JOIN users u ON u.user_id = c.user_id ";
	$sql .= "LEFT JOIN items i ON i.item_id = c.item_id ";
	$sql .= "WHERE c.circulation_id='" . db_escape($db, $id) . "' ";
	$result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $circulation = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $circulation; // returns an assoc. array
	}
	
	function find_icontributor_by_id($id) {
	//show single itemcontributor record via 'view' link (add item title and contributor name) need to change this so we see all item contributors in one view
	global $db;
	
	$sql = "SELECT * FROM item_contributors ic ";
	$sql .= "LEFT JOIN items i on i.item_id = ic.item_id ";
	$sql .= "LEFT JOIN contributors c on c.contributor_id = ic.contributor_id ";
	$sql .= "WHERE ic.item_id='" . db_escape($db, $id) . "' ";
	//$sql .= "GROUP BY ic.item_id";
	$result = mysqli_query($db, $sql);
    confirm_result_set($result);
    
    $icontributor = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $icontributor; // returns an assoc. array
	} 

	function find_auth_by_id($id) {
	global $db;

	$sql = "SELECT a.auth_id, a.user_id, a.username, a.hashed_password, ";
	$sql .= "a.created_at AS auth_created_at, a.updated_at AS auth_updated_at, ";
	$sql .= "u.first_name, u.last_name, u.email, u.role, u.course_id ";
	$sql .= "FROM auth a ";
	$sql .= "LEFT JOIN users u ON u.user_id = a.user_id ";
	$sql .= "WHERE a.auth_id='" . db_escape($db, $id) . "' ";
	$sql .= "LIMIT 1";

	$result = mysqli_query($db, $sql);
	confirm_result_set($result);

	$auth = mysqli_fetch_assoc($result);
	mysqli_free_result($result);
	return $auth;
}

/*function find_auth_by_username($username) {
	global $db;

	$sql = "SELECT a.auth_id, a.user_id, a.username, a.hashed_password, ";
	$sql .= "a.created_at AS auth_created_at, a.updated_at AS auth_updated_at, ";
	$sql .= "u.first_name, u.last_name, u.email, u.role, u.course_id ";
	$sql .= "FROM auth a ";
	$sql .= "LEFT JOIN users u ON u.user_id = a.user_id ";
	$sql .= "WHERE a.username='" . db_escape($db, $username) . "' ";
	$sql .= "LIMIT 1";

	$result = mysqli_query($db, $sql);
	confirm_result_set($result);

	$auth = mysqli_fetch_assoc($result);
	mysqli_free_result($result);
	return $auth;
}*/

function find_auth_by_username($username) {
    global $db;

    $sql = "SELECT a.auth_id, a.user_id, a.username, a.hashed_password,
                   a.created_at AS auth_created_at, a.updated_at AS auth_updated_at,
                   u.first_name, u.last_name, u.email, u.role, u.course_id
            FROM auth a
            LEFT JOIN users u ON u.user_id = a.user_id
            WHERE a.username = ?
            LIMIT 1";

    $stmt = mysqli_prepare($db, $sql);
    if (!$stmt) {
        // Handle error appropriately
        exit('Database error: ' . mysqli_error($db));
    }

    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    if (!$result) {
        // Handle error appropriately
        exit('Database error: ' . mysqli_error($db));
    }

    $auth = mysqli_fetch_assoc($result);

    mysqli_free_result($result);
    mysqli_stmt_close($stmt);

    return $auth;
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
   		$allowed_roles = ['Student', 'Staff', 'Admin', 'Guest'];
   		$errors = validate_user($user, $allowed_roles);
    	if(!empty($errors)) {
    		return $errors;
    	}
		
		$sql = "INSERT INTO users ";
		$sql .= "(first_name, last_name, user_start_date, user_end_date, role, email, course_id) ";
		$sql .= "VALUES (";
		$sql .= "'" . db_escape($db, $user['first_name']) . "',";
		$sql .= "'" . db_escape($db, $user['last_name']) . "',";
		$sql .= "'" . db_escape($db, $user['user_start_date']) . "',";
		$sql .= "'" . db_escape($db, $user['user_end_date']) . "',";
		$sql .= "'" . db_escape($db, $user['role']) . "',";
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
		
	 	$errors = validate_course_insert($course);
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
	
	function insert_contributor($contributor){
		global $db;
		
		$errors = validate_contributor_insert($contributor);
		if(!empty($errors)) {
	 	   return $errors;
	    }
	    
		$sql = "INSERT INTO contributors ";
		$sql .= "(contributor_id, contributor_name) ";
		$sql .= "VALUES (";
		$sql .= "'" . db_escape($db, $contributor['contributor_id']) . "',";
		$sql .= "'" . db_escape($db, $contributor['contributor_name']) . "'";
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
	
	/*function insert_publisher($pub){
		global$db;
		
		$errors = validate_publisher($pub);
		if(!empty($errors)) {
			return $errors;
		}
		
		$sql = "INSERT INTO publishers ";
		$sql .= "(publisher_name) ";
		$sql .= "VALUES (";
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
	} */

		function insert_publisher($pub) {
    global $db;

    $errors = validate_publisher($pub);
    if (!empty($errors)) {
        return $errors;
    }

    $sql = "INSERT INTO publishers (publisher_name) VALUES (?)";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("s", $pub['publisher_name']);
    $result = $stmt->execute();

    return $result ? true : mysqli_error($db);
}


	function insert_circulation($circulation){
		global $db;
		
		$errors = validate_circulation_insert($circulation);
		if(!empty($errors)) {
	 	   return $errors;
	    }
	    
		$sql = "INSERT INTO circulation ";
		$sql .= "(user_id, item_id, borrow_date) ";
		$sql .= "VALUES (";
		$sql .= "'" . db_escape($db, $circulation['user_id']) . "',";
		$sql .= "'" . db_escape($db, $circulation['item_id']) . "',";
		$sql .= "'" . db_escape($db, $circulation['borrow_date']) . "'";
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
	
	function insert_auth($auth) {
		global $db;

		$errors = validate_auth($auth);
		if(!empty($errors)) {
			return $errors;
		}

		$hashed_password = password_hash($auth['password'], PASSWORD_BCRYPT);

		$sql = "INSERT INTO auth ";
		$sql .= "(user_id, username, hashed_password) ";
		$sql .= "VALUES (";
		$sql .= "'" . db_escape($db, $auth['user_id']) . "',";
		$sql .= "'" . db_escape($db, $auth['username']) . "',";
		$sql .= "'" . db_escape($db, $hashed_password) . "'";
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

    	$allowed_roles = ['Student', 'Staff', 'Admin', 'Guest'];
    	$errors = validate_user($user, $allowed_roles);
    	if(!empty($errors)) {
    		return $errors;
    	}
    	
    	$sql = "UPDATE users SET ";
		$sql .= "first_name='" . db_escape($db, $user['first_name']) . "', ";
		$sql .= "last_name='" . db_escape($db, $user['last_name']) . "', ";
		$sql .= "user_start_date='" . db_escape($db, $user['user_start_date']) . "', ";
		$sql .= "user_end_date='" . db_escape($db, $user['user_end_date']) . "', ";
		$sql .= "role='" . db_escape($db, $user['role']) . "', ";
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
	 	
	 	$errors = validate_course_update($course);
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
			
	function update_contributor($contributor) {
		global $db;
		
		$errors = validate_contributor_update($contributor);
		if(!empty($errors)) {
	 	   return $errors;
	    }
		
		$sql = "UPDATE contributors SET ";
		$sql .= "contributor_name='" . db_escape($db, $contributor['contributor_name']) . "' ";
		$sql .= "WHERE contributor_id='" . db_escape($db, $contributor['contributor_id']) . "'";
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

	function update_auth($auth) {
		global $db;

		$errors = validate_auth($auth);
		if(!empty($errors)) {
			return $errors;
		}

		$hashed_password = password_hash($auth['password'], PASSWORD_BCRYPT);

		$sql = "UPDATE auth SET ";
		$sql .= "user_id='" . db_escape($db, $auth['user_id']) . "', ";
		$sql .= "username='" . db_escape($db, $auth['username']) . "', ";
		$sql .= "hashed_password='" . db_escape($db, $hashed_password) . "' ";
		$sql .= "WHERE auth_id='" . db_escape($db, $auth['auth_id']) . "'";
		$sql .= "LIMIT 1";

		$result = mysqli_query($db, $sql);
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

    function delete_contributor($id){
     	global $db;
	
		$sql = "DELETE FROM contributors ";
		$sql .= "WHERE contributor_id='" . db_escape($db, $id) . "' ";
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
	function delete_auth($id) {
		global $db;

		$sql = "DELETE FROM auth ";
		$sql .= "WHERE auth_id='" . db_escape($db, $id) . "' ";
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

	function delete_circulation($id) {
		global $db;
		
		// Start transaction to ensure both operations complete successfully
		mysqli_autocommit($db, false);
		
		try {
			// First, get the item_id from the circulation record before deleting it
			$circulation = find_circulation_by_id($id);
			if (!$circulation) {
				throw new Exception("Circulation record not found.");
			}
			
			$item_id = $circulation['item_id'];
			
			// Delete the circulation record
			$sql = "DELETE FROM circulation ";
			$sql .= "WHERE circulation_id='" . db_escape($db, $id) . "' ";
			$sql .= "LIMIT 1";
			
			$result = mysqli_query($db, $sql);
			if (!$result) {
				throw new Exception("Failed to delete circulation record: " . mysqli_error($db));
			}
			
			// Update the item status back to 'Available'
			$update_sql = "UPDATE items SET item_status='Available' ";
			$update_sql .= "WHERE item_id='" . db_escape($db, $item_id) . "' ";
			$update_sql .= "LIMIT 1";
			
			$update_result = mysqli_query($db, $update_sql);
			if (!$update_result) {
				throw new Exception("Failed to update item status: " . mysqli_error($db));
			}
			
			// Commit the transaction
			mysqli_commit($db);
			mysqli_autocommit($db, true);
			
			return true;
			
		} catch (Exception $e) {
			// Rollback the transaction on error
			mysqli_rollback($db);
			mysqli_autocommit($db, true);
			
			echo $e->getMessage();
			return false;
		}
	}
	
	//validation
	
	function validate_item($item) {
	global $db;
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

	
	function validate_user($user, $allowed_roles) {
	  $allowed_roles = ['Student', 'Staff', 'Admin', 'Guest'];
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
	 // role
	if (!in_array($user['role'], $allowed_roles)) {
			$errors[] = "Invalid role selected.";
	}
      //email
      if (!has_valid_email_format($user['email'])) {
      $errors[] = "Enter a valid email address.";
      }
	return $errors;
	}
	
	function validate_course_insert($course) {
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
	// Note: we pass $current_id to allow the current record to be d in the uniqueness check
	// This is useful when editing a record, so it doesn't conflict with itself
    if(!has_unique_course_id($course['course_id'], $current_id)) {
	  $errors[] = "Course id must be unique.";
	}
	return $errors; 
	}	

    function validate_course_update($course) {
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
    return $errors; 
    }
	
	function validate_contributor_insert($contributor) {
	  $errors = [];
   // contributor_id
    if(is_blank($contributor['contributor_id'])) {
      $errors[] = "contributor id cannot be blank.";
    } elseif(!has_length($contributor['contributor_id'], ['min' => 4, 'max' => 20])) {
      $errors[] = "contributor id must be between 4 and 20 characters.";
    }
    $current_id = $contributor['id'] ?? '0';
    if(!has_unique_contributor_id($contributor['contributor_id'], $current_id)) {
	  $errors[] = "contributor id must be unique.";
	}
    // contributor_name
    if(is_blank($contributor['contributor_name'])) {
      $errors[] = "contributor name cannot be blank.";
    } elseif(!has_length($contributor['contributor_name'], ['min' => 2, 'max' => 100])) {
      $errors[] = "contributor name must be between 2 and 100 characters.";
    }
    return $errors; 
    }

	function validate_contributor_update($contributor) {
	  $errors = [];
    // contributor_name
    if(is_blank($contributor['contributor_name'])) {
      $errors[] = "contributor name cannot be blank.";
    } elseif(!has_length($contributor['contributor_name'], ['min' => 2, 'max' => 100])) {
      $errors[] = "contributor name must be between 2 and 100 characters.";
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

	function validate_auth($auth) {
		$errors = [];

		// user_id
		if(!has_presence($auth['user_id'])) {
			$errors[] = "User ID cannot be blank.";
		} elseif(!has_length($auth['user_id'], ['min' => 1, 'max' => 20])) {
			$errors[] = "User ID must be between 1 and 20 characters.";
		} elseif(!user_exists($auth['user_id'])) {
			$errors[] = "User ID does not exist.";
		}
		// username
		if(!has_presence($auth['username'])) {
			$errors[] = "Username cannot be blank.";
		} elseif(!has_length($auth['username'], ['min' => 4, 'max' => 30])) {
			$errors[] = "Username must be between 4 and 30 characters.";
		} elseif(!has_unique_username($auth['username'], $auth['auth_id'] ?? null)) {
			$errors[] = "Username must be unique.";
		} 

		// hashed_password
		if(!has_presence($auth['password'])) {
			$errors[] = "Password cannot be blank.";
		} elseif(!has_length($auth['password'], ['min' => 12, 'max' => 255])) {
			$errors[] = "Password must be at least 12 characters.";
		} elseif(!preg_match('/[A-Z]/', $auth['password'])) {
			$errors[] = "Password must contain at least 1 uppercase letter.";
		} elseif(!preg_match('/[a-z]/', $auth['password'])) {
			$errors[] = "Password must contain at least 1 lowercase letter.";
		} elseif(!preg_match('/[0-9]/', $auth['password'])) {
			$errors[] = "Password must contain at least 1 number.";
		} elseif(!preg_match('/[\W_]/', $auth['password'])) {
			$errors[] = "Password must contain at least 1 special character.";
		} 

		// confirm_password
		if(is_blank($auth['confirm_password'])) {
			$errors[] = "Confirm password cannot be blank.";
		} elseif($auth['password'] !== $auth['confirm_password']) {
			$errors[] = "Password and confirm password do not match.";
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

	function validate_circulation($circulation) {
		global $db;
		$errors = [];
		
		// Validate borrow_date
		if(!has_presence($circulation['borrow_date'] ?? '')) {
			$errors[] = "Borrow date cannot be blank.";
		} elseif(!preg_match('/^\d{4}-\d{2}-\d{2}$/', $circulation['borrow_date'])) {
			$errors[] = "Borrow date must be in YYYY-MM-DD format.";
		}
		
		// Validate date_due_back (if provided)
		if(has_presence($circulation['date_due_back'] ?? '')) {
			if(!preg_match('/^\d{4}-\d{2}-\d{2}$/', $circulation['date_due_back'])) {
				$errors[] = "Due date must be in YYYY-MM-DD format.";
			} elseif(has_presence($circulation['borrow_date'] ?? '') && $circulation['date_due_back'] < $circulation['borrow_date']) {
				$errors[] = "Due date must be on or after the borrow date.";
			}
		}
		
		// Validate returned_date (if provided)
		if(has_presence($circulation['returned_date'] ?? '')) {
			if(!preg_match('/^\d{4}-\d{2}-\d{2}$/', $circulation['returned_date'])) {
				$errors[] = "Returned date must be in YYYY-MM-DD format.";
			} elseif(has_presence($circulation['borrow_date'] ?? '') && $circulation['returned_date'] < $circulation['borrow_date']) {
				$errors[] = "Returned date must be on or after the borrow date.";
			} elseif($circulation['returned_date'] > date('Y-m-d')) {
				$errors[] = "Returned date cannot be in the future.";
			}
		}
		
		return $errors;
	}

	function validate_circulation_insert($circulation) {
		global $db;
		$errors = [];
		
		// Validate user_id
		if(!has_presence($circulation['user_id'] ?? '')) {
			$errors[] = "User ID cannot be blank.";
		} elseif(!is_numeric($circulation['user_id']) || (int)$circulation['user_id'] <= 0) {
			$errors[] = "User ID must be a positive number.";
		} elseif(!user_exists($circulation['user_id'])) {
			$errors[] = "User ID does not exist.";
		}
		
		// Validate item_id
		if(!has_presence($circulation['item_id'] ?? '')) {
			$errors[] = "Item ID cannot be blank.";
		} elseif(!is_numeric($circulation['item_id']) || (int)$circulation['item_id'] <= 0) {
			$errors[] = "Item ID must be a positive number.";
		} elseif(!item_exists($circulation['item_id'])) {
			$errors[] = "Item ID does not exist.";
		} else {
			// Only check item status if item exists
			$item_status = get_item_status($circulation['item_id']);
			if($item_status !== 'Available') {
				$errors[] = "Item is not available for loan. Current status: " . $item_status;
			}
		}
		
		// Validate borrow_date
		if(!has_presence($circulation['borrow_date'] ?? '')) {
			$errors[] = "Borrow date cannot be blank.";
		} elseif(!preg_match('/^\d{4}-\d{2}-\d{2}$/', $circulation['borrow_date'])) {
			$errors[] = "Borrow date must be in YYYY-MM-DD format.";
		} else {
			// Check if the date is valid
			$date_parts = explode('-', $circulation['borrow_date']);
			if(!checkdate((int)$date_parts[1], (int)$date_parts[2], (int)$date_parts[0])) {
				$errors[] = "Borrow date is not a valid date.";
			} elseif($circulation['borrow_date'] > date('Y-m-d')) {
				$errors[] = "Borrow date cannot be in the future.";
			}
		}
		
		return $errors;
	}

	function update_circulation($circulation) {
		global $db;

		$errors = validate_circulation($circulation);
		if(!empty($errors)) {
			return $errors;
		}	
		
		// Build the SET clause more carefully, only including circulation table fields
		$set_parts = [];
		
		// Always update borrow_date
		$set_parts[] = "borrow_date='" . db_escape($db, $circulation['borrow_date']) . "'";
		
		// Handle date_due_back - if provided, use it, otherwise let MySQL handle the generated column
		if(has_presence($circulation['date_due_back'])) {
			$set_parts[] = "date_due_back='" . db_escape($db, $circulation['date_due_back']) . "'";
		}
		
		// Handle returned_date - can be NULL
		if(has_presence($circulation['returned_date'])) {
			$set_parts[] = "returned_date='" . db_escape($db, $circulation['returned_date']) . "'";
		} else {
			$set_parts[] = "returned_date=NULL";
		}
		
		$sql = "UPDATE circulation SET " . implode(", ", $set_parts) . " ";
		$sql .= "WHERE circulation_id='" . db_escape($db, $circulation['circulation_id']) . "' ";
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

	//SEARCH QUERIES

	//basic search allowing one search term
	/*function search_items($db, $search) {
    // Prepare search terms
    $like = '%' . $search . '%';

    // Try to detect a year (4 digits)
    $year = (preg_match('/^\d{4}$/', $search)) ? $search : '';
    // Remove hyphens for ISBN search
    $isbn = preg_replace('/-/', '', $search);

    $sql = "
      SELECT items.*, publishers.publisher_name AS pub, GROUP_CONCAT(DISTINCT contributors.contributor_name SEPARATOR ', ') AS contributors
      FROM items
      JOIN item_contributors ON items.item_id = item_contributors.item_id
      JOIN contributors ON item_contributors.contributor_id = contributors.contributor_id
	  JOIN publishers ON items.publisher_id = publishers.publisher_id
	  WHERE
		items.title LIKE ?
		OR REPLACE(items.isbn, '-', '') = ?
		OR CAST(items.publication_year AS CHAR) = ?
		OR contributors.contributor_name LIKE ?
      GROUP BY items.item_id
    ";

    $stmt = $db->prepare($sql);
    $stmt->bind_param('ssss', $like, $isbn, $year, $like);
    $stmt->execute();
    $result = $stmt->get_result();

    $results = [];
    while ($row = $result->fetch_assoc()) {
        $results[] = $row;
    }
    return $results;
}
	*/

	// more advanced item search allowing multiple terms and fuzzy matching and searching across multiple fields
	
	function keyword_search_items($db, $search, $fuzzy = false) {
    // Split the search string into words (for multi-word search)
    $words = preg_split('/\s+/', trim($search));
    $where = [];
    $params = [];
    foreach ($words as $word) {
        $word_conds = [];
        // Search title
        if ($fuzzy) {
            $word_conds[] = "SOUNDEX(items.title) = SOUNDEX(?)";
            $params[] = $word;
        } else {
            $word_conds[] = "items.title LIKE ?";
            $params[] = "%$word%";
        }
        // Search contributors
        if ($fuzzy) {
            $word_conds[] = "SOUNDEX(contributors.contributor_name) = SOUNDEX(?)";
            $params[] = $word;
        } else {
            $word_conds[] = "contributors.contributor_name LIKE ?";
            $params[] = "%$word%";
        }
        // Search publisher
        if ($fuzzy) {
            $word_conds[] = "SOUNDEX(publishers.publisher_name) = SOUNDEX(?)";
            $params[] = $word;
        } else {
            $word_conds[] = "publishers.publisher_name LIKE ?";
            $params[] = "%$word%";
        }
        // Search ISBN
        $word_conds[] = "items.isbn LIKE ?";
        $params[] = "%$word%";
        // Search Item ID (exact match for numeric values)
        if (is_numeric($word)) {
            $word_conds[] = "items.item_id = ?";
            $params[] = $word;
        }
        // Combine all fields for this word as OR
        $where[] = '(' . implode(' OR ', $word_conds) . ')';
    }
    // Final SQL
    $sql = "
        SELECT items.*, 
               GROUP_CONCAT(DISTINCT contributors.contributor_name SEPARATOR ', ') AS contributors, 
               publishers.publisher_name AS pub
        FROM items
        LEFT JOIN item_contributors ON items.item_id = item_contributors.item_id
        LEFT JOIN contributors ON item_contributors.contributor_id = contributors.contributor_id
        LEFT JOIN publishers ON items.publisher_id = publishers.publisher_id
        WHERE " . implode(' AND ', $where) . "
        GROUP BY items.item_id
        ORDER BY items.title ASC
    ";
    $stmt = $db->prepare($sql);
    $types = str_repeat('s', count($params));
    if ($params) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

function advanced_search_items($db, $params) {
    $where = [];
    $sql_params = [];

    // Title
    if ($params['title']) {
        if ($params['fuzzy']) {
            $where[] = "SOUNDEX(items.title) = SOUNDEX(?)";
            $sql_params[] = $params['title'];
        } else {
            $where[] = "items.title LIKE ?";
            $sql_params[] = "%{$params['title']}%";
        }
    }
    // Author/contributor
    if ($params['author']) {
        if ($params['fuzzy']) {
            $where[] = "SOUNDEX(contributors.contributor_name) = SOUNDEX(?)";
            $sql_params[] = $params['author'];
        } else {
            $where[] = "contributors.contributor_name LIKE ?";
            $sql_params[] = "%{$params['author']}%";
        }
    }
    // Year
    if ($params['year']) {
        $where[] = "items.publication_year = ?";
        $sql_params[] = $params['year'];
    }
    // ISBN
    if ($params['isbn']) {
        $where[] = "items.isbn = ?";
        $sql_params[] = $params['isbn'];
    }
    // Publisher
    if ($params['publisher']) {
        if ($params['fuzzy']) {
            $where[] = "SOUNDEX(publishers.publisher_name) = SOUNDEX(?)";
            $sql_params[] = $params['publisher'];
        } else {    
            $where[] = "publishers.publisher_name LIKE ?";
            $sql_params[] = "%{$params['publisher']}%";
        }
    }

    $sql = "
        SELECT items.*, 
               GROUP_CONCAT(contributors.contributor_name SEPARATOR ', ') AS contributors, 
               publishers.publisher_name AS pub
        FROM items
        LEFT JOIN item_contributors ON items.item_id = item_contributors.item_id
        LEFT JOIN contributors ON item_contributors.contributor_id = contributors.contributor_id
        LEFT JOIN publishers ON items.publisher_id = publishers.publisher_id
    ";
    if ($where) {
        $sql .= " WHERE " . implode(" AND ", $where);
    }
    $sql .= " GROUP BY items.item_id ORDER BY items.title ASC";

    $stmt = $db->prepare($sql);
    if ($sql_params) {
        $types = str_repeat('s', count($sql_params));
        $stmt->bind_param($types, ...$sql_params);
    }
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

// Search functions for users, contributors, and circulation

function keyword_search_users($db, $search_term) {
    global $db;
    
    $sql = "SELECT u.*, c.course_name ";
    $sql .= "FROM users u ";
    $sql .= "LEFT JOIN courses c ON c.course_id = u.course_id ";
    $sql .= "WHERE u.first_name LIKE ? ";
    $sql .= "OR u.last_name LIKE ? ";
    $sql .= "OR u.email LIKE ? ";
    $sql .= "OR c.course_name LIKE ? ";
    $sql .= "ORDER BY u.last_name, u.first_name ASC";
    
    $search_param = '%' . $search_term . '%';
    
    $stmt = mysqli_prepare($db, $sql);
    if (!$stmt) {
        exit('Database error: ' . mysqli_error($db));
    }
    
    mysqli_stmt_bind_param($stmt, "ssss", $search_param, $search_param, $search_param, $search_param);
    mysqli_stmt_execute($stmt);
    
    $result = mysqli_stmt_get_result($stmt);
    if (!$result) {
        exit('Database error: ' . mysqli_error($db));
    }
    
    // Convert mysqli result to array
    $users = [];
    while($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }
    
    mysqli_free_result($result);
    mysqli_stmt_close($stmt);
    return $users; // Return array instead of result resource
}

function keyword_search_contributors($db, $search_term) {
    global $db;
    
    $sql = "SELECT * FROM contributors ";
    $sql .= "WHERE contributor_name LIKE ? ";
    $sql .= "OR contributor_id LIKE ? ";
    $sql .= "ORDER BY contributor_name ASC";
    
    $search_param = '%' . $search_term . '%';
    
    $stmt = mysqli_prepare($db, $sql);
    if (!$stmt) {
        exit('Database error: ' . mysqli_error($db));
    }
    
    mysqli_stmt_bind_param($stmt, "ss", $search_param, $search_param);
    mysqli_stmt_execute($stmt);
    
    $result = mysqli_stmt_get_result($stmt);
    if (!$result) {
        exit('Database error: ' . mysqli_error($db));
    }
    
    // Convert mysqli result to array
    $contributors = [];
    while($row = mysqli_fetch_assoc($result)) {
        $contributors[] = $row;
    }
    
    mysqli_free_result($result);
    mysqli_stmt_close($stmt);
    return $contributors; // Return array instead of result resource
}

function keyword_search_auth($db, $search_term, $role = '') {
    $sql = "SELECT a.auth_id, a.user_id, a.username, a.hashed_password, ";
    $sql .= "a.created_at AS auth_created_at, a.updated_at AS auth_updated_at, ";
    $sql .= "u.first_name, u.last_name, u.email, u.role ";
    $sql .= "FROM auth a ";
    $sql .= "LEFT JOIN users u ON u.user_id = a.user_id ";
    $sql .= "WHERE 1 ";

    $params = [];
    $types = '';

    if(!empty($search_term)) {
        $sql .= "AND (a.username LIKE ? OR u.first_name LIKE ? OR u.last_name LIKE ? OR u.email LIKE ?) ";
        $like_term = '%' . $search_term . '%';
        $params[] = $like_term;
        $params[] = $like_term;
        $params[] = $like_term;
        $params[] = $like_term;
        $types .= 'ssss';
    }
    if(!empty($role)) {
        $sql .= "AND u.role = ? ";
        $params[] = $role;
        $types .= 's';
    }

    $sql .= "ORDER BY a.auth_id ASC";

    $stmt = mysqli_prepare($db, $sql);
    if(!empty($params)) {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $auths = [];
    while($row = mysqli_fetch_assoc($result)) {
        $auths[] = $row;
    }
    mysqli_free_result($result);
    mysqli_stmt_close($stmt);

    return $auths;
}

function keyword_search_circulation($db, $search_term) {
    global $db;
    
    $sql = "SELECT c.*, u.first_name, u.last_name, u.email, i.title ";
    $sql .= "FROM circulation c ";
    $sql .= "JOIN users u ON u.user_id = c.user_id ";
    $sql .= "JOIN items i ON i.item_id = c.item_id ";
    $sql .= "WHERE u.first_name LIKE ? ";
    $sql .= "OR u.last_name LIKE ? ";
    $sql .= "OR u.email LIKE ? ";
    $sql .= "OR i.title LIKE ? ";
    $sql .= "OR c.borrow_date LIKE ? ";
    $sql .= "OR c.user_id LIKE ? ";
    $sql .= "OR c.item_id LIKE ? ";
    $sql .= "OR c.circulation_id LIKE ? ";
    $sql .= "ORDER BY c.borrow_date DESC";
    
    $search_param = '%' . $search_term . '%';
    
    $stmt = mysqli_prepare($db, $sql);
    if (!$stmt) {
        exit('Database error: ' . mysqli_error($db));
    }
    
    mysqli_stmt_bind_param($stmt, "ssssssss", $search_param, $search_param, $search_param, $search_param, $search_param, $search_param, $search_param, $search_param);
    mysqli_stmt_execute($stmt);
    
    $result = mysqli_stmt_get_result($stmt);
    if (!$result) {
        exit('Database error: ' . mysqli_error($db));
    }
    
    // Convert mysqli result to array
    $circulation_records = [];
    while($row = mysqli_fetch_assoc($result)) {
        $circulation_records[] = $row;
    }
    
    mysqli_free_result($result);
    mysqli_stmt_close($stmt);
    return $circulation_records; // Return array instead of result resource
}




function find_all_user_roles() {
    global $db;
    
    $sql = "SELECT DISTINCT role FROM users ";
    $sql .= "ORDER BY role ASC";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    
    $roles = [];
    while($row = mysqli_fetch_assoc($result)) {
        $roles[] = $row['role'];
    }
    mysqli_free_result($result);
    return $roles;
}
	

function find_all_auth_roles() {
    global $db;

    $sql = "SELECT DISTINCT role FROM users ";
    $sql .= "ORDER BY role ASC";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);

    $roles = [];
    while($row = mysqli_fetch_assoc($result)) {
        $roles[] = $row['role'];
    }
    mysqli_free_result($result);
    return $roles;
}