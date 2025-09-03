<?php
require_once('../../private/init.php'); 

// Require login
if (!is_logged_in()) {
    redirect_to(url_for('/login.php'));
}

// Function to get user's borrowed items
function find_user_circulation_records($user_id) {
    global $db;
    $sql = "SELECT c.*, i.title, i.item_type ";
    $sql .= "FROM circulation c ";
    $sql .= "LEFT JOIN items i ON i.item_id = c.item_id ";
    $sql .= "WHERE c.user_id='" . db_escape($db, $user_id) . "' ";
    $sql .= "ORDER BY c.borrow_date DESC";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
}

$borrowed_items = find_user_circulation_records($_SESSION['user_id']);

?>

<?php $page_title = 'Curent Loans'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<main aria-label="main content">
<div id="content">

    <a class="back-to-results" href="<?php echo url_for('/main/index.php'); ?>">← Back to Library</a>

        <?php
$on_loan = [];
$return_pending = [];
$returned = [];

while($record = mysqli_fetch_assoc($borrowed_items)) {
    $status = strtolower($record['item_circulation_status']);
    if ($status === 'on-loan') {
        $on_loan[] = $record;
    } elseif ($status === 'return confirmation pending') {
        $return_pending[] = $record;
    } elseif ($status === 'returned') {
        $returned[] = $record;
    }
}
mysqli_free_result($borrowed_items);
?>

<h1>My Loans</h1>
<div class="borrowed-items">
    <!-- Collapsible: Current Items on Loan -->
    <h2>
        Current Items on Loan (<span><?php echo count($on_loan); ?></span>)
        <button class="toggle-btn" data-target="onLoanTable" <?php if(count($on_loan)==0) echo 'disabled'; ?>>+</button>
    </h2>
    <div id="onLoanTable" class="collapsible-table" style="display:none;">
        <?php if (count($on_loan) == 0): ?>
            <p>You haven't borrowed any items yet.</p>
        <?php else: ?>
            <table class="list">
                <tr>
                    <th>Item ID</th>
                    <th>Loan ID</th>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Borrow Date</th>
                    <th>Due Back</th>
                    <th>Days Left</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                <?php foreach($on_loan as $record): ?>
                <tr>
                    <td><?php echo h($record['item_id']); ?></td>
                    <td><?php echo h($record['circulation_id']); ?></td>
                    <td><?php echo h($record['title']); ?></td>
                    <td><?php echo h($record['item_type']); ?></td>
                    <td><?php echo h($record['borrow_date']) ? date('d/m/Y', strtotime($record['borrow_date'])) : ''; ?></td>
                    <td><?php echo h($record['date_due_back']) ? date('d/m/Y', strtotime($record['date_due_back'])) : 'TBD'; ?></td>
                    <td>    
                         <?php
                if ($record['date_due_back']) {
                    $due = new DateTime($record['date_due_back']);
                    $today = new DateTime();
                    $interval = $today->diff($due);
                    echo $due < $today ? 'Overdue' : $interval->days . ' days';
                } else {
                    echo 'TBD';
                }
                ?>
            </td>
            <td>
                            <span class="status <?php echo strtolower(str_replace('-', '', $record['item_circulation_status'])); ?>">
                                <?php echo h($record['item_circulation_status']); ?>
                            </span>
                        </td>
                       <td>
                        <button class="renew-btn" data-circulation-id="<?php echo h($record['circulation_id']); ?>">Renew</button>
                        <button class="return-btn" data-circulation-id="<?php echo h($record['circulation_id']); ?>">Return</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>

    <!-- Collapsible: Items Marked for Return -->
    <h2>
        Items Marked for Return (<span><?php echo count($return_pending); ?></span>)
        <button class="toggle-btn" data-target="returnPendingTable" <?php if(count($return_pending)==0) echo 'disabled'; ?>>+</button>
    </h2>
    <div id="returnPendingTable" class="collapsible-table" style="display:none;">
        <?php if (count($return_pending) == 0): ?>
            <p>No items pending return confirmation.</p>
        <?php else: ?>
            <table class="list">
                <tr>
                    <th>Item ID</th>
                    <th>Loan ID</th>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Borrow Date</th>
                    <th>Due Back</th>
                    <th>Status</th>
                </tr>
                <?php foreach($return_pending as $record): ?>
                <tr>
                    <td><?php echo h($record['item_id']); ?></td>
                    <td><?php echo h($record['circulation_id']); ?></td>
                    <td><?php echo h($record['title']); ?></td>
                    <td><?php echo h($record['item_type']); ?></td>
                    <td><?php echo h($record['borrow_date']) ? date('d/m/Y', strtotime($record['borrow_date'])) : ''; ?></td>
                    <td><?php echo h($record['date_due_back']) ? date('d/m/Y', strtotime($record['date_due_back'])) : 'TBD'; ?></td>
                    <td><?php echo h($record['item_circulation_status']); ?></td>
                </tr>
            
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>

    <!-- Collapsible: Past Loans -->
    <h2>
        Past Loans (<span><?php echo count($returned); ?></span>)
        <button class="toggle-btn" data-target="returnedTable" <?php if(count($returned)==0) echo 'disabled'; ?>>+</button>
    </h2>
    <div id="returnedTable" class="collapsible-table" style="display:none;">
        <?php if (count($returned) == 0): ?>
            <p>No past loans.</p>
        <?php else: ?>
            <table class="list">
                <tr>
                    <th>Item ID</th>
                    <th>Loan ID</th>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Borrow Date</th>
                    <th>Returned Date</th>
                    <th>Status</th>
                </tr>
                <?php foreach($returned as $record): ?>
                <tr>
                    <td><?php echo h($record['item_id']); ?></td>
                    <td><?php echo h($record['circulation_id']); ?></td>
                    <td><?php echo h($record['title']); ?></td>
                    <td><?php echo h($record['item_type']); ?></td>
                    <td><?php echo h($record['borrow_date']) ? date('d/m/Y', strtotime($record['borrow_date'])) : ''; ?></td>
                    <td><?php echo h($record['returned_date']) ? date('d/m/Y', strtotime($record['returned_date'])) : 'TBD'; ?></td>
                    <td><?php echo h($record['item_circulation_status']); ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
</div>

</div>
<script>
document.querySelectorAll('.return-btn').forEach(function(btn) {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        if (confirm('Are you sure you want to mark this item as returned? This will notify the library staff to check the item back in. Please ensure item is placed in return box in library.')) {
            var circulationId = btn.getAttribute('data-circulation-id');
            fetch('return_item.php', { 
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'circulation_id=' + encodeURIComponent(circulationId)
            })
            .then(response => response.text())
            .then(result => {
                alert(result.trim());
                window.location.reload();
            });
        } else {
            window.location.href = 'account.php';
        }
    });
});

document.querySelectorAll('.renew-btn').forEach(function(btn) {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        if (confirm('Renew this item? Renewal is subject to eligibility.')) {
            var circulationId = btn.getAttribute('data-circulation-id');
            fetch('renew_item.php', { 
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
document.querySelectorAll('.toggle-btn').forEach(function(btn) {
    btn.addEventListener('click', function() {
        var target = document.getElementById(btn.getAttribute('data-target'));
        if (target) {
            var isOpen = (target.style.display === 'block');
            target.style.display = isOpen ? 'none' : 'block';
            btn.textContent = isOpen ? '+' : '−';
        }
    });
});
</script>
</main>

<?php include(SHARED_PATH . '/footer.php'); ?>