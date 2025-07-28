<?php 
require_once('../../../private/initialise.php'); 

if(!isset($_GET['id'])) {
	redirect_to(url_for('/admin/creators/index.php'));
}

$id = $_GET['id'];

if(is_post_request()) {
		
	$creator = [];
	$creator['creator_id'] = $id;
	$creator['creator_name']= $_POST['creator_name'] ?? '';
	$result = update_creator($creator);
	if($result === true) {
	redirect_to(url_for('/admin/creators/show.php?id=' . $id));
	   } else {
	    $errors = $result;
		//var_dump($errors);
	  }
	  
} else {
	
	$creator = find_creator_by_id($id);
	$creator_set = find_all_creators();
}   
?>
	
	<?php $page_title = 'Edit Creator'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>

<!-- html with embedded php to display a web form for editing creator -->
<!-- ("server side script for managing content") -->
<main aria-label="main content">
<div id="content">

  <a class = "back-link" href="<?php echo url_for('/admin/creators/index.php') ?>">&laquo; Back to List</a>
  
  <div class="creator edit">
    <h1>Edit Creator</h1>
    
     <?php echo display_errors($errors); ?>

    <form action="<?php echo url_for('/admin/creators/edit.php?id=' . h(u($id))); ?>" method="post">
      <dl>
        <dt>Creator id</dt>
        <!--cannot edit creator id, so it should be read only here -->
        <dd><?php echo h($creator['creator_id']); ?></dd>
      </dl>
      <dl>
        <dt>Creator name</dt>
        <dd><input type="text" name="creator_name" value="<?php echo h($creator['creator_name']); ?>" /></dd>
      </dl>
 	   <div id="operations">
        <input type="submit" value="Edit Creator" />
      </div>
    </form>

  </div>

</div>
</main>
<?php include(SHARED_PATH . '/admin_footer.php'); ?>






















