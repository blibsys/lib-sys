<?php

require_once('../../../private/initialise.php'); 

?>

<?php $page_title = 'Add item'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>

<!-- html with embedded php to display a web form for creating a new item -->
<!-- ("server side script for managing content") -->
<!-- need to add validation to the forms -->
<div id="content">

  <a class="back-link" href="<?php echo url_for('/admin/items/index.php'); ?>">&laquo; Back to List</a>

  <div class="item new">
    <h1>Add Item</h1>

    <form action="<?php echo url_for('/admin/items/create.php'); ?>" method="post">
      <dl>
        <dt>Title</dt>
        <dd><input type="text" name="title" value="" /></dd>
      </dl>
      <dl>
        <dt>Edition</dt>
        <dd><input type="text" name="item_edition" value="" /></dd>
      </dl>
      <dl>
        <dt>ISBN</dt>
        <dd><input type="text" name="isbn" value="" /></dd>
      </dl>
      <dl>
        <dt>Type</dt>
        <dd><input type="text" name="item_type" value="" /></dd>
      </dl>
      <dl>
        <dt>Year published</dt>
        <dd><input type="text" name="publication_year" value="" /></dd>
      </dl>
      <dl>
        <dt>Copy</dt>
        <dd><input type="text" name="item_copy" value="" /></dd>
      </dl>
      <dl>
        <dt>Publisher id</dt>
        <dd><input type="text" name="publisher_id" value="" /></dd>
      </dl>
      <dl>
        <dt>Category</dt>
        <dd><input type="text" name="category" value="" /></dd>
      </dl>
      <dl>
        <dt>Status</dt>
        <dd><input type="text" name="item_status" value="" /></dd>
      </dl>

      
      <div id="operations">
        <input type="submit" value="Add Item" />
      </div>
      
    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/admin_footer.php'); ?>