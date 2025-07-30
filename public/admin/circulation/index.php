
<?php require_once('../../../private/initialise.php'); ?>

<?php

$circulation_set = find_all_circ();

?>

<?php $page_title = 'circulation'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>

<main aria-label="main content">
<div id="content">
  <div class="circulation listing">
    <h1>Circulation</h1>

    <div class="back-link-wrapper">
      <a class="back-link" href="<?php echo url_for('admin/index.php'); ?>">← Back to List</a>
    </div>

    <div class="actions">
      <!--<a class="action1" href="<?php echo url_for('/admin/circulation/new.php'); ?>">Add New Circulation</a>-->
    </div>

  	<table class="list">
  	  <tr>
        <th>ID</th>
        <th>User ID</th>
        <th>Item ID</th>
  	    <th>Borrow date</th>
  	    <th>Date due back</th>
        <th>Returned date</th>
        <th>Next reminder date</th>
  	    <th>Status</th>
  	    <th>Created</th>
  	    <th>Updated</th>
  	    <th>&nbsp;</th>
  	    <th>&nbsp;</th>
        <th>&nbsp;</th>
  	  </tr>

      <?php while($circ = mysqli_fetch_assoc($circulation_set)) { ?>
        <tr>
          <td><?php echo h($circ['circulation_id']); ?></td>
          <td><?php echo h($circ['user_id']); ?></td>
          <td><?php echo h($circ['item_id']);?></td>
    	  <td><?php echo h($circ['borrow_date']); ?></td>
    	  <td><?php echo h($circ['date_due_back']); ?></td>
          <td><?php echo h($circ['returned_date'] ?? ''); ?></td>
          <td><?php echo h($circ['next_reminder_date']);?></td>
          <td><?php echo h($circ['item_circulation_status']); ?></td>
          <td><?php echo h($circ['created_at']);?></td>
    	  <td><?php echo h($circ['updated_at']); ?></td>
          <td><a class="action2" href="<?php echo url_for('/admin/circulation/show.php?Page=1&id=' . h(u($circ['circulation_id'])));?>">View</a></td>
          <td><a class="action2" href="<?php echo url_for('/admin/circulation/edit.php?id=' . h(u($circ['circulation_id']))); ?>"">Edit</a></td>
          <td><a class="action2" href="">Delete</a></td>
    	  </tr>
      <?php } ?>
  	</table>

<!-- free up storage of $circulation-set query above -->
	<?php
	mysqli_free_result($circulation_set);
	?>

  </div>

  </div>
 </main>
<?php include(SHARED_PATH . '/admin_footer.php'); ?>
