<?php require_once('../../../private/init.php');

$id = $_GET['id'] ?? '1';

$auth = find_auth_by_id($id);

?>

<?php $page_title = 'Show Credentials'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>

<main aria-label="main content">
<div id="content">

	<a class="back-link" href="<?php echo url_for('/admin/auth/index.php'); ?>">← Back to List</a>
	
	<div class="credentials show">
	
	<div class="attributes">

	<div class="form-row">
	<dl>
	  <dt>Athentication ID</dt>
	  <dd><?php echo h($auth['auth_id']); ?></dd>
	</dl>
	</div>
	<div class="form-row">
	<dl>
	  <dt>User ID</dt>
	  <dd><?php echo h($auth['user_id']); ?></dd>
	</dl>
   </div>
    <div class="form-row">
	<dl>
	  <dt>Username</dt>
      <dd><?php echo h($auth['username']); ?></dd>
    </dl>
    </div>
  <div class="form-row">
	<dl>
	  <dt>First name</dt>
      <dd><?php echo h($auth['first_name']); ?></dd>
    </dl>
    </div>
<div class="form-row">
	<dl>
	  <dt>Last name</dt>
      <dd><?php echo h($auth['last_name']); ?></dd>
    </dl>
    </div>
    <div class="form-row">
	<dl>
	  <dt>Role</dt>
      <dd><?php echo h($auth['role']); ?></dd>
    </dl>
    </div>
<div class="form-row">
	<dl>
	  <dt>Email</dt>
      <dd><?php echo h($auth['email']); ?></dd>
    </dl>
    </div>
   

  </div>
 </div>
</div>
</main>
<?php include(SHARED_PATH . '/admin_footer.php'); ?>


