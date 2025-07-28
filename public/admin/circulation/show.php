<?php require_once('../../../private/initialise.php'); ?>

<?php

$id = $_GET['id'] ?? '1';

$circ = find_circ_by_id($id);

?>

<?php $page_title = 'Show Loans'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>

<main aria-label="main content">
<div id="content">

	<a class="back-link" href="<?php echo url_for('/admin/circulation/index.php');?>">&laquo; Back to List</a>
	
	<div class="circulation show">
	
	  <h1>Circulation ID: <?php echo h($circ['circulation_id']); ?></h1>
	  
	  <div class="attributes" >
	  <dl>
	    <dt>User</dt>
	    <dd><?php echo h($circ['user_id'] . ' - ' . $circ['first_name'] . ' ' . $circ['last_name'] . ' (' . $circ['email'] . ')'); ?></dd>
	  </dl>
	  <dl>
	    <dt>Item</dt>
	    <dd><?php echo h($circ['item_id'] . ' - ' . $circ['title']); ?></dd>
	  </dl>
	  <dl>
	    <dt>Status</dt>
	    <dd><?php echo h($circ['item_circulation_status']); ?></dd>
	  </dl>
	  <dl>
	    <dt>Borrow date</dt>
	    <dd><?php echo h($circ['borrow_date']); ?></dd>
	  </dl>
	  <dl>
	    <dt>Date due back</dt>
	    <dd><?php echo h($circ['date_due_back']); ?></dd>
	  </dl>
	  <dl>
	    <dt>Returned date</dt>
	    <dd><?php echo h($circ['returned_date'] ?? 'NULL'); ?></dd>
	  </dl>
	  <dl>
	    <dt>Next reminder</dt>
	    <dd><?php echo h($circ['next_reminder_date']); ?></dd>
	  </dl>
	  <dl>
	    <dt>Created</dt>
	    <dd><?php echo h($circ['created_at']); ?></dd>
	  </dl>
	  <dl>
	    <dt>Updated</dt>
	    <dd><?php echo h($circ['updated_at']); ?></dd>
	  </dl>
	 </div>	
	</div>
   </div>
</main>
<?php include(SHARED_PATH . '/admin_footer.php'); ?>

