
<?php require_once('../../../private/init.php');

$publisher_set = find_all_pubs(); ?>

<?php $page_title = 'publishers'; ?>

<?php include(SHARED_PATH . '/admin_header.php'); ?>
<main aria-label="main content">
<div id="content">
  <div class="publishers listing">
    <h1>Publishers</h1>

    <div class="back-link-wrapper">
      <a class="back-link" href="<?php echo url_for('admin/index.php'); ?>">← Back to List</a>
    </div>

    <div class="actions">
      <a class="action1" href="<?php echo url_for('/admin/publishers/new.php'); ?>">Add New publisher</a>
    </div>
      
    <table class = "list">
      <tr>  
        <th>ID</th>
        <th>Name</th>
  	    <th>&nbsp;</th>
  	    <th>&nbsp;</th>
        <th>&nbsp;</th>
  	  </tr>

      <?php while($pub = mysqli_fetch_assoc($publisher_set)) { ?>
        <tr>
          <td><?php echo h($pub['publisher_id']); ?></td>
          <td><?php echo h($pub['publisher_name']); ?></td>
          <td><a class="action2" href="<?php echo url_for('/admin/publishers/show.php?Page=1&id=' . h(u($pub['publisher_id'])));?>">View</a></td>
          <td><a class="action2" href="<?php echo url_for('/admin/publishers/edit.php?id=' . h(u($pub['publisher_id']))); ?>">Edit</a></td>
          <td><a class="action2" href="<?php echo url_for('/admin/publishers/delete.php?id=' . h(u($pub['publisher_id']))); ?>">Delete</a></td>
    	  </tr>
      <?php } ?>
  	</table>

<!-- free up storage of $publisher-set query above -->
	<?php
	mysqli_free_result($publisher_set);
	?>

  </div>

</div>
      </main>
<?php include(SHARED_PATH . '/admin_footer.php'); ?>
