<?php

require_once('../../private/init.php'); 

if (!is_logged_in()) {
    echo "You must be logged in.";
    exit;
}

$circulation_id = $_POST['circulation_id'] ?? null;

if (!$circulation_id) {
    echo "Missing circulation ID.";
    exit;
}

// Get circulation record
$sql = "SELECT c.*, u.user_end_date FROM circulation c LEFT JOIN users u ON c.user_id = u.user_id WHERE c.circulation_id = '" . db_escape($db, $circulation_id) . "'";
$result = mysqli_query($db, $sql);
if (!$result || mysqli_num_rows($result) == 0) {
    echo "Loan not found.";
    exit;
}
$record = mysqli_fetch_assoc($result);

// Condition 1: borrow_date < 1 year ago
$borrow_date = new DateTime($record['borrow_date']);
$one_year_ago = (new DateTime())->modify('-1 year');
if ($borrow_date < $one_year_ago) {
    echo "Cannot renew - item must be returned after 1 year. Please contact library staff.";
    exit;
}

// Condition 2: user_end_date > 1 month from today
$user_end_date = $record['user_end_date'] ? new DateTime($record['user_end_date']) : null;
$one_month_later = (new DateTime())->modify('+1 month');
if (!$user_end_date || $user_end_date < $one_month_later) {
    echo "Cannot renew - account expires in less than 1 month.";
    exit;
}

// Calculate new due date
$current_due = new DateTime($record['date_due_back']);
$new_due = clone $current_due;
$new_due->modify('+30 days');

// Max due date: 1 year from borrow date or user_end_date, whichever is earlier
$max_due = min(
    (clone $borrow_date)->modify('+1 year'),
    $user_end_date
);
if ($new_due > $max_due) {
    $new_due = $max_due;
}

// Update due date
$sql = "UPDATE circulation SET date_due_back = '" . $new_due->format('Y-m-d') . "', updated_at = NOW() WHERE circulation_id = '" . db_escape($db, $circulation_id) . "'";
$update = mysqli_query($db, $sql);

if ($update && mysqli_affected_rows($db) > 0) {
    echo "Renewal successful! New due date: " . $new_due->format('d/m/Y');
} else {
    echo "Renewal failed. Please contact library staff.";
}
?>