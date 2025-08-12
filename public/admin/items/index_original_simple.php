<?php require_once('../../../private/init.php'); 

$item_set = find_all_items();

?>

<?php $page_title = 'items'; ?>

<?php include(SHARED_PATH . '/admin_header.php'); ?>
<main aria-label="main content">
<div id="content">
  <div class="items listing">
    <h1>Items</h1>

    <div class="back-link-wrapper">
      <a class="back-link" href="<?php echo url_for('admin/index.php'); ?>">← Back to List</a>
    </div>

    <div class="actions">
      <a class="action1" href="<?php echo url_for('/admin/items/new.php'); ?>">Add New Item</a>
    </div>

  	<table class="list">
  	  <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Edition</th>
  	    <th>ISBN</th>
  	    <th>Type</th>
        <th>Publication year</th>
        <th>Copy</th>
  	    <th>Publisher ID</th>
  	    <th>Category</th>
  	    <th>Status</th>
  	    <th>Created</th>
  	    <th>Updated</th>
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
          <td><a class="action2" href="<?php echo url_for('/admin/items/show.php?Page=1&id=' . h(u($item['item_id'])));?>">View</a></td>
          <td><a class="action2" href="<?php echo url_for('/admin/items/edit.php?id=' . h(u($item['item_id']))); ?>">Edit</a></td>
          <td><a class="action2" href="<?php echo url_for('/admin/items/delete.php?id=' . h(u($item['item_id']))); ?>">Delete</a></td>
    	  </tr>
      <?php } ?>
  	</table>

<!-- free up storage of $item-set query above -->
	<?php
	mysqli_free_result($item_set);
	?>

  </div>

</div>
      </main>
<?php include(SHARED_PATH . '/admin_header.php'); ?>
