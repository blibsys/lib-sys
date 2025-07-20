<?php 
require_once('../../../private/initialise.php'); 

if(!isset($_GET['id'])) {
	redirect_to(url_for('/admin/creators/index.php'));
}

$id = $_GET['id'];

if(is_post_request()) {
		
	$creator = [];
	$creator['id'] = $id;
	$creator['creator_name']= $_POST['creator_name'] ?? '';
	
	$sql = "UPDATE creators SET ";
	$sql .= "creator_name='" . $creator['creator_name'] . "' ";
	$sql .= "WHERE creator_id='" . $id . "'";
	$sql .= "LIMIT 1";

	$result = mysqli_query($db, $sql);
	// for UPDATE statements, $result is true/false
	if($result) {
	  redirect_to(url_for('/admin/creators/show.php?id=' . $id));
	} else {
	  // update failed
	  echo mysqli_error($db);
	  db_disconnect($db);
	  exit;
	  
	}

} else {
	
	$creator = find_creator_by_id($id);

}   
?>
	
	<?php $page_title = 'Edit Creator'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>

<!-- html with embedded php to display a web form for editing creator -->
<!-- ("server side script for managing content") -->

<div id="content">

  <a class = "back-link" href="<?php echo url_for('/admin/creators/index.php') ?>">&laquo; Back to List</a>
  
  <div class="creator edit">
    <h1>Edit Creator</h1>

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

<?php include(SHARED_PATH . '/admin_footer.php'); ?>






















