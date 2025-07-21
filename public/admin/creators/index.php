<?php require_once('../../../private/initialise.php'); ?>

<?php $creator_set = find_all_creators(); ?>

<?php $page_title = 'creators'; ?>

<?php include(SHARED_PATH . '/admin_header.php'); ?>

<div id="content">
  <div class="creators listing">
    <h1>Creators</h1>

    <div class="back-link-wrapper">
      <a class="back-link" href="<?php echo url_for('admin/index.php'); ?>">&laquo; Back to List</a>
    </div>
    
    <div class="actions">
      <a class="action" href="<?php echo url_for('/admin/creators/new.php'); ?>">Add New Creator</a>
    </div>
    
    <table class = "list">
      <tr>  
        <th>creator_id</th>
        <th>creator_name</th>
  	    <th>&nbsp;</th>
  	    <th>&nbsp;</th>
        <th>&nbsp;</th>
  	  </tr>

      <?php while($creator = mysqli_fetch_assoc($creator_set)) { ?>
        <tr>
          <td><?php echo h($creator['creator_id']); ?></td>
          <td><?php echo h($creator['creator_name']); ?></td>
          <td><a class="action" href="<?php echo url_for('/admin/creators/show.php?Page=1&id=' . h(u($creator['creator_id'])));?>">View</a></td>
          <td><a class="action" href="<?php echo url_for('/admin/creators/edit.php?id=' . h(u($creator['creator_id']))); ?>">Edit</a></td>
          <td><a class="action" href="<?php echo url_for('/admin/creators/delete.php?id=' . h(u($creator['creator_id']))); ?>">Delete</a></td>
    	  </tr>
      <?php } ?>
  	</table>
  	
  	<!-- free up storage of $creator-set query above -->
	<?php
	mysqli_free_result($creator_set);
	?>

  </div>

</div>

<?php include(SHARED_PATH . '/admin_footer.php'); ?>
