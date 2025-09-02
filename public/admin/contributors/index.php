<?php require_once('../../../private/init.php');
if(isset($_SESSION['role']) && strtolower($_SESSION['role']) !== 'admin') {
  //if user not admin
  echo "You do not have permission to access this page.";
  exit; 
}
// Get search term
$search_term = isset($_GET['search']) ? trim($_GET['search']) : '';

// Build the query based on search
if(!empty($search_term)) {
    // Use search results
    $search_results = keyword_search_contributors($db, $search_term);
    $contributor_set = null;
} else {
    $contributor_set = find_all_contributors();
    $search_results = null;
}

?>

<?php $page_title = 'contributors'; ?>

<?php include(SHARED_PATH . '/header.php'); ?>

<main aria-label="main content">
<div id="content">
  <div class="contributors listing">
    <h1>Contributors</h1>

    <div class="back-link-wrapper">
      <a class="back-link" href="<?php echo url_for('/admin/index.php'); ?>">← Back to List</a>
    </div>
    
    <div class="actions">
      <a class="action1" href="<?php echo url_for('/admin/contributors/new.php'); ?>">＋ Add New Contributor</a>
      <form class="search-form" method="GET" action="">
        <input type="text" name="search" placeholder="Search contributors..." value="<?php echo isset($_GET['search']) ? h($_GET['search']) : ''; ?>">
        <input type="submit" value="Search">
        <?php if(isset($_GET['search']) && !empty($_GET['search'])): ?>
          <a class="clear-link" href="<?php echo url_for('/admin/contributors/index.php'); ?>">Clear</a>
        <?php endif; ?>

        <?php 
          // Count results based on whether we have search results or all contributors
          if($search_results !== null) {
              $count = count($search_results);
          } else {
              // For mysqli result, we need to count the rows
              $count = mysqli_num_rows($contributor_set);
          }
          echo h($count) . ' ' . ($count === 1 ? 'Result' : 'Results') ; ?>
      </form>
    </div>
    
    <table class = "list">
      <tr>  
        <th>ID</th>
        <th>Name</th>
        <th>Role</th>
  	    <th>&nbsp;</th>
  	    <th>&nbsp;</th>
        <th>&nbsp;</th>
  	  </tr>

      <?php 
      // Handle different result types
      if($search_results !== null) {
          // Search results (array format) - Apply highlighting when search term exists
          foreach($search_results as $contributor) {
      ?>
        <tr>
          <td><?php echo h($contributor['contributor_id']); ?></td>
          <td><?php echo !empty($search_term) ? highlight_search_terms(h($contributor['contributor_name']), $search_term) : h($contributor['contributor_name']); ?></td>
          <td><?php echo isset($contributor['roles']) ? h($contributor['roles']) : ''; ?></td>
          <td><a class="action2" href="<?php echo url_for('/admin/contributors/show.php?Page=1&id=' . h(u($contributor['contributor_id'])));?>">View</a></td>
          <td><a class="action2" href="<?php echo url_for('/admin/contributors/edit.php?id=' . h(u($contributor['contributor_id']))); ?>">Edit</a></td>
          <td><a class="action2" href="<?php echo url_for('/admin/contributors/delete.php?id=' . h(u($contributor['contributor_id']))); ?>">Delete</a></td>
    	  </tr>
      <?php 
          }
      } else {
          // Regular results (mysqli result format) - no search term, so no highlighting needed
          while($contributor = mysqli_fetch_assoc($contributor_set)) { 
      ?>
        <tr>
          <td><?php echo h($contributor['contributor_id']); ?></td>
          <td><?php echo h($contributor['contributor_name']); ?></td>
          <td><?php echo isset($contributor['roles']) ? h($contributor['roles']) : ''; ?></td>
          <td><a class="action2" href="<?php echo url_for('/admin/contributors/show.php?Page=1&id=' . h(u($contributor['contributor_id'])));?>">View</a></td>
          <td><a class="action2" href="<?php echo url_for('/admin/contributors/edit.php?id=' . h(u($contributor['contributor_id']))); ?>">Edit</a></td>
          <td><a class="action2" href="<?php echo url_for('/admin/contributors/delete.php?id=' . h(u($contributor['contributor_id']))); ?>">Delete</a></td>
    	  </tr>
      <?php 
          }
      } ?>
  	</table>
  	
  	<!-- free up storage of $contributor-set query above -->
	<?php
	if($contributor_set !== null) {
		mysqli_free_result($contributor_set);
	}
	?>

  </div>

</div>
</main>
<?php include(SHARED_PATH . '/footer.php'); ?>
