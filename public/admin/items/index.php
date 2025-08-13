
<?php require_once('../../../private/init.php'); 

// Get filter values
$filter_type = isset($_GET['type']) ? trim($_GET['type']) : '';
$filter_status = isset($_GET['status']) ? trim($_GET['status']) : '';
$filter_category = isset($_GET['category']) ? trim($_GET['category']) : '';
$search_term = isset($_GET['search']) ? trim($_GET['search']) : '';

// Build the query based on filters and search
if(!empty($search_term) || !empty($filter_type) || !empty($filter_status) || !empty($filter_category)) {
    // Use filtered/search results
    if(!empty($search_term)) {
        $items = keyword_search_items($db, $search_term);
    } else {
        $item_set = find_all_items();
        // Convert mysqli result to array for filtering
        $temp_items = [];
        while($row = mysqli_fetch_assoc($item_set)) {
            $temp_items[] = $row;
        }
        $items = $temp_items;
        mysqli_free_result($item_set);
    }
    
    // Apply filters to the results
    if(!empty($filter_type) || !empty($filter_status) || !empty($filter_category)) {
        $filtered_items = [];
        foreach($items as $item) {
            $include = true;
            
            if(!empty($filter_type) && $item['item_type'] !== $filter_type) {
                $include = false;
            }
            if(!empty($filter_status) && $item['item_status'] !== $filter_status) {
                $include = false;
            }
            if(!empty($filter_category) && $item['category'] !== $filter_category) {
                $include = false;
            }
            
            if($include) {
                $filtered_items[] = $item;
            }
        }
        $items = $filtered_items;
    }
    
    $item_set = null;
    $search_results = $items;
} else {
    $item_set = find_all_items();
    $search_results = null;
}

?>

<?php $page_title = 'items'; ?>

