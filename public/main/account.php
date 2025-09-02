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

    <div class="borrowed-items">
        <h2>Current Items on Loan</h2>
        
        <?php if (mysqli_num_rows($borrowed_items) == 0): ?>
            <p>You haven't borrowed any items yet.</p>
        <?php else: ?>
            <table class="list">
                    <tr>
                        <th>Item ID</th>
                        <th>Circulation ID</th>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Borrow date</th>
                        <th>Due back</th>
                        <th>Days left</th>
                        <th>Status</th>
                        <th>Renew</th>
                        <th>Return</th>
                    </tr>
               
                    <?php while($record = mysqli_fetch_assoc($borrowed_items)): ?>
                        <?php if (strtolower($record['item_circulation_status']) !== 'on-loan') continue; ?>
                    <tr>
                        <td><?php echo h($record['item_id']); ?></td>
                        <td><?php echo h($record['circulation_id']); ?></td>
                        <td><?php echo h($record['title']); ?></td>
                        <td><?php echo h($record['item_type']); ?></td>
                        <td><?php echo $record['borrow_date'] ? date('d/m/Y', strtotime($record['borrow_date'])) : ''; ?></td>
                        <td><?php echo $record['date_due_back'] ? date('d/m/Y', strtotime($record['date_due_back'])) : 'TBD'; ?></td>
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
                        <td><a class="action3" href="">Renew</a></td>
                        <td><a class="action3" href="<?php echo url_for('/main/return_confirm.php?id=' . h($record['item_id'])); ?>">Return</a></td>
                    </tr>
                    <?php endwhile; ?>
            </table>
        <?php endif; ?>
        
        <?php mysqli_free_result($borrowed_items); ?>
    </div>

</div>
</main>

<?php include(SHARED_PATH . '/footer.php'); ?>