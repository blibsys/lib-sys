<?php require_once('../../../private/initialise.php'); ?>

<?php $itemcreator_set = find_all_itemcreators(); ?>

<?php $page_title = 'item creators'; ?>

<?php include(SHARED_PATH . '/admin_header.php'); ?>

<div id="content">
  <div class="item creators listing">
    <h1>Item Creators</h1>

    <div class="back-link-wrapper">
      <a class="back-link" href="<?php echo url_for('admin/index.php'); ?>">&laquo; Back to List</a>
    </div>
    
    <div class="actions">
      <a class="action" href="<?php echo url_for('/admin/itemcreators/new.php'); ?>">Add New ItemCreator</a>
    </div>
    
    <table class = "list">
      <tr>  
        <th>item_id</th>
        <th>creator_id</th>
  	    <th>&nbsp;</th>
  	    <th>&nbsp;</th>
        <th>&nbsp;</th>
  	  </tr>

      <?php while($icreator = mysqli_fetch_assoc($itemcreator_set)) { ?>
        <tr>
          <td><?php echo h($icreator['item_id']); ?></td>
          <td><?php echo h($icreator['creator_id']); ?></td>
          <td><a class="action" href="<?php echo url_for('/admin/itemcreators/show.php?id=' . h(u($icreator['item_id']))); ?>">View</a></td>
          <td><a class="action" href="<?php echo url_for('/admin/itemcreators/edit.php?id=' . h(u($icreator['item_id']))); ?>"">Edit</a></td>
          <td><a class="action" href="">Delete</a></td>
    	  </tr>
      <?php } ?>
  	</table>
  	
  	<!-- free up storage of $creator-set query above -->
	<?php
	mysqli_free_result($itemcreator_set);
	?>

  </div>

</div>

<?php include(SHARED_PATH . '/admin_footer.php'); ?>
