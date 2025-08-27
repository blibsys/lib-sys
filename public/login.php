<?php
require_once('../private/init.php');

$errors = [];
$username = '';
$password = '';
if(is_post_request()) {

  $username = $_POST['username'] ?? '';
  $password = $_POST['password'] ?? '';

  // validations
  if(is_blank($username)) {
    $errors[] = "Username cannot be blank.";
  }
  if(is_blank($password)) {
    $errors[] = "Password cannot be blank.";
  }
  // if there were no errors, try to login
  if(empty($errors)) {
    // using one variable ensures message consistency
      $login_failure_msg = "Login was unsuccessful.";
      $auth = find_auth_by_username($username);
      if($auth) {
  
      if(password_verify($password, $auth['hashed_password'])) {
        // password matches
        log_in_auth($auth);
        $_SESSION['role'] = $auth['role'];
        redirect_to(url_for('/user/index.php'));
  } else {
    // username found, but password does not match
    $errors[] = $login_failure_msg;
  }
  } else {
    // no username found
    $errors[] = $login_failure_msg;
  }
  }}

   
?>

<?php $page_title = 'Log in'; ?>
<?php include(SHARED_PATH . '/login_header.php'); ?>

<main aria-label="main content">
<div id="content">
  <h1>Log in</h1>

  <?php echo display_errors($errors); ?>

  <form action="login.php" method="post">
    <div class="form-row">
      <dl>
        <dt>Username</dt>
        <dd><input type="text" name="username" value="<?php echo h($username); ?>" /></dd>
      </dl>
    </div>
    <div class="form-row">
      <dl>
        <dt>Password</dt>
        <dd><input type="password" name="password" value="" /></dd>
      </dl>
    </div>
      <div id="operations">
      <input type="submit" name="submit" value="Submit" />
    </div>
    </div>
  </form> 
</div>
</main>
<?php include(SHARED_PATH . '/footer.php'); ?>

