<?php 
require_once('../../../private/initialise.php'); 

if(!isset($_GET['id'])) {
	redirect_to(url_for('/admin/publishers/index.php'));
}

$id = $_GET['id'];

if(is_post_request()) {

	$pub = [];
	$pub['id'] = $id;
	$pub['publisher_name']= $_POST['publisher_name'] ?? '';
	
	$result = update_publisher($pub);
	redirect_to(url_for('admin/publishers/show.php?id=' . $id));
	
  } else {
	
	$pub = find_pub_by_id($id);

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
        <dd><?php echo h($pub['publisher_id']) ?></dd>
      </dl>
      <dl>
        <dt>Publisher name</dt>
        <dd><input type="text" name="publisher_name" value="<?php echo h($pub['publisher_name']); ?>" /></dd>
      </dl>
 	   <div id="operations">
        <input type="submit" value="Edit Publisher" />
      </div>
    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/admin_footer.php'); ?>






















