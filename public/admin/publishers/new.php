 <?php

require_once('../../../private/initialise.php'); 

?>

<?php $page_title = 'Add Publisher'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>

<!-- html with embedded php to display a web form for creating a new publisher -->
<!-- ("server side script for managing content") -->

<div id="content">

  <a class="back-link" href="<?php echo url_for('/admin/publishers/index.php'); ?>">&laquo; Back to List</a>

  <div class="publisher new">
    <h1>Add publisher</h1>

    <form action="<?php echo url_for('/admin/publishers/create.php'); ?>" method="post">
      <dl>
        <dt>publisher id</dt>
        <dd><input type="text" name="publisher_id" value="" /></dd>
      </dl>
      <dl>
        <dt>publisher name</dt>
        <dd><input type="text" name="publisher_name" value="" /></dd>
      </dl>
    
      <div id="operations">
        <input type="submit" value="Add Publisher" />
      </div>
    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/admin_footer.php'); ?>


