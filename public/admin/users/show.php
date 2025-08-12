<?php require_once('../../../private/init.php'); 

$id = $_GET['id'] ?? '1';
// Check if the id is set and valid
$user = find_user_by_id($id)

?>

<?php $page_title = 'Show User'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>
<main aria-label="main content">
<div id="content">

	<a class="back-link" href="<?php echo url_for('/admin/users/index.php');
	?>">← Back to List</a>
	
	<div class="user show">
	
	<!--<h2>User id: <?php echo h($user['user_id']); ?></h2>-->
	
	<div class="attributes">
	<div class="form-row">
	<dl>
	  <dt>User ID</dt>
	  <dd><?php echo h($user['user_id']); ?></dd>
	</dl>
	</div>
	<div class="form-row">
	<dl>
	  <dt>Full name</dt>
	  <dd><?php echo h($user['first_name'] . ' ' . $user['last_name']); ?></dd>
	</dl>
	</div>
	<div class="form-row">
	<dl>
	  <dt>Email</dt>
	  <dd><?php echo h($user['email']); ?></dd>
	</dl>
	</div>
	<div class="form-row">
	<dl>
	  <dt>Role</dt>
	  <dd><?php echo h($user['role']); ?></dd>
	</dl>
	</div>
	<div class="form-row">
	<dl>
	  <dt>Course</dt>
	  <dd><?php echo h($user['course_id'] . '-' . $user['course_name']); ?></dd>
	</dl>
	</div>
	<div class="form-row">
	<dl>
	  <dt>Start date</dt>
	  <dd><?php echo h($user['user_start_date']); ?></dd>
	</dl>
	</div>
	<div class="form-row">
	<dl>
	  <dt>End date</dt>
	  <dd><?php echo h($user['user_end_date']); ?></dd>
	</dl>
  </div>
	</div>
	
	
  </div>

</div>
</main>
<?php include(SHARED_PATH . '/admin_footer.php'); ?>



