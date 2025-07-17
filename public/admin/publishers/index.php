
<?php require_once('../../../private/initialise.php'); ?>

<?php $publisher_set = find_all_pubs(); ?>

<?php $page_title = 'publishers'; ?>

<?php include(SHARED_PATH . '/admin_header.php'); ?>

<div id="content">
  <div class="publishers listing">
    <h1>Items</h1>

    <div class="back-link-wrapper">
      <a class="back-link" href="<?php echo url_for('admin/index.php'); ?>">&laquo; Back to List</a>
    </div>

    <div class="actions">
      <a class="action" href="<?php echo url_for('/admin/publishers/new.php'); ?>">Add New publisher</a>
    </div>
      
    <table class = "list">
      <tr>  
        <th>publisher_id</th>
        <th>publisher_name</th>
  	    <th>&nbsp;</th>
  	    <th>&nbsp;</th>
        <th>&nbsp;</th>
  	  </tr>

      <?php while($publisher = mysqli_fetch_assoc($publisher_set)) { ?>
        <tr>
          <td><?php echo h($publisher['publisher_id']); ?></td>
          <td><?php echo h($publisher['publisher_name']); ?></td>
          <td><a class="action" href="<?php echo url_for('/admin/publishers/show.php?Page=1&id=' . h(u($publisher['publisher_id'])));?>">View</a></td>
          <td><a class="action" href="<?php echo url_for('/admin/publishers/edit.php?id=' . h(u($publisher['publisher_id']))); ?>"">Edit</a></td>
          <td><a class="action" href="">Delete</a></td>
    	  </tr>
      <?php } ?>
  	</table>

<!-- free up storage of $publisher-set query above -->
	<?php
	mysqli_free_result($publisher_set);
	?>

  </div>

</div>

<?php include(SHARED_PATH . '/admin_footer.php'); ?>
