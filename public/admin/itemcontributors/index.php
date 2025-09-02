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
    $itemcontributor_set = find_all_itemcontributors();
    $temp_itemcontributors = [];
    while($row = mysqli_fetch_assoc($itemcontributor_set)) {
        $temp_itemcontributors[] = $row;
    }
    mysqli_free_result($itemcontributor_set);
    
    // Manual search filtering
    $itemcontributors = [];
    foreach($temp_itemcontributors as $itemcontributor) {
        if(stripos($itemcontributor['item_id'], $search_term) !== false || 
           stripos($itemcontributor['contributor_id'], $search_term) !== false) {
            $itemcontributors[] = $itemcontributor;
        }
    }
    
    $itemcontributor_set = null;
    $search_results = $itemcontributors;
} else {
    $itemcontributor_set = find_all_itemcontributors();
    $search_results = null;
}

?>

<?php $page_title = 'item author & contributors'; ?>

<?php include(SHARED_PATH . '/header.php'); ?>

<main aria-label="main content">
<div id="content">
  <div class="item contributors listing">
    <h1>Item Contributors</h1>
    <div class="back-link-wrapper">
      <a class="back-link" href="<?php echo url_for('admin/index.php'); ?>">← Back to List</a>
    </div>
    
    <div class="actions">
      <!--<a class="action1" href="<?php echo url_for('/admin/itemcontributors/new.php'); ?>">Add New Itemcontributor</a>-->
      <form class="search-form" method="GET" action="">
        <input type="text" name="search" placeholder="Search item contributors..." value="<?php echo isset($_GET['search']) ? h($_GET['search']) : ''; ?>">
        <input type="submit" value="Search">
        <?php if(isset($_GET['search']) && !empty($_GET['search'])): ?>
          <a class="clear-link" href="<?php echo url_for('/admin/itemcontributors/index.php'); ?>">Clear</a>
        <?php endif; ?>

        <?php 
          // Count results based on whether we have search results or all item contributors
          if($search_results !== null) {
              $count = count($search_results);
          } else {
              // For mysqli result, we need to count the rows
              $count = mysqli_num_rows($itemcontributor_set);
          }
          echo h($count) . ' ' . ($count === 1 ? 'Result' : 'Results') ; ?>
      </form>
    </div>
    
    <table class = "list">
      <tr>  
        <th>Item ID</th>
        <th>Contributor ID</th>
  	    <th>&nbsp;</th>
  	    <th>&nbsp;</th>
        <th>&nbsp;</th>
  	  </tr>

      <?php 
      // Handle different result types
      if($search_results !== null) {
          // Search results (array format)
          foreach($search_results as $icontributor) {
      ?>
        <tr>
          <td><?php echo h($icontributor['item_id']); ?></td>
          <td><?php echo h($icontributor['contributor_id']); ?></td>
          <td><a class="action2" href="<?php echo url_for('/admin/itemcontributors/show.php?id=' . h(u($icontributor['item_id']))); ?>">View</a></td>
          <td><a class="action2" href="<?php echo url_for('/admin/itemcontributors/edit.php?id=' . h(u($icontributor['item_id']))); ?>">Edit</a></td>
          <td><a class="action2" href="">Delete</a></td>
    	  </tr>
      <?php 
          }
      } else {
          // Regular results (mysqli result format)
          while($icontributor = mysqli_fetch_assoc($itemcontributor_set)) { 
      ?>
        <tr>
          <td><?php echo h($icontributor['item_id']); ?></td>
          <td><?php echo h($icontributor['contributor_id']); ?></td>
          <td><a class="action2" href="<?php echo url_for('/admin/itemcontributors/show.php?id=' . h(u($icontributor['item_id']))); ?>">View</a></td>
          <td><a class="action2" href="<?php echo url_for('/admin/itemcontributors/edit.php?id=' . h(u($icontributor['item_id']))); ?>">Edit</a></td>
          <td><a class="action2" href="">Delete</a></td>
    	  </tr>
      <?php 
          }
      } ?>
  	</table>
  	
  	<!-- free up storage of $contributor-set query above -->
	<?php
	if($itemcontributor_set !== null) {
		mysqli_free_result($itemcontributor_set);
	}
	?>

  </div>

</div>
      </main>
<?php include(SHARED_PATH . '/footer.php'); ?>
