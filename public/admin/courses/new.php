 <?php

require_once('../../../private/initialise.php'); 

?>

<?php $page_title = 'Add course'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>

<!-- html with embedded php to display a web form for creating a new course -->
<!-- ("server side script for managing content") -->

<div id="content">

  <a class="back-link" href="<?php echo url_for('/admin/courses/index.php'); ?>">&laquo; Back to List</a>

  <div class="course new">
    <h1>Add course</h1>

    <form action="<?php echo url_for('/admin/courses/create.php'); ?>" method="post">
      <dl>
        <dt>Course id</dt>
        <dd><input type="text" name="course_id" value="" /></dd>
      </dl>
      <dl>
        <dt>Course name</dt>
        <dd><input type="text" name="course_name" value="" /></dd>
      </dl>
    
      <div id="operations">
        <input type="submit" value="Add Course" />
      </div>
    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/admin_footer.php'); ?>


