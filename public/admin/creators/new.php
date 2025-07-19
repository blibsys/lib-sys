 <?php

require_once('../../../private/initialise.php'); 

?>

<?php $page_title = 'Add creator'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>

<!-- html with embedded php to display a web form for creating a new creator -->
<!-- ("server side script for managing content") -->

<div id="content">

  <a class="back-link" href="<?php echo url_for('/admin/creators/index.php'); ?>">&laquo; Back to List</a>

  <div class="creator new">
    <h1>Add creator</h1>

    <form action="<?php echo url_for('/admin/creators/create.php'); ?>" method="post">
      <dl>
        <dt>creator id</dt>
        <dd><input type="text" name="creator_id" value="" /></dd>
      </dl>
      <dl>
        <dt>creator name</dt>
        <dd><input type="text" name="creator_name" value="" /></dd>
      </dl>
    
      <div id="operations">
        <input type="submit" value="Add Creator" />
      </div>
    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/admin_footer.php'); ?>


