<?php
require_once('../../../private/init.php'); 

if(!isset($_GET['id'])) {
	redirect_to(url_for('/admin/auth/index.php'));
}

$id = $_GET['id'];

if(is_post_request()) {
		
	$auth = [];
	$auth['auth_id'] = $id;
  $auth['user_id'] = $_POST['user_id'] ?? '';
	$auth['username']= $_POST['username'] ?? '';
	$auth['hashed_password']= $_POST['hashed_password'] ?? '';
	
	$result = update_auth($auth);
  if($result === true) {
    $_SESSION['message'] = 'User credentials updated successfully.';
	  redirect_to(url_for('admin/auth/show.php?id=' . h(u($id))));
  } else {
	$errors = $result;
  //var_dump($errors);
  } 
  } else {

	$auth = find_auth_by_id($id);

  }   
  
?>

	<?php $page_title = 'Edit auth'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>
<main aria-label="main content">
<div id="content">

  <a class="back-link" href="<?php echo url_for('admin/auth/index.php'); ?>">← Back to List</a>
  
  <div class="auth edit">
    <h2>Edit User Credentials</h2>

    	<?php echo display_errors($errors); ?>

    <form class="admin-form1" action="<?php echo url_for('/admin/auth/edit.php?id=' . h(u($id))); ?>" method="post">
     <?php if(isset($auth['auth_id'])): ?>
      <div class="form-row">
    <dl>
        <dt>Authentication ID</dt>
        <!--auth id read only:-->
        <dd><?php echo h($auth['auth_id']); ?></dd>
        </dl>
      </div>
        <?php endif; ?>
      <div class="form-row">
      <dl>
        <dt>User ID</dt>
        <dd><input type="text" name="user_id" value="<?php echo h($auth['user_id']); ?>" /></dd>
      </dl>
      </div>
      <div class="form-row"> 
       <dl>
        <dt>Username</dt>
        <dd><input type="text" name="username" value="<?php echo h($auth['username']); ?>" /></dd>
      </dl>
      </div>
      <div class="form-row">
      <dl>
        <dt>Hashed password</dt>
        <dd><input type="text" name="hashed_password" value="<?php echo h($auth['hashed_password']); ?>" /></dd>
      </dl>
      </div>
        <div id="operations">
        <input type="submit" value="Edit User Credentials" />
      </div>
    
    </form>

  </div>

</div>
    </main>
<?php include(SHARED_PATH . '/admin_footer.php'); ?>
