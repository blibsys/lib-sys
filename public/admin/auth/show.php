<?php require_once('../../../private/init.php'); ?>

<?php

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
      <dt>Created At</dt>
      <dd><?php echo h($auth['created_at']); ?></dd>
    </dl>
</div>
    <div class="form-row">
    <dl>
      <dt>Updated At</dt>
      <dd><?php echo h($auth['updated_at']); ?></dd>
    </dl>  

  </div>
 </div>
</div>
</main>
<?php include(SHARED_PATH . '/admin_footer.php'); ?>


