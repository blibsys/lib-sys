<?php require_once('../../../private/init.php'); 
if(isset($_SESSION['role']) && strtolower($_SESSION['role']) !== 'admin') {
  //if user not admin
  echo "You do not have permission to access this page.";
  exit; 
}
$page_title = '...'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>
<main aria-label="main content">
<div id="content">


</div>
</main>

<?php include(SHARED_PATH . '/footer.php'); ?>