<?php

require_once('../../../private/init.php'); 

if(is_post_request()) {

    // Handle form values sent by edit/new.php

	$user = [];
	$user['first_name'] = $_POST['first_name'] ?? '';
	$user['last_name'] = $_POST['last_name'] ?? '';
	$user['user_start_date'] = $_POST['user_start_date'] ?? '';
	$user['user_end_date'] = $_POST['user_end_date'] ?? '';
	$user['role'] = $_POST['role'] ?? '';
	$user['email'] = $_POST['email'] ?? '';
	$user['course_id'] = $_POST['course_id'] ?? '';
	
	$result = insert_user($user);
	if($result === true) {
    $_SESSION['message'] = 'User added successfully.';
		$new_id = mysqli_insert_id($db);
		redirect_to(url_for('admin/users/show.php?id=' . $new_id));
		} else {

		$errors = $result;
	} 
		} else {
		// display blank form
	}
	 $user_set = find_all_users();
	 $user_count = mysqli_num_rows($user_set) + 1;
	 mysqli_free_result($user_set);
	 
?>

<?php $page_title = 'Add user'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>

<!-- ("server side script for managing content") -->
<!-- need to add validation to the forms -->
<main aria-label="main content">
<div id="content">

  <a class="back-link" href="<?php echo url_for('/admin/users/index.php'); ?>">← Back to List</a>

  <div class="user new">
    <h2>Add user</h2>
    <h3>*User ID is automatically generated*</h3>
    
    <?php echo display_errors($errors); ?>

    <form class="admin-form1" action="<?php echo url_for('/admin/users/new.php'); ?>" method="post">
      <!--<dl>
        <dt>User id</dt>
        <dd><input type="text" name="user_id" value="" /></dd>
      </dl>-->
      <div class="form-row">
      <dl>
        <dt>Role</dt>
      <dd>  
            <select name=role">
        <?php foreach ($allowed_roles as $role): ?>
       <option value="<?php echo htmlspecialchars($role); ?>"
      <?php if (isset($user['role']) && $user['role'] === $role) echo 'selected'; ?>>
      <?php echo htmlspecialchars($role); ?>
      </option>
      <?php endforeach; ?>
       </select></dd>
      </dl>
      </div>
      <div class="form-row">
       <?php
    $result = mysqli_query($db, "SELECT course_id, course_name FROM courses");
        ?>
      <dl>  
        <dt>Course</dt>
        <dd>
          <select name="course_id">
            <option value="">-- Select Course --</option>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
              <option value="<?php echo h($row['course_id']); ?>"
                <?php if (($user['course_id'] ?? '') == $row['course_id']) echo 'selected'; ?>>
                <?php echo h($row['course_id']) . " - " . h($row['course_name']); ?>
              </option>
            <?php endwhile; ?>
          </select>
        </dd>
      </dl>
      </div>
      <div class="form-row">
      <dl>
        <dt>First name</dt>
        <dd><input type="text" name="first_name" value="<?php echo h($user['first_name'] ?? ''); ?>" /></dd>
      </dl>
      </div>
      <div class="form-row">
      <dl>
        <dt>Last name</dt>
        <dd><input type="text" name="last_name" value="<?php echo h($user['last_name'] ?? ''); ?>" /></dd>
      </dl>
      </div>
      <div class="form-row">
      <dl>
        <dt>Start date</dt>
        <dd><input type="date" name="user_start_date" value="<?php echo h($user['user_start_date'] ?? ''); ?>" /></dd>
      </dl>
      </div>
      <div class="form-row">
      <dl>
        <dt>End date</dt>
        <dd><input type="date" name="user_end_date" value="<?php echo h($user['user_end_date'] ?? ''); ?>" /></dd>
      </dl>
      </div>
      <div class="form-row">
      <dl>
        <dt>Email</dt>
        <dd><input type="email" name="email" value="<?php echo h($user['email'] ?? ''); ?>" /></dd>
      </dl>
      </div>
      <div id="operations">
        <input type="submit" value="Add User" />
      </div>
      
    </form>

  </div>

</div>
            </main>
<?php include(SHARED_PATH . '/admin_footer.php'); ?>