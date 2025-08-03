 <?php

require_once('../../../private/init.php');

if(is_post_request()) {

    // Handle form values sent by edit/new.php

	$creator = [];
	$creator['creator_id'] = $_POST['creator_id'] ?? '';
	$creator['creator_name'] = $_POST['creator_name'] ?? '';
	
	$result = insert_creator($creator);
	if($result === true) {
    $_SESSION['message'] = 'Creator added successfully.';
	$new_id = mysqli_insert_id($db);
	redirect_to(url_for('admin/creators/show.php?id=' . $creator['creator_id']));
	
	} else {
  	$errors = $result;
  }
  	} else {
  	  // display blank form
  }
  	$creator_set = find_all_creators();
	$creator_count = mysqli_num_rows($creator_set) + 1;
	mysqli_free_result($creator_set);

	//$creator = [];
	?>

<?php $page_title = 'Add creator'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>

<!-- html with embedded php to display a web form for creating a new creator -->
<!-- ("server side script for managing content") -->
<main aria-label="main content">
<div id="content">

  <a class="back-link" href="<?php echo url_for('/admin/creators/index.php'); ?>">← Back to List</a>

  <div class="creator new">
    <h2>Add Creator</h2>
    
    <?php echo display_errors($errors);?>

    <form class="admin-form1" action="<?php echo url_for('/admin/creators/new.php'); ?>" method="post">
      <div class="form-row">
      <dl>
        <dt>Creator ID</dt>
        <dd><input type="text" name="creator_id" value="<?php echo h($creator['creator_id'] ?? ''); ?>" /></dd>
      </dl>
      </div>
      <div class="form-row">
      <dl>
        <dt>Creator Name</dt>
        <dd><input type="text" name="creator_name" value="<?php echo h($creator['creator_name'] ?? ''); ?>" /></dd>
      </dl>
      </div>
    
      <div id="operations">
        <input type="submit" value="Add Creator" />
      </div>
    </form>

  </div>

</div>
</main>
<?php include(SHARED_PATH . '/admin_footer.php'); ?>


