<?php 
require_once('../../../private/init.php'); 

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
    $_SESSION['message'] = 'Publisher updated successfully.';
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
<?php include(SHARED_PATH . '/header.php'); ?>

<!-- html with embedded php to display a web form for editing publisher -->
<!-- ("server side script for managing content") -->
<main aria-label="main content">
<div id="content">

  <a class = "back-link" href="<?php echo url_for('/admin/publishers/index.php') ?>">← Back to List</a>
  
  <div class="publisher edit">
    <h2>Edit Publisher</h2>
    
    <?php echo display_errors($errors); ?>

    <form class="admin-form1" action="<?php echo url_for('/admin/publishers/edit.php?id=' . h(u($id))); ?>" method="post">
     <?php if(isset($pub['publisher_id'])): ?>
      <div class="form-row">
  <dl>
    <dt>Publisher ID</dt>
    <dd><?php echo h($pub['publisher_id']); ?></dd>
  </dl>
     </div>
    <?php endif; ?>
      <div class="form-row">
      <dl>
        <dt>Publisher name</dt>
        <dd><input type="text" name="publisher_name" value="<?php echo h($pub['publisher_name']); ?>" /></dd>
      </dl>
    </div>
 	   <div id="operations">
        <input type="submit" value="Edit Publisher" />
      </div>
    </form>

  </div>

</div>
     </main>
<?php include(SHARED_PATH . '/footer.php'); ?>






















