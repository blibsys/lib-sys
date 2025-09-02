<?php
 require_once('../../private/init.php'); 

// Require login
if (!is_logged_in()) {
    redirect_to(url_for('/login.php'));
}

$circulation_id = $_GET['id'] ?? '';

if (empty($circulation_id)) {
    redirect_to(url_for('/main/index.php'));
}

$circulation = find_circulation_by_id($circulation_id);
if (!$circulation) {
    redirect_to(url_for('/main/index.php'));
}

// Make sure this circulation record belongs to the logged in user
if ($circulation['user_id'] != $_SESSION['user_id']) {
    redirect_to(url_for('/main/index.php'));
}

?>

<?php $page_title = 'Borrowing Successful'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<main aria-label="main content">
<div id="content">

    <div class="success-message">
        <h2>✓ Item Borrowed Successfully!</h2>
        
        <div class="circulation-details">
            <h2>Loan Details</h2>
            
            <div class="attributes">
                <dl>
                    <dt>Loan ID</dt>
                    <dd><?php echo h($circulation['circulation_id']); ?></dd>
                </dl>
                 <dl>
                    <dt>Item ID</dt>
                    <dd><?php echo h($circulation['item_id']); ?></dd>
                </dl>
                <dl>
                    <dt>Item Title</dt>
                    <dd><?php echo h($circulation['title']); ?></dd>
                </dl>
                <dl>
                    <dt>User Name</dt>
                    <dd><?php echo h($circulation['first_name']) . ' ' . h($circulation['last_name']); ?></dd>
                </dl>
                <dl>
                    <dt>User ID</dt>
                    <dd><?php echo h($circulation['user_id']); ?></dd>
                </dl>
                <dl>
                    <dt>Borrow Date</dt>
                    <dd><?php echo $circulation['borrow_date'] ? date('d/m/Y', strtotime($circulation['borrow_date'])) : ''; ?></dd>
                </dl>
                <dl>
                    <dt>Date Due Back</dt>
                    <dd><?php echo $circulation['date_due_back'] ? date('d/m/Y', strtotime($circulation['date_due_back'])) : 'To be determined'; ?></dd>
                </dl>
                
            </div>
        </div>
        
        <div class="actions">
            <a class="action1" href="<?php echo url_for('/main/index.php'); ?>">Back to Library</a>
            <a class="action1" href="<?php echo url_for('/main/account.php'); ?>">View My Loans</a>
        </div>
    </div>

</div>
</main>

<?php include(SHARED_PATH . '/footer.php'); ?>