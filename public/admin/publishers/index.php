
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
    // Use search results (filter manually)
    $publisher_set = find_all_pubs();
    $temp_publishers = [];
    while($row = mysqli_fetch_assoc($publisher_set)) {
        $temp_publishers[] = $row;
    }
    mysqli_free_result($publisher_set);
    
    // Manual search filtering
    $publishers = [];
    foreach($temp_publishers as $publisher) {
        if(stripos($publisher['publisher_name'], $search_term) !== false || 
           stripos($publisher['publisher_id'], $search_term) !== false) {
            $publishers[] = $publisher;
        }
    }
    
    $publisher_set = null;
    $search_results = $publishers;
} else {
    $publisher_set = find_all_pubs();
    $search_results = null;
}

?>

<?php $page_title = 'publishers'; ?>

<?php include(SHARED_PATH . '/header.php'); ?>
<main aria-label="main content">
<div id="content">
  <div class="publishers listing">
    <h1>Publishers</h1>

    <div class="back-link-wrapper">
      <a class="back-link" href="<?php echo url_for('admin/index.php'); ?>">← Back to List</a>
    </div>

    <div class="actions">
      <a class="action1" href="<?php echo url_for('/admin/publishers/new.php'); ?>">＋ Add New publisher</a>
      <form class="search-form" method="GET" action="">
        <input type="text" name="search" placeholder="Search publishers..." value="<?php echo isset($_GET['search']) ? h($_GET['search']) : ''; ?>">
        <input type="submit" value="Search">
        <?php if(isset($_GET['search']) && !empty($_GET['search'])): ?>
          <a class="clear-link" href="<?php echo url_for('/admin/publishers/index.php'); ?>">Clear</a>
        <?php endif; ?>

        <?php 
          // Count results based on whether we have search results or all publishers
          if($search_results !== null) {
              $count = count($search_results);
          } else {
              // For mysqli result, we need to count the rows
              $count = mysqli_num_rows($publisher_set);
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
          foreach($search_results as $pub) {
      ?>
        <tr>
          <td><?php echo h($pub['publisher_id']); ?></td>
          <td><?php echo !empty($search_term) ? highlight_search_terms(h($pub['publisher_name']), $search_term) : h($pub['publisher_name']); ?></td>
          <td><a class="action2" href="<?php echo url_for('/admin/publishers/show.php?Page=1&id=' . h(u($pub['publisher_id'])));?>">View</a></td>
          <td><a class="action2" href="<?php echo url_for('/admin/publishers/edit.php?id=' . h(u($pub['publisher_id']))); ?>">Edit</a></td>
          <td><a class="action2" href="<?php echo url_for('/admin/publishers/delete.php?id=' . h(u($pub['publisher_id']))); ?>">Delete</a></td>
    	  </tr>
      <?php 
          }
      } else {
          // Regular results (mysqli result format)
          while($pub = mysqli_fetch_assoc($publisher_set)) { 
      ?>
        <tr>
          <td><?php echo h($pub['publisher_id']); ?></td>
          <td><?php echo h($pub['publisher_name']); ?></td>
          <td><a class="action2" href="<?php echo url_for('/admin/publishers/show.php?Page=1&id=' . h(u($pub['publisher_id'])));?>">View</a></td>
          <td><a class="action2" href="<?php echo url_for('/admin/publishers/edit.php?id=' . h(u($pub['publisher_id']))); ?>">Edit</a></td>
          <td><a class="action2" href="<?php echo url_for('/admin/publishers/delete.php?id=' . h(u($pub['publisher_id']))); ?>">Delete</a></td>
    	  </tr>
      <?php 
          }
      } ?>
  	</table>

<!-- free up storage of $publisher-set query above -->
	<?php
	if($publisher_set !== null) {
		mysqli_free_result($publisher_set);
	}
	?>

  </div>

</div>
      </main>
<?php include(SHARED_PATH . '/footer.php'); ?>
