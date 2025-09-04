<?php
require_once('../../../private/init.php');
if(isset($_SESSION['role']) && strtolower($_SESSION['role']) !== 'admin') {
  echo "You do not have permission to access this page.";
  exit; 
}

// Only show records with status 'return confirmation pending'
$sql = "SELECT * FROM circulation WHERE item_circulation_status = 'return confirmation pending' ORDER BY borrow_date DESC";
$circulation_set = mysqli_query($db, $sql);
confirm_result_set($circulation_set);
$count = mysqli_num_rows($circulation_set);
?>
<?php $page_title = 'Marked for Return'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<main aria-label="main content">
<div id="content">
  <div class="circulation listing">
    <h1>Marked for Return List</h1>
    <div class="back-link-wrapper">
      <a class="back-link" href="<?php echo url_for('admin/index.php'); ?>">← Back to List</a>
    </div>
    <p><?php echo h($count) . ' ' . ($count === 1 ? 'Result' : 'Results'); ?></p>
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
      <?php while($circulation = mysqli_fetch_assoc($circulation_set)) { ?>
        <tr>
          <td><?php echo h($circulation['circulation_id']); ?></td>
          <td><?php echo h($circulation['user_id']); ?></td>
          <td><?php echo h($circulation['item_id']);?></td>
          <td><?php echo $circulation['borrow_date'] ? h(date('d/m/Y', strtotime($circulation['borrow_date']))) : ''; ?></td>
          <td><?php echo $circulation['date_due_back'] ? h(date('d/m/Y', strtotime($circulation['date_due_back']))) : ''; ?></td>
          <td><?php echo ($circulation['returned_date'] ?? '') ? h(date('d/m/Y', strtotime($circulation['returned_date']))) : ''; ?></td>
          <td><?php echo $circulation['next_reminder_date'] ? h(date('d/m/Y', strtotime($circulation['next_reminder_date']))) : ''; ?></td>
          <td><?php echo h($circulation['item_circulation_status']); ?></td>
          <td><?php echo $circulation['created_at'] ? h(date('d/m/Y', strtotime($circulation['created_at']))) : ''; ?></td>
          <td><?php echo $circulation['updated_at'] ? h(date('d/m/Y', strtotime($circulation['updated_at']))) : ''; ?></td>
          <td>
            <button class="confirm-return-btn" data-circulation-id="<?php echo h($circulation['circulation_id']); ?>">Confirm Return</button>
          </td>
        </tr>
      <?php } ?>
    </table>
    <?php mysqli_free_result($circulation_set); ?>
  </div>
</div>
<script>
document.querySelectorAll('.confirm-return-btn').forEach(function(btn) {
  btn.addEventListener('click', function() {
    if (confirm('Update item status to "returned"?')) {
      var circulationId = btn.getAttribute('data-circulation-id');
      fetch('confirm_return.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'circulation_id=' + encodeURIComponent(circulationId)
      })
      .then(response => response.text())
      .then(result => {
        alert(result.trim());
        window.location.reload();
      });
    }
  });
});
</script>

</main>
<?php include(SHARED_PATH . '/footer.php'); ?>