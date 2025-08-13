<?php 
require_once('../../../private/init.php'); 

if(!isset($_GET['id'])) {
	redirect_to(url_for('/admin/circulation/index.php'));
}

$id = $_GET['id'];

// Always get the full circulation data first
$circulation = find_circulation_by_id($id);

if(is_post_request()) {

// Handle form values sent by new.php
// Update only the editable fields while preserving the full circulation data
	$circulation['borrow_date']= $_POST['borrow_date'] ?? '';
	$circulation['date_due_back']= $_POST['date_due_back'] ?? '';
	$circulation['returned_date']= $_POST['returned_date'] ?? '';

		$result = update_circulation($circulation);
		if($result === true) {
    $_SESSION['message'] = 'circulation updated successfully.';
	    redirect_to(url_for('/admin/circulation/show.php?id=' . h(u($id))));
		} else {
		$errors = $result;
		//var_dump($errors);
	}
}   
?>

<?php $page_title = 'Edit Circulation'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>

<!-- html with embedded php to display a web form for editing circulation -->
<!-- ("server side script for managing content") -->
<main aria-label="main content">
<div id="content">

  <a class = "back-link" href="<?php echo url_for('/admin/circulation/index.php') ?>">← Back to List</a>
  
  <div class="circulation edit">
    <h2>Edit Circulation Record</h2>

	<?php echo display_errors($errors); ?>

    <form class="admin-form1" action="<?php echo url_for('/admin/circulation/edit.php?id=' . h(u($id))); ?>" method="post">
     <?php if(isset($circulation['circulation_id'])): ?>
        <?php endif; ?>
      </dl>
      </div>
      
      <!--circulation id, item and user details read only:-->
      <div class="form-row">
      <dl>
        <dt>Circulation ID</dt>
        <dd><?php echo h($circulation['circulation_id']); ?></dd>
      </dl>
        </div>
      <div class="form-row">
	  <dl>
	    <dt>User</dt>
	    <dd><?php echo h($circulation['user_id'] . ' - ' . $circulation['first_name'] . ' ' . $circulation['last_name'] . ' (' . $circulation['email'] . ')'); ?></dd>
	  </dl>
	  </div>
	  <div class="form-row">
	  <dl>
	    <dt>Item</dt>
	    <dd><?php echo h($circulation['item_id'] . ' - ' . $circulation['title']); ?></dd>
	  </dl>
	  </div>
      <div class="form-row">
      <dl>
        <dt>Date borrowed</dt>
        <dd><input type="date" name="borrow_date" value="<?php echo h($circulation['borrow_date']); ?>" /></dd>
      </dl>
        </div>
      <div class="form-row">
      <dl>
        <dt>Due date</dt>
        <dd><input type="date" name="date_due_back" value="<?php echo h($circulation['date_due_back']); ?>" /></dd>
      </dl>
      </div>
      <div class="form-row">
      <dl>
        <dt>Returned date</dt>
        <dd><input type="date" name="returned_date" value="<?php echo h($circulation['returned_date']); ?>" /></dd>
      </dl>
      </div>
      <!--<div class="form-row">
      <dl>
        <dt>Status</dt>
        <dd><input type="text" name="status" value="<?php echo h($circulation['status']); ?>" /></dd>
      </dl>
      </div>-->

      <div id="operations">
        <input type="submit" value="Edit Circulation" />
      </div>
    </form>

  </div>

</div>
            </main>
<?php include(SHARED_PATH . '/admin_footer.php'); ?>
