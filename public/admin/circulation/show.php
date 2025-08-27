<?php require_once('../../../private/init.php');

$id = $_GET['id'] ?? '1';

$circulation = find_circulation_by_id($id);

?>

<?php $page_title = 'Show Loans'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<main aria-label="main content">
<div id="content">

	<a class="back-link" href="<?php echo url_for('/admin/circulation/index.php');?>">← Back to List</a>
	
	<div class="circulation show">
	
	  <h2>Circulation Record Detail</h2>
	  
	  <div class="attributes" >

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
	    <dt>Status</dt>
	    <dd><?php echo h($circulation['item_circulation_status']); ?></dd>
	  </dl>
	  </div>
	  <div class="form-row">
	  <dl>
	    <dt>Borrow date</dt>
	    <dd><?php echo h($circulation['borrow_date']); ?></dd>
	  </dl>
	  </div>
	  <div class="form-row">
	  <dl>
	    <dt>Date due back</dt>
	    <dd><?php echo h($circulation['date_due_back']); ?></dd>
	  </dl>
	  </div>
	  <div class="form-row">	
	  <dl>
	    <dt>Returned date</dt>
	    <dd><?php echo h($circulation['returned_date'] ?? 'NULL'); ?></dd>
	  </dl>
	  </div>
	  <div class="form-row">
	  <dl>
	    <dt>Next reminder</dt>
	    <dd><?php echo h($circulation['next_reminder_date']); ?></dd>
	  </dl>
	  </div>
	 
	 </div>	
	</div>
   </div>
</main>
<?php include(SHARED_PATH . '/footer.php'); ?>

