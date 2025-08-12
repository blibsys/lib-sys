 <?php

require_once('../../../private/init.php');

if(is_post_request()) {

    // Handle form values sent by edit/new.php

	$contributor = [];
	$contributor['contributor_id'] = $_POST['contributor_id'] ?? '';
	$contributor['contributor_name'] = $_POST['contributor_name'] ?? '';
	
	$result = insert_contributor($contributor);
	if($result === true) {
    $_SESSION['message'] = 'contributor added successfully.';
	$new_id = mysqli_insert_id($db);
	redirect_to(url_for('admin/contributors/show.php?id=' . $contributor['contributor_id']));
	
	} else {
  	$errors = $result;
  }
  	} else {
  	  // display blank form
  }
  	$contributor_set = find_all_contributors();
	$contributor_count = mysqli_num_rows($contributor_set) + 1;
	mysqli_free_result($contributor_set);

	//$contributor = [];
	?>

<?php $page_title = 'Add contributor'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>

<!-- html with embedded php to display a web form for creating a new contributor -->
<!-- ("server side script for managing content") -->
<main aria-label="main content">
<div id="content">

  <a class="back-link" href="<?php echo url_for('/admin/contributors/index.php'); ?>">← Back to List</a>

  <div class="contributor new">
    <h2>Add Contributor</h2>
    
    <?php echo display_errors($errors);?>

    <form class="admin-form1" action="<?php echo url_for('/admin/contributors/new.php'); ?>" method="post">
      <div class="form-row">
      <dl>
        <dt>contributor ID</dt>
        <dd><input type="text" name="contributor_id" value="<?php echo h($contributor['contributor_id'] ?? ''); ?>" /></dd>
      </dl>
      </div>
      <div class="form-row">
      <dl>
        <dt>contributor Name</dt>
        <dd><input type="text" name="contributor_name" value="<?php echo h($contributor['contributor_name'] ?? ''); ?>" /></dd>
      </dl>
      </div>
    
      <div id="operations">
        <input type="submit" value="Add Contributor" />
      </div>
    </form>

  </div>

</div>
</main>
<?php include(SHARED_PATH . '/admin_footer.php'); ?>


