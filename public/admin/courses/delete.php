<?php require_once('../../../private/init.php');
if(isset($_SESSION['role']) && strtolower($_SESSION['role']) !== 'admin') {
  //if user not admin
  echo "You do not have permission to access this page.";
  exit; 
}
if(!isset($_GET['id'])) {
  redirect_to(url_for('/admin/courses/index.php'));
}
$id = $_GET['id'];
	$course = find_course_by_id($id);

if(is_post_request()) {
	
	$result = delete_course($id);
  if($result === true) {
    $_SESSION['message'] = 'Course deleted successfully.';
	redirect_to(url_for('/admin/courses/index.php'));
  } else {
    $errors = $result;
  //var_dump($errors);
  }
	} else {

	}

?>

<?php $page_title = 'Delete Course'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<main aria-label="main content">
<div id="content">

  <a class="back-link" href="<?php echo url_for('/admin/courses/index.php'); ?>">← Back to List</a>

  <div class="course delete">
    <h1>Delete Course</h1>

  <?php echo display_errors($errors); ?>

    <p class ="delete-message">Are you sure you want to delete this course?</p>
    <p class="item"><?php echo h($course['course_id'] . ' - ' . $course['course_name']); ?></p>

    <form action="<?php echo url_for('/admin/courses/delete.php?id=' . h(u($course['course_id']))); ?>" method="post">
      <div id="operations">
        <input type="submit" name="commit" value="Delete Course" />
      </div>
    </form>
  </div>

</div>
</main>
<?php include(SHARED_PATH . '/footer.php'); ?>
