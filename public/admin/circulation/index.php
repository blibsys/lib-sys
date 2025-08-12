
<?php require_once('../../../private/init.php');

// Get filter and search values
$filter_status = isset($_GET['status']) ? trim($_GET['status']) : '';
$filter_borrow_date = isset($_GET['borrow_date']) ? trim($_GET['borrow_date']) : '';
$filter_due_date = isset($_GET['due_date']) ? trim($_GET['due_date']) : '';
$search_term = isset($_GET['search']) ? trim($_GET['search']) : '';

// Build the query based on filters and search
if(!empty($search_term) || !empty($filter_status) || !empty($filter_borrow_date) || !empty($filter_due_date)) {
    // Get all circulation records first
    $circulation_set = find_all_circ();
    $temp_circulations = [];
    while($row = mysqli_fetch_assoc($circulation_set)) {
        $temp_circulations[] = $row;
    }
    mysqli_free_result($circulation_set);
    
    // Apply search filtering if search term exists
    if(!empty($search_term)) {
        $temp_circulations = array_filter($temp_circulations, function($circulation) use ($search_term) {
            return stripos($circulation['circulation_id'], $search_term) !== false || 
                   stripos($circulation['user_id'], $search_term) !== false ||
                   stripos($circulation['item_id'], $search_term) !== false ||
                   stripos($circulation['item_circulation_status'], $search_term) !== false;
        });
    }
    
    // Apply filters
    if(!empty($filter_status) || !empty($filter_borrow_date) || !empty($filter_due_date)) {
        $filtered_circulations = [];
        foreach($temp_circulations as $circulation) {
            $include = true;
            
            if(!empty($filter_status) && $circulation['item_circulation_status'] !== $filter_status) {
                $include = false;
            }
            
            // Improved date filtering - extract date part and compare
            if(!empty($filter_borrow_date)) {
                $db_borrow_date = date('Y-m-d', strtotime($circulation['borrow_date']));
                $filter_borrow_formatted = date('Y-m-d', strtotime($filter_borrow_date));
                if($db_borrow_date !== $filter_borrow_formatted) {
                    $include = false;
                }
            }
            
            if(!empty($filter_due_date)) {
                $db_due_date = date('Y-m-d', strtotime($circulation['date_due_back']));
                $filter_due_formatted = date('Y-m-d', strtotime($filter_due_date));
                if($db_due_date !== $filter_due_formatted) {
                    $include = false;
                }
            }
            
            if($include) {
                $filtered_circulations[] = $circulation;
            }
        }
        $temp_circulations = $filtered_circulations;
    }
    
    $circulation_set = null;
    $search_results = $temp_circulations;
} else {
    $circulation_set = find_all_circ();
    $search_results = null;
}

?>

<?php $page_title = 'circulation'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>

