<?php require_once('../../private/initialise.php'); ?>

<?php $page_title = 'Search'; ?>
<?php include(SHARED_PATH . '/user_header.php'); ?>

<?php
// Get query parameters
$main_search = $_GET['q'] ?? '';
$use_advanced = isset($_GET['advanced']);
$title      = $_GET['title'] ?? '';
$author     = $_GET['author'] ?? '';
$year       = $_GET['year'] ?? '';
$isbn       = $_GET['isbn'] ?? '';
$publisher  = $_GET['publisher'] ?? '';
$fuzzy      = !empty($_GET['fuzzy']);

$results = [];
// Only search if something is entered
if ($use_advanced && ($title || $author || $year || $isbn || $publisher)) {
    // Advanced search
    $results = advanced_search_items($db, [
        'title' => $title,
        'author' => $author,
        'year' => $year,
        'isbn' => $isbn,
        'publisher' => $publisher,
        'fuzzy' => $fuzzy,
    ]);
} elseif ($main_search) {
    // Main search bar, searches all main fields
    $results = keyword_search_items($db, $main_search, $fuzzy);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Results</title>
    <link rel="stylesheet" type="text/css" href="<?php echo url_for('/styles/user_search.css'); ?>">
    <script>
      function showAdvanced() {
        document.getElementById('advanced-search').style.display='block';
      }
      function hideAdvanced() {
        document.getElementById('advanced-search').style.display='none';
      }
    </script>
</head>
<body>
<main aria-label="main content">
  <section class="search-section" aria-label="Library catalogue search">
      <h1 id="searchbar-head">Search the Library Catalogue</h1>
    <!-- Main Search Bar -->
<form class="search-form" action="user_search.php" method="get" role="search" aria-label="Catalogue search form">
  <div class="search-bar-row">
    <input
      id="catalogue-search"
      name="q"
      value="<?php echo h($main_search); ?>"
      class="search-input"
      type="search" 
      placeholder="Search anything"
      aria-label="Search the library catalogue"
      required>
    <button class="search-submit" type="submit" aria-label="Search">Search</button>
  </div>
  <div class="advanced-btn-row">
    <button type="button" class="advanced-toggle" onclick="showAdvanced()" aria-label="Show advanced search">Advanced search</button>
  </div>
</form>


    <!-- Advanced Search Section (hidden by default) -->

    <div id="advanced-search" style="display:<?php echo ($use_advanced ? 'block':'none'); ?>">
  <form class="advanced-search-form" action="user_search.php" method="get">
    <input type="hidden" name="advanced" value="1">
    
    <div class="form-row">
      <label for="search-title">Title:</label>
      <input type="text" id="search-title" name="title" value="<?php echo h($title); ?>">
    </div>
    <div class="form-row">
      <label for="search-author">Author/Creator:</label>
      <input type="text" id="search-author" name="author" value="<?php echo h($author); ?>">
    </div>
    <div class="form-row">
      <label for="search-year">Publication Year:</label>
      <input type="text" id="search-year" name="year" value="<?php echo h($year); ?>">
    </div>
    <div class="form-row">
      <label for="search-isbn">ISBN:</label>
      <input type="text" id="search-isbn" name="isbn" value="<?php echo h($isbn); ?>">
    </div>
    <div class="form-row">
      <label for="search-publisher">Publisher:</label>
      <input type="text" id="search-publisher" name="publisher" value="<?php echo h($publisher); ?>">
    </div>
    <div class="form-row">
      <label>
        <input type="checkbox" name="fuzzy" <?php if($fuzzy) echo "checked"; ?>> Fuzzy match (typo-tolerance)
      </label>
    </div>
    <div class="form-row">
      <button class="advanced-search-btn" type="submit">Search</button>
      <button class="advanced-search-btn" type="button" onclick="hideAdvanced()">Close</button>
    </div>
  </form>
</div>

    <!-- Results -->
    <?php
      $searching = ($main_search || ($use_advanced && ($title || $author || $year || $isbn || $publisher)));
      if ($searching):
    ?>
      <h3 id="result-count">
        <?php
          $count = count($results);
          echo h($count) . ' ' . ($count === 1 ? 'Result' : 'Results') . ' for ';
          if ($main_search) echo ' "' . h($main_search) . '" ';
          if ($use_advanced) {
            if ($title) echo 'Title: "' . h($title) . '" ';
            if ($author) echo 'Author: "' . h($author) . '" ';
            if ($year) echo 'Year: "' . h($year) . '" ';
            if ($isbn) echo 'ISBN: "' . h($isbn) . '" ';
            if ($publisher) echo 'Publisher: "' . h($publisher) . '" ';
            if ($fuzzy) echo ' (Fuzzy match)';
          }
        ?>
      </h3>
      <?php if ($count): ?>
        <div class="results-list">
          <?php foreach ($results as $item): ?>
            <!--<a href="<?php echo url_for('/user/uitem_show.php?id=' . h(u($item['item_id']))); ?>" class="result-card" tabindex="0" aria-label="View details for <?php echo h($item['title']); ?>">-->
             <?php $backurl = urlencode($_SERVER['REQUEST_URI']);?>
                <a href="<?php echo url_for('/user/uitem_show.php?id=' . h(u($item['item_id'])) . '&backurl=' . $backurl); ?>" class="result-card" tabindex="0" aria-label="View details for <?php echo h($item['title']); ?>">
  
            
            
            
            
            <div class="item-type"><?php echo h($item['item_type']); ?></div>
              <div class="item-title"><?php echo h($item['title']); ?></div>
              <div class="item-creators"><?php echo h($item['creators']); ?></div>
              <div class="item-pub">
                <?php echo h($item['pub'] . ', '); ?>
                <?php echo h($item['publication_year']); ?>
              </div>
              <div class="item-status"><?php echo h($item['item_status']); ?></div>
            </a>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <p>No records found</p>
        <ul>
         <li> Check your spelling.
          <li>Try different keywords or phrases.
          <li>Use fewer keywords.
          <li>Try searching by title, author, or ISBN.
          <li>Use the advanced search for more options.
          </ul>
      <?php endif; ?>
    <?php endif; ?>
  </section>
</main>
</body>
</html>