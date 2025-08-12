
<?php 

require_once('../../../private/init.php');

$course_set = find_all_courses(); 

?>

<?php $page_title = 'courses'; ?>

<?php include(SHARED_PATH . '/admin_header.php'); ?>
<main aria-label="main content">
<div id="content">
  <div class="courses listing">
    <h1>Courses</h1>

    <div class="back-link-wrapper">
      <a class="back-link" href="<?php echo url_for('/admin/index.php'); ?>">← Back to List</a>
    </div>

    <div class="actions">
      <a class="action1" href="<?php echo url_for('/admin/courses/new.php'); ?>">Add New Course</a>
    </div>
      
    <table class = "list">
      <tr>  
        <th>ID</th>
        <th>Name</th>
  	    <th>&nbsp;</th>
  	    <th>&nbsp;</th>
        <th>&nbsp;</th>
  	  </tr>

      <?php while($course = mysqli_fetch_assoc($course_set)) { ?>
        <tr>
          <td><?php echo h($course['course_id']); ?></td>
          <td><?php echo h($course['course_name']); ?></td>
          <td><a class="action2" href="<?php echo url_for('/admin/courses/show.php?Page=1&id=' . h(u($course['course_id'])));?>">View</a></td>
          <td><a class="action2" href="<?php echo url_for('/admin/courses/edit.php?id=' . h(u($course['course_id']))); ?>""">Edit</a></td>
          <td><a class="action2" href="<?php echo url_for('/admin/courses/delete.php?id=' . h(u($course['course_id'])));?>">Delete</a></td>
    	  </tr>
      <?php } ?>
  	</table>

<!-- free up storage of $course-set query above -->
	<?php
	mysqli_free_result($course_set);
	?>

  </div>

</div>
</main>
<?php include(SHARED_PATH . '/admin_footer.php'); ?>