<main aria-label="main content">
<div id="content">
  <div class="circulation listing">
    <h1>Circulation</h1>

    <div class="back-link-wrapper">
      <a class="back-link" href="<?php echo url_for('admin/index.php'); ?>">← Back to List</a>
    </div>

    <div class="actions">
      <!--<a class="action1" href="<?php echo url_for('/admin/circulation/new.php'); ?>">Add New Circulation</a>-->
      <form class="search-form" method="GET" action="">
        <!-- Preserve filter values when searching -->
        <?php if(!empty($filter_status)): ?>
          <input type="hidden" name="status" value="<?php echo h($filter_status); ?>">
        <?php endif; ?>
        <?php if(!empty($filter_borrow_date)): ?>
          <input type="hidden" name="borrow_date" value="<?php echo h($filter_borrow_date); ?>">
        <?php endif; ?>
        <?php if(!empty($filter_due_date)): ?>
          <input type="hidden" name="due_date" value="<?php echo h($filter_due_date); ?>">
        <?php endif; ?>
        
        <input type="text" name="search" placeholder="Search circulation..." value="<?php echo isset($_GET['search']) ? h($_GET['search']) : ''; ?>">
        <input type="submit" value="Search">
        <?php if(isset($_GET['search']) && !empty($_GET['search'])): ?>
          <a class="clear-link" href="<?php echo url_for('/admin/circulation/index.php'); ?>">Clear</a>
        <?php endif; ?>

        <?php 
          // Count results based on whether we have search results or all circulation records
          if($search_results !== null) {
              $count = count($search_results);
          } else {
              // For mysqli result, we need to count the rows
              $count = mysqli_num_rows($circulation_set);
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
        <select name="status" onchange="this.form.submit()">
          <option value="">Status</option>
          <?php
          // Get distinct statuses from circulation records
          $temp_set = find_all_circ();
          $statuses = [];
          while($row = mysqli_fetch_assoc($temp_set)) {
              if(!in_array($row['item_circulation_status'], $statuses)) {
                  $statuses[] = $row['item_circulation_status'];
              }
          }
          mysqli_free_result($temp_set);
          sort($statuses);
          
          foreach($statuses as $status): ?>
            <option value="<?php echo h($status); ?>" <?php echo ($filter_status === $status) ? 'selected' : ''; ?>>
              <?php echo h(ucfirst($status)); ?>
            </option>
          <?php endforeach; ?>
        </select>
        
        <input type="date" name="borrow_date" value="<?php echo h($filter_borrow_date); ?>" onchange="this.form.submit()" title="Filter by borrow date">
        
        <input type="date" name="due_date" value="<?php echo h($filter_due_date); ?>" onchange="this.form.submit()" title="Filter by due date">
        
        <?php if(!empty($filter_status) || !empty($filter_borrow_date) || !empty($filter_due_date)): ?>
          <a href="<?php echo url_for('/admin/circulation/index.php' . (!empty($search_term) ? '?search=' . urlencode($search_term) : '')); ?>" class="clear-filters">Clear Filters</a>
        <?php endif; ?>
      </form>
    </div>

  	<table class="list">
  	  <tr>
        <th>ID</th>
        <th>User ID</th>
        <th>Item ID</th>
  	    <th>Borrow date</th>
  	    <th>Date due back</th>
        <th>Returned date</th>
        <th>Next reminder date</th>
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
          foreach($search_results as $circ) {
      ?>
        <tr>
          <td><?php echo h($circ['circulation_id']); ?></td>
          <td><?php echo h($circ['user_id']); ?></td>
          <td><?php echo h($circ['item_id']);?></td>
    	  <td><?php echo $circ['borrow_date'] ? h(date('d/m/Y', strtotime($circ['borrow_date']))) : ''; ?></td>
    	  <td><?php echo $circ['date_due_back'] ? h(date('d/m/Y', strtotime($circ['date_due_back']))) : ''; ?></td>
          <td><?php echo ($circ['returned_date'] ?? '') ? h(date('d/m/Y', strtotime($circ['returned_date']))) : ''; ?></td>
          <td><?php echo $circ['next_reminder_date'] ? h(date('d/m/Y', strtotime($circ['next_reminder_date']))) : ''; ?></td>
          <td><?php echo h($circ['item_circulation_status']); ?></td>
          <td><?php echo $circ['created_at'] ? h(date('d/m/Y', strtotime($circ['created_at']))) : ''; ?></td>
    	  <td><?php echo $circ['updated_at'] ? h(date('d/m/Y', strtotime($circ['updated_at']))) : ''; ?></td>
          <td><a class="action2" href="<?php echo url_for('/admin/circulation/show.php?Page=1&id=' . h(u($circ['circulation_id'])));?>">View</a></td>
          <td><a class="action2" href="<?php echo url_for('/admin/circulation/edit.php?id=' . h(u($circ['circulation_id']))); ?>">Edit</a></td>
          <td><a class="action2" href="">Delete</a></td>
    	  </tr>
      <?php 
          }
      } else {
          // Regular results (mysqli result format)
          while($circ = mysqli_fetch_assoc($circulation_set)) { 
      ?>
        <tr>
          <td><?php echo h($circ['circulation_id']); ?></td>
          <td><?php echo h($circ['user_id']); ?></td>
          <td><?php echo h($circ['item_id']);?></td>
    	  <td><?php echo $circ['borrow_date'] ? h(date('d/m/Y', strtotime($circ['borrow_date']))) : ''; ?></td>
    	  <td><?php echo $circ['date_due_back'] ? h(date('d/m/Y', strtotime($circ['date_due_back']))) : ''; ?></td>
          <td><?php echo ($circ['returned_date'] ?? '') ? h(date('d/m/Y', strtotime($circ['returned_date']))) : ''; ?></td>
          <td><?php echo $circ['next_reminder_date'] ? h(date('d/m/Y', strtotime($circ['next_reminder_date']))) : ''; ?></td>
          <td><?php echo h($circ['item_circulation_status']); ?></td>
          <td><?php echo $circ['created_at'] ? h(date('d/m/Y', strtotime($circ['created_at']))) : ''; ?></td>
    	  <td><?php echo $circ['updated_at'] ? h(date('d/m/Y', strtotime($circ['updated_at']))) : ''; ?></td>
          <td><a class="action2" href="<?php echo url_for('/admin/circulation/show.php?Page=1&id=' . h(u($circ['circulation_id'])));?>">View</a></td>
          <td><a class="action2" href="<?php echo url_for('/admin/circulation/edit.php?id=' . h(u($circ['circulation_id']))); ?>">Edit</a></td>
          <td><a class="action2" href="">Delete</a></td>
    	  </tr>
      <?php 
          }
      } ?>
  	</table>

<!-- free up storage of $circulation-set query above -->
	<?php
	if($circulation_set !== null) {
		mysqli_free_result($circulation_set);
	}
	?>

  </div>

  </div>
 </main>
<?php include(SHARED_PATH . '/admin_footer.php'); ?>
