<?php require_once('../../../private/init.php'); ?>

<?php

$user_set = find_all_users();

?>

<?php $user_title = 'users'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>

<main aria-label="main content">
<div id="content">
  <div class="users listing">
    <h1>Users</h1>
    
    <div class="back-link-wrapper">
      <a class="back-link" href="<?php echo url_for('admin/index.php'); ?>">← Back to List</a>
    </div>
    
    <div class="actions">
      <a class="action1" href="<?php echo url_for('/admin/users/new.php'); ?>">Add New user</a>
    </div>
    
    <table class="list">
  	  <tr>
        <th>ID</th>
        <th>First name</th>
        <th>Last name</th>
  	    <th>Start date</th>
  	    <th>End date</th>
  	    <th>Role</th>
  	    <th>Email</th>
  	    <th>Course ID</th>
  	    <th>Created</th>
  	    <th>Updated</th>
  	    <th>&nbsp;</th>
  	    <th>&nbsp;</th>
        <th>&nbsp;</th>
  	  </tr>

      <?php while($user = mysqli_fetch_assoc($user_set)) { ?>
        <tr>
          <td><?php echo h($user['user_id']); ?></td>
          <td><?php echo h($user['first_name']); ?></td>
          <td><?php echo h($user['last_name']); ?></td>
    	  <td><?php echo h($user['user_start_date']); ?></td>
    	  <td><?php echo h($user['user_end_date']); ?></td>
          <td><?php echo h($user['role']); ?></td>
          <td><?php echo h($user['email']); ?></td>
    	  <td><?php echo h($user['course_id']); ?></td>
    	  <td><?php echo h($user['created_at']); ?></td>
    	  <td><?php echo h($user['updated_at']); ?></td>
          <td><a class="action2" href="<?php echo url_for('/admin/users/show.php?user=1&id=' . h(u($user['user_id'])));?>">View</a></td>
          <td><a class="action2" href="<?php echo url_for('/admin/users/edit.php?id=' . h(u($user['user_id']))); ?>">Edit</a></td>
          <td><a class="action2" href="<?php echo url_for('/admin/users/delete.php?id=' . h(u($user['user_id']))); ?>">Delete</a></td>
    	  </tr>
      <?php } ?>
  	</table>
    
      </div>

</div>
      </main>
<?php include(SHARED_PATH . '/admin_footer.php'); ?>
    