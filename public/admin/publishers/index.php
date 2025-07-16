
<?php require_once('../../../private/initialise.php'); ?>

<?php

$item_set = find_all_items();

?>

<?php $page_title = 'items'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>

<div id="content">
  <div class="items listing">
    <h1>Items</h1>

    <div class="back-link-wrapper">
      <a class="back-link" href="<?php echo url_for('admin/index.php'); ?>">&laquo; Back to List</a>
    </div>

    <div class="actions">
      <a class="action" href="<?php echo url_for('/admin/items/new.php'); ?>">Create New item</a>
    </div>

  	<table class="list">
  	  <tr>
        <th>item_id</th>
        <th>title</th>
        <th>item_edition</th>
  	    <th>isbn</th>
  	    <th>item_type</th>
        <th>publication_year</th>
        <th>item_copy</th>
  	    <th>publisher_id</th>
  	    <th>category</th>
  	    <th>items_status</th>
  	    <th>created_at</th>
  	    <th>updated_at</th>
  	    <th>&nbsp;</th>
  	    <th>&nbsp;</th>
        <th>&nbsp;</th>
  	  </tr>

      <?php while($item = mysqli_fetch_assoc($item_set)) { ?>
        <tr>
          <td><?php echo h($item['item_id']); ?></td>
          <td><?php echo h($item['title']); ?></td>
          <td><?php echo h($item['item_edition']);?></td>
    	  <td><?php echo h($item['isbn']); ?></td>
    	  <td><?php echo h($item['item_type']); ?></td>
          <td><?php echo h($item['publication_year']); ?></td>
          <td><?php echo h($item['item_copy']);?></td>
    	  <td><?php echo h($item['publisher_id']); ?></td>
    	  <td><?php echo h($item['category']); ?></td>
          <td><?php echo h($item['item_status']); ?></td>
          <td><?php echo h($item['created_at']);?></td>
    	  <td><?php echo h($item['updated_at']); ?></td>
          <td><a class="action" href="<?php echo url_for('/admin/items/show.php?Page=1&id=' . h(u($item['item_id'])));?>">View</a></td>
          <td><a class="action" href="<?php echo url_for('/admin/items/edit.php?id=' . h(u($item['item_id']))); ?>"">Edit</a></td>
          <td><a class="action" href="">Delete</a></td>
    	  </tr>
      <?php } ?>
  	</table>

<!-- free up storage of $item-set query above -->
	<?php
	mysqli_free_result($item_set);
	?>

  </div>

</div>

<?php include(SHARED_PATH . '/admin_footer.php'); ?>