<?php include(SHARED_PATH . '/admin_header.php'); ?>
<main aria-label="main content">
<div id="content">
  <div class="items listing">
    <h1>Items</h1>

    <div class="back-link-wrapper">
      <a class="back-link" href="<?php echo url_for('admin/index.php'); ?>">← Back to List</a>
    </div>

    <div class="actions">
      <a class="action1" href="<?php echo url_for('/admin/items/new.php'); ?>">＋ Add New Item</a>
      <form class="search-form" method="GET" action="">
        <!-- Preserve filter values when searching -->
        <?php if(!empty($filter_type)): ?>
          <input type="hidden" name="type" value="<?php echo h($filter_type); ?>">
        <?php endif; ?>
        <?php if(!empty($filter_status)): ?>
          <input type="hidden" name="status" value="<?php echo h($filter_status); ?>">
        <?php endif; ?>
        <?php if(!empty($filter_category)): ?>
          <input type="hidden" name="category" value="<?php echo h($filter_category); ?>">
        <?php endif; ?>
        
        <input type="text" name="search" placeholder="Search items..." value="<?php echo isset($_GET['search']) ? h($_GET['search']) : ''; ?>">
        <input type="submit" value="Search">
        <?php if(isset($_GET['search']) && !empty($_GET['search'])): ?>
          <a class="clear-link"href="<?php echo url_for('/admin/items/index.php'); ?>">Clear</a>
        <?php endif; ?>

 <?php 
          // Count results based on whether we have search/filter results or all items
          if($search_results !== null) {
              $count = count($search_results);
          } else {
              // For mysqli result, we need to count the rows
              $count = mysqli_num_rows($item_set);
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
        <select name="type" onchange="this.form.submit()">
          <option value="">Type</option>
          <?php
          $types_result = find_all_item_types();
          while($type_row = mysqli_fetch_assoc($types_result)): ?>
            <option value="<?php echo h($type_row['item_type']); ?>" <?php echo ($filter_type === $type_row['item_type']) ? 'selected' : ''; ?>>
              <?php echo h(ucfirst($type_row['item_type'])); ?>
            </option>
          <?php endwhile;
          mysqli_free_result($types_result); ?>
        </select>
        
        <select name="status" onchange="this.form.submit()">
          <option value="">Status</option>
          <?php
          $statuses_result = find_all_item_statuses();
          while($status_row = mysqli_fetch_assoc($statuses_result)): ?>
            <option value="<?php echo h($status_row['item_status']); ?>" <?php echo ($filter_status === $status_row['item_status']) ? 'selected' : ''; ?>>
              <?php echo h(ucfirst($status_row['item_status'])); ?>
            </option>
          <?php endwhile;
          mysqli_free_result($statuses_result); ?>
        </select>
        
        <select name="category" onchange="this.form.submit()">
          <option value="">Category</option>
          <?php
          $categories_result = find_all_cats();
          while($category_row = mysqli_fetch_assoc($categories_result)): ?>
            <option value="<?php echo h($category_row['category']); ?>" <?php echo ($filter_category === $category_row['category']) ? 'selected' : ''; ?>>
              <?php echo h($category_row['category']); ?>
            </option>
          <?php endwhile;
          mysqli_free_result($categories_result); ?>
        </select>
        
        <?php if(!empty($filter_type) || !empty($filter_status) || !empty($filter_category)): ?>
          <a href="<?php echo url_for('/admin/items/index.php' . (!empty($search_term) ? '?search=' . urlencode($search_term) : '')); ?>" class="clear-filters">Clear Filters</a>
        <?php endif; ?>
      </form>
    </div>

  	<table class="list">
  	  <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Edition</th>
  	    <th>ISBN</th>
  	    <th>Type</th>
        <th>Publication year</th>
        <th>Copy</th>
  	    <th>Publisher ID</th>
  	    <th>Category</th>
  	    <th>Status</th>
  	    <th>Created</th>
  	    <th>Updated</th>
  	    <th>&nbsp;</th>
  	    <th>&nbsp;</th>
        <th>&nbsp;</th>
  	  </tr>

      <?php 
      // Handle different result types
      if($search_results !== null) {
          // Search results (array format)
          foreach($search_results as $item) {
      ?>
        <tr>
          <td><?php echo h($item['item_id']); ?></td>
          <td><?php echo h($item['title']); ?></td>
          <td><?php echo h($item['item_edition']);?></td>
    	  <td><?php echo h($item['isbn']); ?></td>
    	  <td><?php echo h($item['item_type']); ?></td>
          <td><?php echo h($item['publication_year']); ?></td>
          <td><?php echo h($item['item_copy']);?></td>
    	  <td><?php echo h($item['publisher_id']); ?></td>
    	  <td><?php echo h($item['category']); ?></td>
          <td><?php echo h($item['item_status']); ?></td>
          <td><?php echo $item['created_at'] ? h(date('d/m/Y', strtotime($item['created_at']))) : ''; ?></td>
    	  <td><?php echo $item['updated_at'] ? h(date('d/m/Y', strtotime($item['updated_at']))) : ''; ?></td>
          <td><a class="action2" href="<?php echo url_for('/admin/items/show.php?Page=1&id=' . h(u($item['item_id'])));?>">View</a></td>
          <td><a class="action2" href="<?php echo url_for('/admin/items/edit.php?id=' . h(u($item['item_id']))); ?>">Edit</a></td>
          <td><a class="action2" href="<?php echo url_for('/admin/items/delete.php?id=' . h(u($item['item_id']))); ?>">Delete</a></td>
    	  </tr>
      <?php 
          }
      } else {
          // Regular results (mysqli result format)
          while($item = mysqli_fetch_assoc($item_set)) { 
      ?>
        <tr>
          <td><?php echo h($item['item_id']); ?></td>
          <td><?php echo h($item['title']); ?></td>
          <td><?php echo h($item['item_edition']);?></td>
    	  <td><?php echo h($item['isbn']); ?></td>
    	  <td><?php echo h($item['item_type']); ?></td>
          <td><?php echo h($item['publication_year']); ?></td>
          <td><?php echo h($item['item_copy']);?></td>
    	  <td><?php echo h($item['publisher_id']); ?></td>
    	  <td><?php echo h($item['category']); ?></td>
          <td><?php echo h($item['item_status']); ?></td>
          <td><?php echo $item['created_at'] ? h(date('d/m/Y', strtotime($item['created_at']))) : ''; ?></td>
    	  <td><?php echo $item['updated_at'] ? h(date('d/m/Y', strtotime($item['updated_at']))) : ''; ?></td>
          <td><a class="action2" href="<?php echo url_for('/admin/items/show.php?Page=1&id=' . h(u($item['item_id'])));?>">View</a></td>
          <td><a class="action2" href="<?php echo url_for('/admin/items/edit.php?id=' . h(u($item['item_id']))); ?>">Edit</a></td>
          <td><a class="action2" href="<?php echo url_for('/admin/items/delete.php?id=' . h(u($item['item_id']))); ?>">Delete</a></td>
    	  </tr>
      <?php 
          } 
      } 
      ?>
  	</table>

<!-- free up storage of $item-set query above -->
	<?php
	if($item_set !== null) {
		mysqli_free_result($item_set);
	}
	?>

  </div>

</div>
      </main>
<?php include(SHARED_PATH . '/admin_footer.php'); ?>
