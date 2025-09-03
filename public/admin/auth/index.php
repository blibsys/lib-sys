<?php
 require_once('../../../private/init.php');

if(isset($_SESSION['role']) && strtolower($_SESSION['role']) !== 'admin') {
  //if user not admin
  echo "You do not have permission to access this page.";
  exit; 
}
$filter_role = isset($_GET['role']) ? trim($_GET['role']) : '';
$search_term = isset($_GET['search']) ? trim($_GET['search']) : '';

// --- FIXED LOGIC: Always use SQL for both search and filter ---
if(!empty($search_term) || !empty($filter_role)) {
    // Use filtered/search results
    $auths = keyword_search_auth($db, $search_term, $filter_role);
    $auth_set = null;
    $search_results = $auths;
} else {
    $auth_set = find_all_auth(); 
    $search_results = null;
}
?>

<?php $page_title = 'user authentication'; ?>

<?php include(SHARED_PATH . '/header.php'); ?>
<main aria-label="main content">
<div id="content">
  <div class="auths listing">
    <h1>User Login</h1>

    <div class="back-link-wrapper">
      <a class="back-link" href="<?php echo url_for('/admin/index.php'); ?>">← Back to List</a>
    </div>
<script>
  window.onload = function() {
    var searchBox = document.getElementById('search-box');
    if (searchBox) {
      searchBox.focus();
    }
  };
</script>
    <div class="actions">
      <a class="action1" href="<?php echo url_for('/admin/auth/new.php'); ?>">＋ Add New Login Details</a>
    <form class="search-form" method="GET" action="">
        <?php if(!empty($filter_role)): ?>
          <input type="hidden" name="role" value="<?php echo h($filter_role); ?>">
        <?php endif; ?>
        <input id="search-box" type="text" name="search" placeholder="Search user credentials..." value="<?php echo h($search_term); ?>">
        <input type="submit" value="Search">
        <?php if(!empty($search_term)): ?>
          <a class="clear-link" href="<?php echo url_for('/admin/auth/index.php'); ?>">Clear</a>
        <?php endif; ?>
        <?php 
          if($search_results !== null) {
              $count = count($search_results);
          } else {
              $count = mysqli_num_rows($auth_set);
          }
          echo h($count) . ' ' . ($count === 1 ? 'Result' : 'Results') ;
        ?>
    </form>
    <div class="filters">
      <form class="filter-form" method="GET" action="">
        <?php if(!empty($search_term)): ?>
          <input type="hidden" name="search" value="<?php echo h($search_term); ?>">
        <?php endif; ?>
        <p> Filter by... </p>
        <select name="role" onchange="this.form.submit()">
          <option value="">Role</option>
          <?php
            $auth_roles = find_all_auth_roles();
            foreach($auth_roles as $role): ?>
              <option value="<?php echo h($role); ?>" <?php echo ($filter_role === $role) ? 'selected' : ''; ?>>
                <?php echo h($role); ?>
              </option>
          <?php endforeach; ?>
        </select>
        <?php if(!empty($filter_role) || !empty($search_term)): ?>
          <a href="<?php echo url_for('/admin/auth/index.php'); ?>" class="clear-filters">Clear Filters</a>
        <?php endif; ?>
      </form>
    </div>

    <table class = "list">
      <tr>  
        <th>Authentication ID</th>
        <th>User ID</th>
        <th>Role</th>
        <th>Username</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Created At</th>
        <th>Updated At</th>
          <th>&nbsp;</th>
          <th>&nbsp;</th>
        <th>&nbsp;</th>
        </tr>
          <?php 
      if($search_results !== null) {
        foreach($search_results as $auth) { ?>
          <tr>
            <td><?php echo h($auth['auth_id']); ?></td>
            <td><?php echo h($auth['user_id']); ?></td>
            <td><?php echo h($auth['role']); ?></td>
            <td><?php echo h($auth['username']); ?></td>
            <td><?php echo h($auth['first_name']); ?></td>
            <td><?php echo h($auth['last_name']); ?></td>
            <td><?php echo h($auth['email']); ?></td>
            <td><?php echo h($auth['auth_created_at']); ?></td>
            <td><?php echo h($auth['auth_updated_at']); ?></td>
            <td><a class="action2" href="<?php echo url_for('/admin/auth/show.php?Page=1&id=' . h(u($auth['auth_id'])));?>">View</a></td>
            <td><a class="action2" href="<?php echo url_for('/admin/auth/edit.php?id=' . h(u($auth['auth_id']))); ?>">Edit</a></td>
            <td><a class="action2" href="<?php echo url_for('/admin/auth/delete.php?id=' . h(u($auth['auth_id'])));?>">Delete</a></td>
          </tr>
        <?php }
      } else {
        while($auth = mysqli_fetch_assoc($auth_set)) { ?>
          <tr>
            <td><?php echo h($auth['auth_id']); ?></td>
            <td><?php echo h($auth['user_id']); ?></td>
            <td><?php echo h($auth['role']); ?></td>
            <td><?php echo h($auth['username']); ?></td>
            <td><?php echo h($auth['first_name']); ?></td>
            <td><?php echo h($auth['last_name']); ?></td>
            <td><?php echo h($auth['email']); ?></td>
            <td><?php echo h($auth['auth_created_at']); ?></td>
            <td><?php echo h($auth['auth_updated_at']); ?></td>
            <td><a class="action2" href="<?php echo url_for('/admin/auth/show.php?Page=1&id=' . h(u($auth['auth_id'])));?>">View</a></td>
            <td><a class="action2" href="<?php echo url_for('/admin/auth/edit.php?id=' . h(u($auth['auth_id']))); ?>">Edit</a></td>
            <td><a class="action2" href="<?php echo url_for('/admin/auth/delete.php?id=' . h(u($auth['auth_id'])));?>">Delete</a></td>
          </tr>
        <?php }
    
      // Free the mysqli result
          mysqli_free_result($auth_set);
      } ?>
      </table>

  </div>

</div>
</main>
<?php include(SHARED_PATH . '/footer.php'); ?>