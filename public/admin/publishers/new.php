 <?php

require_once('../../../private/init.php'); 

$errors = [];

if(is_post_request()) {

	$pub = [];
	$pub['publisher_name'] = $_POST['publisher_name'] ?? '';
	
	$result = insert_publisher($pub);
	if($result === true) {
    $_SESSION['message'] = 'Publisher added successfully.';
		$new_id = mysqli_insert_id($db);
		redirect_to(url_for('/admin/publishers/show.php?id=' . $new_id));
      } else {
    
        $errors = $result;        
    }	
	  } else {
		// display blank form
		$pub = [];
}
	$pub_set = find_all_pubs();
	$pub_count = mysqli_num_rows($pub_set) + 1;
	mysqli_free_result($pub_set);

	?>

<?php $page_title = 'Add Publisher'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>

<!-- html with embedded php to display a web form for creating a new publisher -->
<!-- ("server side script for managing content") -->
<main aria-label="main content">
<div id="content">

  <a class="back-link" href="<?php echo url_for('/admin/publishers/index.php'); ?>">← Back to List</a>

  <div class="publisher new">
    <h2>Add publisher</h2>
    <h3>*Publisher ID is automatically generated*</h3>
    
   <?php echo display_errors($errors);?>

    <form class="admin-form1" action="<?php echo url_for('/admin/publishers/new.php'); ?>" method="post">
    
    <dl>
        <dd><?php if(isset($pub['publisher_id'])) { echo h($pub['publisher_id']); } ?></dd>
      </dl>
    </div>
      <div class="form-row">
      <dl>
        <dt>Publisher Name</dt>
        <dd><input type="text" name="publisher_name" value="<?php echo h($pub['publisher_name'] ?? ''); ?>"" /></dd>
      </dl>
      </div>
      <div id="operations">
        <input type="submit" value="Add Publisher" />
      </div>
    </form>

  </div>

</div>
</main>
<?php include(SHARED_PATH . '/admin_footer.php'); ?>


