
<?php
require_once('../../private/init.php'); 

if (!is_logged_in()) {
    http_response_code(403);
    exit;
}

$circulation_id = $_POST['circulation_id'] ?? null;

if ($circulation_id) {
    $sql = "UPDATE circulation SET item_circulation_status = 'Return confirmation pending', updated_at = NOW() WHERE circulation_id = '" . db_escape($db, $circulation_id) . "'";
    $result = mysqli_query($db, $sql);
   
if ($result) {
    echo "Return request submitted. Library staff will confirm your return soon.";
} else {
    echo "Error processing return.";
}

    
} else {
    echo "Missing loan ID - contact library staff";
}
?>