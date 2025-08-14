<?php require_once('../../../private/init.php'); 

// Get filter values
$filter_role = isset($_GET['role']) ? trim($_GET['role']) : '';
$filter_course = isset($_GET['course']) ? trim($_GET['course']) : '';
$search_term = isset($_GET['search']) ? trim($_GET['search']) : '';

// Build the query based on filters and search
if(!empty($search_term) || !empty($filter_role) || !empty($filter_course)) {
    // Use filtered/search results
    if(!empty($search_term)) {
        $users = keyword_search_users($db, $search_term);
    } else {
        $user_set = find_all_users();
        // Convert mysqli result to array for filtering
        $temp_users = [];
        while($row = mysqli_fetch_assoc($user_set)) {
            $temp_users[] = $row;
        }
        $users = $temp_users;
        mysqli_free_result($user_set);
    }
    
    // Apply filters to the results
    if(!empty($filter_role) || !empty($filter_course)) {
        $filtered_users = [];
        foreach($users as $user) {
            $include = true;
            
            if(!empty($filter_role) && $user['role'] !== $filter_role) {
                $include = false;
            }
            if(!empty($filter_course) && $user['course_id'] !== $filter_course) {
                $include = false;
            }
            
            if($include) {
                $filtered_users[] = $user;
            }
        }
        $users = $filtered_users;
    }
    
    $user_set = null;
    $search_results = $users;
} else {
    $user_set = find_all_users();
    $search_results = null;
}

?>

<?php $user_title = 'users'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>

