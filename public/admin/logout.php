<?php
require_once('../../private/init.php');

log_out_auth(); // Call the function to log out the user

redirect_to(url_for('/admin/login.php'));

?>
