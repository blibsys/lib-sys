<?php 
require_once('../../../private/initialise.php'); 

if(!isset($_GET['id'])) {
	redirect_to(url_for('/admin/publishers/index.php'));
}

$id = $_GET['id'];

if(is_post_request()) {

	$pub = [];
	$pub['id'] = $id;	
	//$pub['publisher_id']= $_POST['publisher_id'] ?? '';
	$pub['publisher_name']= $_POST['publisher_name'] ?? '';
	
	$result = update_publisher($pub);
	if($result === true) {
	redirect_to(url_for('/admin/publishers/show.php?id=' . h(u($id))));
 		} else {
	    $errors = $result;
		//var_dump($errors);   
	}  
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
    
    <?php echo display_errors($errors); ?>

    <form action="<?php echo url_for('/admin/publishers/edit.php?id=' . h(u($id))); ?>" method="post">
     <?php if(isset($pub['publisher_id'])): ?>
  <dl>
    <dt>Publisher id</dt>
    <dd><?php echo h($pub['publisher_id']); ?></dd>
  </dl>
    <?php endif; ?>
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






















