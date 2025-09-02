<?php
require_once('../../private/init.php'); 

if (!is_logged_in()) {
    redirect_to(url_for('/login.php'));
}

// For GET: show the page; For POST: process the update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    if (!$id) {
        die('No circulation ID provided.');
    }
    $sql = "UPDATE circulation SET item_circulation_status='Return confirmation pending' WHERE circulation_id='" . db_escape($db, $id) . "' LIMIT 1";
    $result = mysqli_query($db, $sql);
    if (!$result) {
        die('Query failed: ' . mysqli_error($db));
    }
    redirect_to(url_for('/main/account.php'));
} else {
    $id = $_GET['id'] ?? '';
    if (!$id) {
        die('No circulation ID provided.');
    }
}
?>

<?php $page_title = 'Confirm Return'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<main>
    <h2>Confirm Return</h2>
    <form method="post">
        <input type="hidden" name="id" value="<?php echo h($id); ?>">
        <p>Are you sure you want to mark this item as returned?</p>
        <p>This will notify the library staff to check the item back in.</p>
        <p>Ensure item is placed in return box in library.</p>
        <button class="action3" type="submit">Yes, Return</button>
        <a class="action3" href="<?php echo url_for('/main/account.php'); ?>">Cancel</a>
    </form>
</main>

<?php include(SHARED_PATH . '/footer.php'); ?>