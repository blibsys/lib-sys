
<?php require_once('../../../private/initialise.php'); ?>

<?php

$circulation_set = find_all_circ();

?>

<?php $page_title = 'circulations'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>

<div id="content">
  <div class="circulations listing">
    <h1>Circulation</h1>

    <div class="back-link-wrapper">
      <a class="back-link" href="<?php echo url_for('admin/index.php'); ?>">&laquo; Back to List</a>
    </div>

    <div class="actions">
      <a class="action" href="<?php echo url_for('/admin/circulations/new.php'); ?>">Add New Circulation</a>
    </div>

  	<table class="list">
  	  <tr>
        <th>circulation_id</th>
        <th>user_id</th>
        <th>item_id</th>
  	    <th>borrow_date</th>
  	    <th>date_due_back</th>
        <th>returned_date</th>
        <th>next_reminder_date</th>
  	    <th>item_circulation_status</th>
  	    <th>created_at</th>
  	    <th>updated_at</th>
  	    <th>&nbsp;</th>
  	    <th>&nbsp;</th>
        <th>&nbsp;</th>
  	  </tr>

      <?php while($circulation = mysqli_fetch_assoc($circulation_set)) { ?>
        <tr>
          <td><?php echo h($circulation['circulation_id']); ?></td>
          <td><?php echo h($circulation['user_id']); ?></td>
          <td><?php echo h($circulation['item_id']);?></td>
    	  <td><?php echo h($circulation['borrow_date']); ?></td>
    	  <td><?php echo h($circulation['date_due_back']); ?></td>
          <td><?php echo h($circulation['returned_date'] ?? ''); ?></td>
          <td><?php echo h($circulation['next_reminder_date']);?></td>
          <td><?php echo h($circulation['item_circulation_status']); ?></td>
          <td><?php echo h($circulation['created_at']);?></td>
    	  <td><?php echo h($circulation['updated_at']); ?></td>
          <td><a class="action" href="<?php echo url_for('/admin/circulation/show.php?Page=1&id=' . h(u($circulation['circulation_id'])));?>">View</a></td>
          <td><a class="action" href="<?php echo url_for('/admin/circulation/edit.php?id=' . h(u($circulation['circulation_id']))); ?>"">Edit</a></td>
          <td><a class="action" href="">Delete</a></td>
    	  </tr>
      <?php } ?>
  	</table>

<!-- free up storage of $circulation-set query above -->
	<?php
	mysqli_free_result($circulation_set);
	?>

  </div>

</div>

<?php include(SHARED_PATH . '/admin_footer.php'); ?>
