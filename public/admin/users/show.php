<?php require_once('../../../private/initialise.php'); ?>

<?php

$id = $_GET['id'] ?? '1';

$user = find_user_by_id($id)

?>

<?php $page_title = 'Show User'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>

<div id="content">

	<a class="back-link" href="<?php echo url_for('/admin/items/index.php');
	?>">&laquo; Back to List</a>
	
	<div class="user show">
	
	<!--<h1>User id: <?php echo h($user['user_id']); ?></h1>-->
	
	<div class="attributes" >
	<dl>
	  <dt>User id</dt>
	  <dd><?php echo h($user['user_id']); ?></dd>
	</dl>
	<dl>
	  <dt>Full name</dt>
	  <dd><?php echo h($user['first_name'] . ' ' . $user['last_name']); ?></dd>
	</dl>
	<dl>
	  <dt>Email</dt>
	  <dd><?php echo h($user['email']); ?></dd>
	</dl>
	<dl>
	  <dt>Type</dt>
	  <dd><?php echo h($user['user_type']); ?></dd>
	</dl>
	<dl>
	  <dt>Course</dt>
	  <dd><?php echo h($user['course_id'] . '-' . $user['course_name']); ?></dd>
	</dl>
	<dl>
	  <dt>Start date</dt>
	  <dd><?php echo h($user['user_start_date']); ?></dd>
	</dl>
	<dl>
	  <dt>End date</dt>
	  <dd><?php echo h($user['user_end_date']); ?></dd>
	</dl>
	</div>
	
	
  </div>

</div>

<?php include(SHARED_PATH . '/admin_footer.php'); ?>



