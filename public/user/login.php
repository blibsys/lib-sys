<?php 
require_once('../../private/init.php');
$errors = [];
$username = '';
$password = '';

if(is_post_request()) {

  $username = $_POST['username'] ?? '';
  $password = $_POST['password'] ?? '';

  $_SESSION['username'] = $username;

  redirect_to(url_for('/user/index.php'));
}

?>

<?php $page_title = 'Log in'; ?>
<?php include(SHARED_PATH . '/user_header.php'); ?>

<main aria-label="main content">
<div id="content">
  <h1>Log in</h1>

  <?php echo display_errors($errors); ?>

  <form action="login.php" method="post">
    Username:<br />
    <input type="text" name="username" value="<?php echo h($username); ?>" /><br />
    Password:<br />
    <input type="password" name="password" value="" /><br />
    <input type="submit" name="submit" value="Submit"  />
  </form>

</div>

</main>
<?php include(SHARED_PATH . '/user_footer.php'); ?>
