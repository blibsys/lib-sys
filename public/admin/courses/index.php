
<?php 

require_once('../../../private/init.php');

// Get search term
$search_term = isset($_GET['search']) ? trim($_GET['search']) : '';

// Build the query based on search
if(!empty($search_term)) {
    // Use search results (assuming you have a search function for courses)
    // If you don't have keyword_search_courses function, we'll filter manually
    $course_set = find_all_courses();
    $temp_courses = [];
    while($row = mysqli_fetch_assoc($course_set)) {
        $temp_courses[] = $row;
    }
    mysqli_free_result($course_set);
    
    // Manual search filtering
    $courses = [];
    foreach($temp_courses as $course) {
        if(stripos($course['course_name'], $search_term) !== false || 
           stripos($course['course_id'], $search_term) !== false) {
            $courses[] = $course;
        }
    }
    
    $course_set = null;
    $search_results = $courses;
} else {
    $course_set = find_all_courses();
    $search_results = null;
}

?>

<?php $page_title = 'courses'; ?>

<?php include(SHARED_PATH . '/header.php'); ?>
<main aria-label="main content">
<div id="content">
  <div class="courses listing">
    <h1>Courses</h1>

    <div class="back-link-wrapper">
      <a class="back-link" href="<?php echo url_for('/admin/index.php'); ?>">← Back to List</a>
    </div>

    <div class="actions">
      <a class="action1" href="<?php echo url_for('/admin/courses/new.php'); ?>">＋ Add New Course</a>
      <form class="search-form" method="GET" action="">
        <input type="text" name="search" placeholder="Search courses..." value="<?php echo isset($_GET['search']) ? h($_GET['search']) : ''; ?>">
        <input type="submit" value="Search">
        <?php if(isset($_GET['search']) && !empty($_GET['search'])): ?>
          <a class="clear-link" href="<?php echo url_for('/admin/courses/index.php'); ?>">Clear</a>
        <?php endif; ?>

        <?php 
          // Count results based on whether we have search results or all courses
          if($search_results !== null) {
              $count = count($search_results);
          } else {
              // For mysqli result, we need to count the rows
              $count = mysqli_num_rows($course_set);
          }
          echo h($count) . ' ' . ($count === 1 ? 'Result' : 'Results') ; ?>
      </form>
    </div>
      
    <table class = "list">
      <tr>  
        <th>ID</th>
        <th>Name</th>
  	    <th>&nbsp;</th>
  	    <th>&nbsp;</th>
        <th>&nbsp;</th>
  	  </tr>

      <?php 
      // Handle different result types
      if($search_results !== null) {
          // Search results (array format) - Apply highlighting when search term exists
          foreach($search_results as $course) {
      ?>
        <tr>
          <td><?php echo h($course['course_id']); ?></td>
          <td><?php echo !empty($search_term) ? highlight_search_terms(h($course['course_name']), $search_term) : h($course['course_name']); ?></td>
          <td><a class="action2" href="<?php echo url_for('/admin/courses/show.php?Page=1&id=' . h(u($course['course_id'])));?>">View</a></td>
          <td><a class="action2" href="<?php echo url_for('/admin/courses/edit.php?id=' . h(u($course['course_id']))); ?>">Edit</a></td>
          <td><a class="action2" href="<?php echo url_for('/admin/courses/delete.php?id=' . h(u($course['course_id'])));?>">Delete</a></td>
    	  </tr>
      <?php 
          }
      } else {
          // Regular results (mysqli result format) - no search term, so no highlighting needed
          // Regular results (mysqli result format)
          while($course = mysqli_fetch_assoc($course_set)) { 
      ?>
        <tr>
          <td><?php echo h($course['course_id']); ?></td>
          <td><?php echo h($course['course_name']); ?></td>
          <td><a class="action2" href="<?php echo url_for('/admin/courses/show.php?Page=1&id=' . h(u($course['course_id'])));?>">View</a></td>
          <td><a class="action2" href="<?php echo url_for('/admin/courses/edit.php?id=' . h(u($course['course_id']))); ?>">Edit</a></td>
          <td><a class="action2" href="<?php echo url_for('/admin/courses/delete.php?id=' . h(u($course['course_id'])));?>">Delete</a></td>
    	  </tr>
      <?php 
          }
      } ?>
  	</table>

<!-- free up storage of $course-set query above -->
	<?php
	if($course_set !== null) {
		mysqli_free_result($course_set);
	}
	?>

  </div>

</div>
</main>
<?php include(SHARED_PATH . '/footer.php'); ?>
