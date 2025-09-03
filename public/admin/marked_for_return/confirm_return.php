<?php
require_once('../../../private/init.php');
if(!isset($_SESSION['role']) || strtolower($_SESSION['role']) !== 'admin') {
  echo "Permission denied.";
  exit;
}

$circulation_id = $_POST['circulation_id'] ?? null;
if(!$circulation_id) {
  echo "Missing circulation ID.";
  exit;
}

$sql = "UPDATE circulation SET item_circulation_status = 'returned', returned_date = NOW(), updated_at = NOW() WHERE circulation_id = '" . db_escape($db, $circulation_id) . "'";
$result = mysqli_query($db, $sql);

if($result && mysqli_affected_rows($db) > 0) {
  echo "Item status changed to returned.";
} else {
  echo "Error updating status.";
}
?>