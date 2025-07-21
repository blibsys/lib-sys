 <?php

require_once('../../../private/initialise.php'); 

	$course_set = find_all_courses();
	$course_count = mysqli_num_rows($course_set) + 1;
	mysqli_free_result($course_set);

	$course = [];
	?>


<?php $page_title = 'Add course'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>

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
