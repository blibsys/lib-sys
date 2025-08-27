<?php 
require_once('../../../private/init.php'); 

if(!isset($_GET['id'])) {
	redirect_to(url_for('/admin/circulation/index.php'));
}

$id = $_GET['id'];
$circulation = find_circulation_by_id($id);
if(!$circulation) {
	redirect_to(url_for('/admin/circulation/index.php'));
}

if(is_post_request()) {
	$result = delete_circulation($id);
	if($result === true) {
		$_SESSION['message'] = 'Circulation record deleted successfully. Item is now available.';
		redirect_to(url_for('/admin/circulation/index.php'));
	} else {
		$errors = $result;
	}
}

?>

<?php $page_title = 'Delete Circulation'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<main aria-label="main content">
<div id="content">

  <a class="back-link" href="<?php echo url_for('/admin/circulation/index.php') ?>">← Back to List</a>
  
  <div class="circulation delete">
    <h2>Delete Circulation Record</h2>
    
    <?php echo display_errors($errors); ?>
    
    <p class ="delete-message">Are you sure you want to delete this circulation record?</p>
    
    <div class="circulation-details">
      <p><strong>Circulation ID:</strong> <?php echo h($circulation['circulation_id']); ?></p>
      <p><strong>User:</strong> 
        <?php 
        $user_display = $circulation['user_id'];
        if($circulation['first_name'] && $circulation['last_name']) {
            $user_display .= ' - ' . $circulation['first_name'] . ' ' . $circulation['last_name'];
            if($circulation['email']) {
                $user_display .= ' (' . $circulation['email'] . ')';
            }
        } else {
            $user_display .= ' - User details not found';
        }
        echo h($user_display); 
        ?>
      </p>
      <p><strong>Item:</strong> 
        <?php 
        $item_display = $circulation['item_id'];
        if($circulation['title']) {
            $item_display .= ' - ' . $circulation['title'];
        } else {
            $item_display .= ' - Item details not found';
        }
        echo h($item_display); 
        ?>
      </p>
      <p><strong>Borrow Date:</strong> <?php echo h($circulation['borrow_date']); ?></p>
      <?php if($circulation['date_due_back']): ?>
        <p><strong>Due Date:</strong> <?php echo h($circulation['date_due_back']); ?></p>
      <?php endif; ?>
      <?php if($circulation['returned_date']): ?>
        <p><strong>Returned Date:</strong> <?php echo h($circulation['returned_date']); ?></p>
      <?php endif; ?>
    </div>
    
    <form class="admin-form1" action="<?php echo url_for('/admin/circulation/delete.php?id=' . h(u($id))); ?>" method="post">
      <div id="operations">
        <input type="submit" value="Delete Circulation Record" />
      </div>
    </form>

  </div>

</div>
</main>

<?php include(SHARED_PATH . '/footer.php'); ?>
