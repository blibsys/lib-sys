<?php 
require_once('../../../private/initialise.php'); 

if(!isset($_GET['id'])) {
	redirect_to(url_for('/admin/publishers/index.php'));
}

$id = $_GET['id'];

if(is_post_request()) {

	$publisher = [];
	$publisher['id'] = $id;
	$publisher['publisher_name']= $_POST['publisher_name'] ?? '';
	
	$sql = "UPDATE publishers SET ";
	$sql .= "publisher_name='" . $publisher['publisher_name'] . "' ";
	$sql .= "WHERE publisher_id='" . $id . "'";
	$sql .= "LIMIT 1";

	$result = mysqli_query($db, $sql);
	// for UPDATE statements, $result is true/false
	if($result) {
	  redirect_to(url_for('/admin/publishers/show.php?id=' . $id));
	} else {
	  // update failed
	  echo mysqli_error($db);
	  db_disconnect($db);
	  exit;
	  
	}

} else {
	
	$publisher = find_pub_by_id($id);

}   
?>
	
	<?php $page_title = 'Edit Publisher'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>

<!-- html with embedded php to display a web form for editing publisher -->
<!-- ("server side script for managing content") -->

<div id="content">

  <a class = "back-link" href="<?php echo url_for('/admin/publishers/index.php') ?>">&laquo; Back to List</a>
  
  <div class="publisher edit">
    <h1>Edit Publisher</h1>

    <form action="<?php echo url_for('/admin/publishers/edit.php?id=' . h(u($id))); ?>" method="post">
      <dl>
        <dt>Publisher id</dt>
        <dd><?php echo h($publisher['publisher_id']) ?></dd>
      </dl>
      <dl>
        <dt>Publisher name</dt>
        <dd><input type="text" name="publisher_name" value="<?php echo h($publisher['publisher_name']); ?>" /></dd>
      </dl>
 	   <div id="operations">
        <input type="submit" value="Edit publisher" />
      </div>
    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/admin_footer.php'); ?>






















