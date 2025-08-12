<?php 
require_once('../../../private/init.php'); 

if(!isset($_GET['id'])) {
	redirect_to(url_for('/admin/circulation/index.php'));
}

$id = $_GET['id'];

if(is_post_request()) {

// Handle form values sent by new.php
		
	$circulation = [];
	$circulation['id'] = $id;
	$circulation['first_name']= $_POST['first_name'] ?? '';
	$circulation['last_name']= $_POST['last_name'] ?? '';
	$circulation['circulation_start_date']= $_POST['circulation_start_date'] ?? '';
	$circulation['circulation_end_date']= $_POST['circulation_end_date'] ?? '';
	$circulation['role']= $_POST['role'] ?? '';
	$circulation['email']= $_POST['email'] ?? '';
    $circulation['course_id']= $_POST['course_id'] ?? '';

		$result = update_circulation($circulation);
		if($result === true) {
    $_SESSION['message'] = 'circulation updated successfully.';
	    redirect_to(url_for('/admin/circulation/show.php?id=' . h(u($id))));
		} else {
		$errors = $result;
		//var_dump($errors);
	}
	    } else {	

	$circulation = find_circulation_by_id($id);
}   
?>

<?php $page_title = 'Edit Circulation'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>

<!-- html with embedded php to display a web form for editing circulation -->
<!-- ("server side script for managing content") -->
<main aria-label="main content">
<div id="content">

  <a class = "back-link" href="<?php echo url_for('/admin/circulations/index.php') ?>">← Back to List</a>
  
  <div class="circulation edit">
    <h2>Edit circulation</h2>

	<?php echo display_errors($errors); ?>

    <form calss="admin-form1" action="<?php echo url_for('/admin/circulations/edit.php?id=' . h(u($id))); ?>" method="post">
     <?php if(isset($circulation['circulation_id'])): ?>
      <div class="form-row">
      <dl>
    <dl>
        <dt>circulation ID</dt>
        <!--circulation id read only:-->
        <dd><?php echo h($circulation['circulation_id']); ?></dd>
        <?php endif; ?>
      </dl>
      </div>
      <div class="form-row">
      <dl>
        <dt>Role</dt>
        <dd>
           <dd>  
            <select name="role">
        <?php foreach ($allowed_roles as $role): ?>
       <option value="<?php echo htmlspecialchars($role); ?>"
      <?php if (isset($circulation['role']) && $circulation['role'] === $role) echo 'selected'; ?>>
      <?php echo htmlspecialchars($role); ?>
      </option>
      <?php endforeach; ?>
       </select></dd>
        </dd>
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
                <?php if (($circulation['course_id'] ?? '') == $row['course_id']) echo 'selected'; ?>>
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
        <dd><input type="text" name="first_name" value="<?php echo h($circulation['first_name']); ?>" /></dd>
      </dl>
        </div>
      <div class="form-row">
      <dl>
        <dt>Last name</dt>
        <dd><input type="text" name="last_name" value="<?php echo h($circulation['last_name']); ?>" /></dd>
      </dl>
      </div>
      <div class="form-row">
      <dl>
        <dt>Start date</dt>
        <dd><input type="date" name="circulation_start_date" value="<?php echo h($circulation['circulation_start_date']); ?>" /></dd>
      </dl>
      </div>
      <div class="form-row">
       <dl>
        <dt>End date</dt>
        <dd><input type="date" name="circulation_end_date" value="<?php echo h($circulation['circulation_end_date']); ?>" /></dd>
      </dl>
      </div>
      <div class="form-row">
      <dl>
        <dt>Email</dt>
        <dd><input type="email" name="email" value="<?php echo h($circulation['email']); ?>" /></dd>
      </dl>
      </div>

      <div id="operations">
        <input type="submit" value="Edit circulation" />
      </div>
    </form>

  </div>

</div>
            </main>
<?php include(SHARED_PATH . '/admin_footer.php'); ?>
