<?php 
require_once('../../../private/initialise.php'); 

if(!isset($_GET['id'])) {
	redirect_to(url_for('/admin/users/index.php'));
}

$id = $_GET['id'];

if(is_post_request()) {

// Handle form values sent by new.php
		
	$user = [];
	$user['id'] = $id;
	$user['first_name']= $_POST['first_name'] ?? '';
	$user['last_name']= $_POST['last_name'] ?? '';
	$user['user_start_date']= $_POST['user_start_date'] ?? '';
	$user['user_end_date']= $_POST['user_end_date'] ?? '';
	$user['user_type']= $_POST['user_type'] ?? '';
	$user['email']= $_POST['email'] ?? '';
  $user['course_id']= $_POST['course_id'] ?? '';

		$result = update_user($user);
		if($result === true) {
	    redirect_to(url_for('/admin/users/show.php?id=' . h(u($id))));
		} else {
		$errors = $result;
		//var_dump($errors);
	}
	    } else {	

	$user = find_user_by_id($id);
}   
?>

<?php $page_title = 'Edit User'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>

<!-- html with embedded php to display a web form for editing user -->
<!-- ("server side script for managing content") -->
<main aria-label="main content">
<div id="content">

  <a class = "back-link" href="<?php echo url_for('/admin/users/index.php') ?>">&laquo; Back to List</a>
  
  <div class="user edit">
    <h1>Edit User</h1>

	<?php echo display_errors($errors); ?>

    <form action="<?php echo url_for('/admin/users/edit.php?id=' . h(u($id))); ?>" method="post">
     <?php if(isset($user['user_id'])): ?>
    <dl>
        <dt>User id</dt>
        <!--user id read only:-->
        <dd><?php echo h($user['user_id']); ?></dd>
        <?php endif; ?>
      </dl>
      <dl>
        <dt>User type</dt>
        <dd>
          <select name="user_type" id="user_type">
        <option value="student" <?php if(($user['user_type'] ?? '') == 'student') echo 'selected'; ?>>Student</option>
        <option value="staff" <?php if(($user['user_type'] ?? '') == 'staff') echo 'selected'; ?>>Staff</option>
        <option value="guest" <?php if(($user['user_type'] ?? '') == 'guest') echo 'selected'; ?>>Guest</option>
        <option value="admin" <?php if(($user['user_type'] ?? '') == 'admin') echo 'selected'; ?>>Admin</option>
        <option value="other" <?php if(($user['user_type'] ?? '') == 'other') echo 'selected'; ?>>Other</option>
          </select>
        </dd>
      </dl>
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
      <dl>
        <dt>First name</dt>
        <dd><input type="text" name="first_name" value="<?php echo h($user['first_name']); ?>" /></dd>
      </dl>
      <dl>
        <dt>Last name</dt>
        <dd><input type="text" name="last_name" value="<?php echo h($user['last_name']); ?>" /></dd>
      </dl>
      <dl>
        <dt>Start date</dt>
        <dd><input type="date" name="user_start_date" value="<?php echo h($user['user_start_date']); ?>" /></dd>
      </dl>
       <dl>
        <dt>End date</dt>
        <dd><input type="date" name="user_end_date" value="<?php echo h($user['user_end_date']); ?>" /></dd>
      </dl>
      <dl>
        <dt>Email</dt>
        <dd><input type="email" name="email" value="<?php echo h($user['email']); ?>" /></dd>
      </dl>
      <div id="operations">
        <input type="submit" value="Edit User" />
      </div>
    </form>

  </div>

</div>
            </main>
<?php include(SHARED_PATH . '/admin_footer.php'); ?>
