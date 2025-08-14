<?php

require_once('../../../private/init.php'); 
$errors = [];

if(is_post_request()) {

    // Handle form values sent by edit/new.php

	$circulation =[];
	$circulation['user_id'] = $_POST['user_id'] ?? '';
	$circulation['item_id'] = $_POST['item_id'] ?? '';
	$circulation['borrow_date'] = $_POST['borrow_date'] ?? '';

  //the part where the circulation is added to the database if successful
	$result = insert_circulation($circulation);
  if($result === true) {
    $_SESSION['message'] = 'Circulation record added successfully.';
	$new_id = mysqli_insert_id($db);
	redirect_to(url_for('/admin/circulation/show.php?id=' . $new_id));
} else {
  $errors = $result;
}
} else {
  // display blank form
  $circulation = [];
  $circulation['user_id'] = '';
  $circulation['item_id'] = '';
  $circulation['borrow_date'] = '';
}

$circulation_set = find_all_circulation();
$circulation_count = mysqli_num_rows($circulation_set) + 1; 
mysqli_free_result($circulation_set);

?>

<?php $page_title = 'add circulation'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>

<!-- html with embedded php to display a web form for creating a new circulation -->
<!-- ("server side script for managing content") -->
<!-- need to add validation to the forms -->
<main aria-label="main content">
<div id="content">

  <a class="back-link" href="<?php echo url_for('admin/circulation/index.php'); ?>">← Back to List</a>

  <div class="circulation new">
    <h2>Add Circulation Record</h2>
    <h3>*Circulation ID is automatically generated*</h3>

     <?php echo display_errors($errors); ?>

    <form class="admin-form1" action="<?php echo url_for('/admin/circulation/new.php'); ?>" method="post">
    <div class=form-row>  
      <dl>
        <dt>User</dt>
        <dd><input type="text" name="user_id" value="<?php echo h($circulation['user_id'] ?? ''); ?>" /></dd>
      </dl>
      </div>
      <div class="form-row">
      <dl>
        <dt>Item</dt>
        <dd><input type="text" name="item_id" value="<?php echo h($circulation['item_id'] ?? ''); ?>" /></dd>
      </dl>
      </div>
      <div class="form-row">
      <dl>
        <dt>Borrow date</dt>
        <dd><input type="date" name="borrow_date" value="<?php echo h($circulation['borrow_date'] ?? ''); ?>" /></dd>
      </dl>
    </div>
    
     
        <div class="form-row">
      <div id="operations">
        <input type="submit" value="Add circulation record" />
</div>
      
    </form>

  </div>

</div>
    </main>
<?php include(SHARED_PATH . '/admin_footer.php'); ?>