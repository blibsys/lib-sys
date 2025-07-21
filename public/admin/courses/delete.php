<?php require_once('../../../private/initialise.php'); ?>

<?php if(!isset($_GET['id'])) {
  redirect_to(url_for('/admin/courses/index.php'));
}
$id = $_GET['id'];

if(is_post_request()) {
	
	$result = delete_course($id);
	redirect_to(url_for('/admin/courses/index.php'));
	
	} else {
	$course = find_course_by_id($id);
	}

?>

<?php $page_title = 'Delete Course'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/admin/courses/index.php'); ?>">&laquo; Back to List</a>

  <div class="course delete">
    <h1>Delete Course</h1>
    <p>!! Are you sure you want to delete this course? !!</p>
    <p class="item"><?php echo h($course['course_id'] . ' - ' . $course['course_name']); ?></p>

    <form action="<?php echo url_for('/admin/courses/delete.php?id=' . h(u($course['course_id']))); ?>" method="post">
      <div id="operations">
        <input type="submit" name="commit" value="Delete Course" />
      </div>
    </form>
  </div>

</div>

<?php include(SHARED_PATH . '/admin_footer.php'); ?>