<main aria-label="main content">
<div id="content">
  <div class="users listing">
    <h1>Users</h1>
    
    <div class="back-link-wrapper">
      <a class="back-link" href="<?php echo url_for('admin/index.php'); ?>">← Back to List</a>
    </div>
    
    <div class="actions">
      <a class="action1" href="<?php echo url_for('/admin/users/new.php'); ?>">＋ Add New User</a>
      <form class="search-form" method="GET" action="">
        <!-- Preserve filter values when searching -->
        <?php if(!empty($filter_role)): ?>
          <input type="hidden" name="role" value="<?php echo h($filter_role); ?>">
        <?php endif; ?>
        <?php if(!empty($filter_course)): ?>
          <input type="hidden" name="course" value="<?php echo h($filter_course); ?>">
        <?php endif; ?>
        
        <input type="text" name="search" placeholder="Search users..." value="<?php echo isset($_GET['search']) ? h($_GET['search']) : ''; ?>">
        <input type="submit" value="Search">
        <?php if(isset($_GET['search']) && !empty($_GET['search'])): ?>
          <a class="clear-link" href="<?php echo url_for('/admin/users/index.php'); ?>">Clear</a>
        <?php endif; ?>

 <?php 
          // Count results based on whether we have search/filter results or all users
          if($search_results !== null) {
              $count = count($search_results);
          } else {
              // For mysqli result, we need to count the rows
              $count = mysqli_num_rows($user_set);
          }
          echo h($count) . ' ' . ($count === 1 ? 'Result' : 'Results') ; ?>

      </form>
    </div>

    <div class="filters">
      <form class="filter-form" method="GET" action="">
        <!-- Preserve search term when filtering -->
        <?php if(!empty($search_term)): ?>
          <input type="hidden" name="search" value="<?php echo h($search_term); ?>">
        <?php endif; ?>
        <p> Filter by... </p>
        <select name="role" onchange="this.form.submit()">
          <option value="">Role</option>
          <?php
          $user_roles = find_all_user_roles();
          foreach($user_roles as $role): ?>
            <option value="<?php echo h($role); ?>" <?php echo ($filter_role === $role) ? 'selected' : ''; ?>>
              <?php echo h($role); ?>
            </option>
          <?php endforeach; ?>
        </select>
        
        <select name="course" onchange="this.form.submit()">
          <option value="">Course</option>
          <?php
          $courses_result = find_all_courses();
          while($course_row = mysqli_fetch_assoc($courses_result)): ?>
            <option value="<?php echo h($course_row['course_id']); ?>" <?php echo ($filter_course === $course_row['course_id']) ? 'selected' : ''; ?>>
              <?php echo h($course_row['course_name']); ?>
            </option>
          <?php endwhile;
          mysqli_free_result($courses_result); ?>
        </select>
        
        <?php if(!empty($filter_role) || !empty($filter_course)): ?>
          <a href="<?php echo url_for('/admin/users/index.php' . (!empty($search_term) ? '?search=' . urlencode($search_term) : '')); ?>" class="clear-filters">Clear Filters</a>
        <?php endif; ?>
      </form>
    </div>
    
    <table class="list">
  	  <tr>
        <th>ID</th>
        <th>First name</th>
        <th>Last name</th>
  	    <th>Start date</th>
  	    <th>End date</th>
  	    <th>Role</th>
  	    <th>Email</th>
  	    <th>Course ID</th>
  	    <th>Created</th>
  	    <th>Updated</th>
  	    <th>&nbsp;</th>
  	    <th>&nbsp;</th>
        <th>&nbsp;</th>
  	  </tr>

      <?php 
      // Handle different result types
      if($search_results !== null) {
          // Search results (array format) - Apply highlighting when search term exists
          foreach($search_results as $user) {
      ?>
        <tr>
          <td><?php echo h($user['user_id']); ?></td>
          <td><?php echo !empty($search_term) ? highlight_search_terms(h($user['first_name']), $search_term) : h($user['first_name']); ?></td>
          <td><?php echo !empty($search_term) ? highlight_search_terms(h($user['last_name']), $search_term) : h($user['last_name']); ?></td>
    	  <td><?php echo $user['user_start_date'] ? h(date('d/m/Y', strtotime($user['user_start_date']))) : ''; ?></td>
    	  <td><?php echo $user['user_end_date'] ? h(date('d/m/Y', strtotime($user['user_end_date']))) : ''; ?></td>
          <td><?php echo !empty($search_term) ? highlight_search_terms(h($user['role']), $search_term) : h($user['role']); ?></td>
          <td><?php echo !empty($search_term) ? highlight_search_terms(h($user['email']), $search_term) : h($user['email']); ?></td>
    	  <td><?php echo h($user['course_id']); ?></td>
    	  <td><?php echo $user['created_at'] ? h(date('d/m/Y', strtotime($user['created_at']))) : ''; ?></td>
    	  <td><?php echo $user['updated_at'] ? h(date('d/m/Y', strtotime($user['updated_at']))) : ''; ?></td>
          <td><a class="action2" href="<?php echo url_for('/admin/users/show.php?user=1&id=' . h(u($user['user_id'])));?>">View</a></td>
          <td><a class="action2" href="<?php echo url_for('/admin/users/edit.php?id=' . h(u($user['user_id']))); ?>">Edit</a></td>
          <td><a class="action2" href="<?php echo url_for('/admin/users/delete.php?id=' . h(u($user['user_id']))); ?>">Delete</a></td>
    	  </tr>
      <?php 
          }
      } else {
          // Regular results (mysqli result format) - no search term, so no highlighting needed
          while($user = mysqli_fetch_assoc($user_set)) { 
      ?>
        <tr>
          <td><?php echo h($user['user_id']); ?></td>
          <td><?php echo h($user['first_name']); ?></td>
          <td><?php echo h($user['last_name']); ?></td>
    	  <td><?php echo $user['user_start_date'] ? h(date('d/m/Y', strtotime($user['user_start_date']))) : ''; ?></td>
    	  <td><?php echo $user['user_end_date'] ? h(date('d/m/Y', strtotime($user['user_end_date']))) : ''; ?></td>
          <td><?php echo h($user['role']); ?></td>
          <td><?php echo h($user['email']); ?></td>
    	  <td><?php echo h($user['course_id']); ?></td>
    	  <td><?php echo $user['created_at'] ? h(date('d/m/Y', strtotime($user['created_at']))) : ''; ?></td>
    	  <td><?php echo $user['updated_at'] ? h(date('d/m/Y', strtotime($user['updated_at']))) : ''; ?></td>
          <td><a class="action2" href="<?php echo url_for('/admin/users/show.php?user=1&id=' . h(u($user['user_id'])));?>">View</a></td>
          <td><a class="action2" href="<?php echo url_for('/admin/users/edit.php?id=' . h(u($user['user_id']))); ?>">Edit</a></td>
          <td><a class="action2" href="<?php echo url_for('/admin/users/delete.php?id=' . h(u($user['user_id']))); ?>">Delete</a></td>
    	  </tr>
      <?php 
          }
          // Free the mysqli result
          mysqli_free_result($user_set);
      } ?>
  	</table>
    
      </div>

</div>
      </main>
<?php include(SHARED_PATH . '/admin_footer.php'); ?>
    