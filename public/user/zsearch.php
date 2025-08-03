
<?php require_once('../../private/init.php'); ?>

<?php $page_title = 'Search'; ?>
<?php include(SHARED_PATH . '/user_header.php'); ?>

<!--Get search query-->
<?php $search = $_GET['q'] ?? '';

$results = [];
if ($search) {
    $results = search_items($db, $search);
}

//$item_set = search_items();
//$item_count = mysqli_num_rows($item_set)+1; 
//mysqli_free_result($item_set);

?>

<!DOCTYPE html>
<html>
<head><title>Search Results</title></head>
<body>
   

  <!-- Central catalogue search bar -->
  <main aria-label="main content">
    <section class="search-section" aria-label="Library catalogue search">
      <label for="catalogue-search" class="search-label">Search the Library Catalogue</label>
      <form class="search-form" action="index.php" method="get" role="search" aria-label="Catalogue search form">
        <input
          id="catalogue-search"
          name="q"
          value="<?php echo h($search); ?>"
          class="search-input"
          type="search" 
          placeholder="Search anything"
          aria-label="Search the library catalogue"
          required>
        
        <button class="search-submit" type="submit" aria-label="Search">
          <!-- Accessible SVG search icon -->
          <svg viewBox="0 0 24 24" width="22" height="22" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
            <circle cx="11" cy="11" r="7" stroke="white" stroke-width="2"/>
            <line x1="17.5" y1="17.5" x2="21" y2="21" stroke="white" stroke-width="2" stroke-linecap="round"/>
          </svg>
        </button>
      </form>
       <?php if ($search): ?>
                <h3 id="result-count"><?php $count = count($results); echo h($count) . ' ' . ($count === 1 ? 'Result' : 'Results') . ' for "' . h($search) . '"'; ?></h3>
                <?php if (count($results)): ?>
                    <div class="results-list">
              <?php foreach ($results as $item): ?>
            <a href="<?php echo url_for('/user/uitem_show.php?id=' . h(u($item['item_id'])) . '&q=' . h(u($search))); ?>" class="result-card" tabindex="0" aria-label="View details for <?php echo h($item['title']); ?>">
           <div class="item-type"><?php echo h($item['item_type']); ?></div>
          <div class="item-title"><?php echo h($item['title']); ?></div>
          <div class="item-creators"><?php echo h($item['creators']); ?></div>
           <div class="item-pub">
            <?php echo h($item['pub'] . ', '); ?>
              <?php echo h($item['publication_year']); ?>
        </div>
    </a>
<?php endforeach; ?>
</div>
                <?php else: ?>
                    <p>No results found.</p>
                <?php endif; ?>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>
    