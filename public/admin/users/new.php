<?php

require_once('../../../private/initialise.php'); 

?>

<?php $page_title = 'Add user'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>

<!-- ("server side script for managing content") -->
<!-- need to add validation to the forms -->
<div id="content">

  <a class="back-link" href="<?php echo url_for('/admin/users/index.php'); ?>">&laquo; Back to List</a>

  <div class="user new">
    <h1>Add user</h1>

    <form action="<?php echo url_for('/admin/users/create.php'); ?>" method="post">
      <dl>
        <dt>User id</dt>
        <dd><input type="text" name="user_id" value="" /></dd>
      </dl>
      <dl>
        <dt>First name</dt>
        <dd><input type="text" name="first_name" value="" /></dd>
      </dl>
      <dl>
        <dt>Last name</dt>
        <dd><input type="text" name="last_name" value="" /></dd>
      </dl>
      <dl>
        <dt>Start date</dt>
        <dd><input type="text" name="user_start_date" value="" /></dd>
      </dl>
      <dl>
        <dt>End date</dt>
        <dd><input type="text" name="user_end_date" value="" /></dd>
      </dl>
      <dl>
        <dt>Type</dt>
        <dd><input type="text" name="user_type" value="" /></dd>
      </dl>
      <dl>
        <dt>Email</dt>
        <dd><input type="text" name="email" value="" /></dd>
      </dl>
      <dl>
        <dt>Course ID</dt>
        <dd><input type="text" name="course_id" value="" /></dd>
      </dl>
      
      <div id="operations">
        <input type="submit" value="Add User" />
      </div>
      
    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/admin_footer.php'); ?>