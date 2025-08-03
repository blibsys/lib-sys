<?php

require_once('../../../private/init.php'); 
$errors = [];

if(is_post_request()) {

    // Handle form values sent by edit/new.php

	$item =[];
	$item['title'] = $_POST['title'] ?? '';
	$item['item_edition'] = $_POST['item_edition'] ?? '';
	$item['isbn'] = $_POST['isbn'] ?? '';
	$item['item_type'] = $_POST['item_type'] ?? '';
	$item['publication_year'] = $_POST['publication_year'] ?? '';
	$item['item_copy'] = $_POST['item_copy'] ?? '';
	$item['publisher_id'] = $_POST['publisher_id'] ?? '';
	$item['category'] = $_POST['category'] ?? '';
	$item['item_status'] = $_POST['item_status'] ?? '';

  //the part where the item is added to the database if successful
	$result = insert_item($item);
  if($result === true) {
    $_SESSION['message'] = 'Item added successfully.';
	$new_id = mysqli_insert_id($db);
	redirect_to(url_for('/admin/items/show.php?id=' . $new_id));
} else {
  $errors = $result;
}
} else {
  // display blank form
}
$item_set = find_all_items();
$item_count = mysqli_num_rows($item_set) + 1; 
mysqli_free_result($item_set);

?>

<?php $page_title = 'Add item'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>

<!-- html with embedded php to display a web form for creating a new item -->
<!-- ("server side script for managing content") -->
<!-- need to add validation to the forms -->
<main aria-label="main content">
<div id="content">

  <a class="back-link" href="<?php echo url_for('admin/items/index.php'); ?>">← Back to List</a>

  <div class="item new">
    <h2>Add Item</h2>
    <h3>*Item ID is automatically generated*</h3>

     <?php echo display_errors($errors); ?>

    <form class="admin-form1" action="<?php echo url_for('/admin/items/new.php'); ?>" method="post">
    <div class=form-row>  
      <dl>
        <dt>Title</dt>
        <dd><input type="text" name="title" value="<?php echo h($item['title'] ?? ''); ?>" /></dd>
      </dl>
      </div>
      <div class="form-row">
       <dl>
        <dt>Item Type</dt>
        <dd>
          <select name="item_type" id="item_type">
        <option value="book" <?php if(($item['item_type'] ?? '') == 'book') echo 'selected'; ?>>Book</option>
        <option value="journal" <?php if(($item['item_type'] ?? '') == 'journal') echo 'selected'; ?>>Journal</option>
        <option value="programme" <?php if(($item['item_type'] ?? '') == 'programme') echo 'selected'; ?>>Programme</option>
        <option value="dvd" <?php if(($item['item_type'] ?? '') == 'dvd') echo 'selected'; ?>>DVD</option>
        <option value="other" <?php if(($item['item_type'] ?? '') == 'other') echo 'selected'; ?>>Other</option>
          </select>
        </dd>
      </dl>
      </div>
      <div class="form-row">
      <dl>
        <dt>Status</dt>
        <dd>
          <select name="item_status" id="item_status">
        <option value="available" <?php if(($item['item_status'] ?? '') == 'available') echo 'selected'; ?>>Available</option>
        <option value="on loan" <?php if(($item['item_status'] ?? '') == 'on-loan') echo 'selected'; ?>>On-loan</option>
        <option value="missing" <?php if(($item['item_status'] ?? '') == 'missing') echo 'selected'; ?>>Missing</option>
          </select>
        </dd>
      </dl>
      </div>
      <div class="form-row">
      <dl>
        <dt>ISBN</dt>
        <dd><input type="text" name="isbn" value="<?php echo h($item['isbn'] ?? ''); ?>" /></dd>
      </dl>
      </div>
      <div class="form-row">
      <dl>
        <dt>Edition</dt>
        <dd><input type="number" name="item_edition" value="<?php echo h($item['item_edition'] ?? ''); ?>" /></dd>
      </dl>
    </div>
      <div class="form-row">
      <dl>
        <dt>Year published</dt>
        <dd><input type="number" name="publication_year" value="<?php echo h($item['publication_year'] ?? ''); ?>" /></dd>
      </dl>
    </div>
       <?php
      $publisher_set = mysqli_query($db, "SELECT publisher_id, publisher_name FROM publishers");
        ?>
    <div class="form-row">
      <dl>
        <dt>Publisher</dt>
        <dd>
      <select name="publisher_id" id="publisher_id">
     <option value="">-- Select Publisher --</option>
    <?php while ($row = mysqli_fetch_assoc($publisher_set)): ?>
    <option value="<?php echo h($row['publisher_id']); ?>"
      <?php if (($item['publisher_id'] ?? '') == $row['publisher_id']) echo 'selected'; ?>>
      <?php echo h($row['publisher_id']) . " - " . h($row['publisher_name']); ?> 
     </option>
    <?php endwhile; ?>
      </select>
      </dd>
    </dl>
    </div>
    <a class="page-link" href="<?php echo url_for('/admin/publishers/new.php'); ?>">Add new publisher</a>
    <div class="form-row">
    <dl>
      <dt>Category</dt>
      <dd><input type="text" name="category" value="<?php echo h($item['category'] ?? ''); ?>" /></dd>
    </dl>
    </div>
    <div class="form-row">
    <dl>
      <dt>Number of copies</dt>
      <dd><input type="number" name="item_copy" value="<?php echo h($item['item_copy'] ?? ''); ?>" /></dd>
    </dl>
    </div>
      <div id="operations">
        <input type="submit" value="Add Item" />
      </div>
      
    </form>

  </div>

</div>
    </main>
<?php include(SHARED_PATH . '/admin_footer.php'); ?>