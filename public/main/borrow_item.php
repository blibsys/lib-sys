<?php require_once('../../private/init.php'); 

// Require login to borrow items
if (!is_logged_in()) {
    redirect_to(url_for('/login.php'));
}

$item_id = $_GET['id'] ?? '';
$backurl = $_GET['backurl'] ?? url_for('/main/index.php');

if (empty($item_id)) {
    redirect_to($backurl);
}

$item = find_item_by_id($item_id);
if (!$item) {
    redirect_to($backurl);
}

// Check if item is available
if ($item['item_status'] !== 'Available') {
    redirect_to($backurl);
}

$errors = [];

if (is_post_request()) {
    // Process the borrowing
    $circulation = [
        'user_id' => $_SESSION['user_id'],
        'item_id' => $item_id,
        'borrow_date' => date('Y-m-d') // Today's date
    ];
    
    $result = insert_circulation($circulation);
    
    if ($result === true) {
        // Get the circulation ID for the newly created record
        global $db;
        $circulation_id = mysqli_insert_id($db);
        
        // Redirect to success page
        redirect_to(url_for('/main/borrow_success.php?id=' . $circulation_id));
    } else {
        $errors = $result;
    }
}

?>

<?php $page_title = 'Borrow Item'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<main aria-label="main content">
<div id="content">

    <a class="back-to-results" href="<?php echo h($backurl); ?>">← Back</a>

    <div class="item borrow">
        <h2>Review Loan Details</h2>
        
        <?php echo display_errors($errors); ?>
        
        <div class="item-details">
            
            <h2><?php echo h($item['title']); ?></h2>
            <p><?php echo h($item['item_type']); ?></p>
            <p><?php echo h($item['contributors']); ?></p>
            <p><?php echo h($item['item_status']); ?></p>
            <p>
        </div>
        
        <div class="borrower-details">
            <h2>Borrower details</h2>
            <p>Name: <?php echo h($_SESSION['username']); ?></p>
            <p>ID: <?php echo h($_SESSION['user_id']); ?></p>
            
        </div>
        
        <form action="<?php echo url_for('/main/borrow_item.php?id=' . h($item_id) . '&backurl=' . urlencode($backurl)); ?>" method="post">
            <div id="operations">
                <input type="submit" value="Confirm Loan" />
                <a class="action1"href="<?php echo h($backurl); ?>">Cancel</a>
            </div>
        </form>
    </div>

</div>
</main>

<?php include(SHARED_PATH . '/footer.php'); ?>
