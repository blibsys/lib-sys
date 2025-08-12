<?php 
require_once('../../../private/init.php'); 

if(!isset($_GET['id'])) {
	redirect_to(url_for('/admin/contributors/index.php'));
}

$id = $_GET['id'];

if(is_post_request()) {
		
	$contributor = [];
	$contributor['contributor_id'] = $id;
	$contributor['contributor_name']= $_POST['contributor_name'] ?? '';
	$result = update_contributor($contributor);
	if($result === true) {
    $_SESSION['message'] = 'contributor updated successfully.';
	redirect_to(url_for('/admin/contributors/show.php?id=' . $id));
	   } else {
	    $errors = $result;
		//var_dump($errors);
	  }
	  
} else {
	
	$contributor = find_contributor_by_id($id);
	$contributor_set = find_all_contributors();
}   
?>
	
	<?php $page_title = 'Edit contributor'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>

<!-- html with embedded php to display a web form for editing contributor -->
<!-- ("server side script for managing content") -->
<main aria-label="main content">
<div id="content">

  <a class = "back-link" href="<?php echo url_for('/admin/contributors/index.php') ?>">← Back to List</a>
  
  <div class="contributor edit">
    <h2>Edit Contributor</h2>
    
     <?php echo display_errors($errors); ?>

    <form class="admin-form1" action="<?php echo url_for('/admin/contributors/edit.php?id=' . h(u($id))); ?>" method="post">
    <div class="form-row">  
    <dl>
        <dt>contributor ID</dt>
        <!--cannot edit contributor id, so it should be read only here -->
        <dd><?php echo h($contributor['contributor_id']); ?></dd>
      </dl>
      </div>
      <div class="form-row">
      <dl>
        <dt>contributor name</dt>
        <dd><input type="text" name="contributor_name" value="<?php echo h($contributor['contributor_name']); ?>" /></dd>
      </dl>
      </div>
 	   <div id="operations">
        <input type="submit" value="Edit Contributor" />
      </div>
    </form>

  </div>

</div>
</main>
<?php include(SHARED_PATH . '/admin_footer.php'); ?>






















