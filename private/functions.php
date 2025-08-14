<?php

function url_for($script_path) {
  // add the leading '/' if not present
  if($script_path[0] != '/') {
    $script_path = "/" . $script_path;
  }
  return WWW_ROOT . $script_path;
}

function u($string="") {
	return urlencode($string);
}

function raw_u($string="") {
	return rawurlencode($string);
}

function h($string="") {
	return htmlspecialchars($string ?? '');
}

function error_404() {

  header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
  exit();
}
  
function error_500() {
  header($_SERVER["SERVER_PROTOCOL"] . " 500 Internal Server Error");
  exit();
}
  
function redirect_to($location) {
  header("Location: " . $location);
  exit;
}

function is_post_request() {
  return $_SERVER['REQUEST_METHOD'] == 'POST';
}

function is_get_request() {
  return $_SERVER['REQUEST_METHOD'] == 'GET';
}

function display_errors($errors=array()) {
  $output = '';
  if(!empty($errors)) {
    $output .= "<div class=\"errors\">";
    $output .= "Please fix the following errors:";
    $output .= "<ul>";
    foreach($errors as $error) {
      $output .= "<li>" . h($error) . "</li>";
    }
    $output .= "</ul>";
    $output .= "</div>";
  }
  return $output;
}

function get_and_clear_session_message() {
  if (isset($_SESSION['message']) && $_SESSION['message'] !== '') {
    $msg = $_SESSION['message'];
    unset($_SESSION['message']);
    return $msg;
  }
  return '';
}

function display_session_message() {
  $msg = get_and_clear_session_message();
  if(!is_blank($msg)) {
  return '<div id="message">' . h($msg) . '</div>';
  }
  return '';
}

/**
 * Highlights search terms in text with HTML mark tags
 * @param string $text The text to search in
 * @param string $search_terms The search terms to highlight (space-separated)
 * @param string $css_class The CSS class to apply to highlighted terms
 * @return string The text with highlighted search terms
 */
function highlight_search_terms($text, $search_terms, $css_class = 'search-highlight') {
    if (empty($search_terms) || empty($text)) {
        return $text;
    }
    
    // Split search terms into individual words
    $words = preg_split('/\s+/', trim($search_terms));
    $highlighted_text = $text;
    
    foreach ($words as $word) {
        // Only highlight words with 2+ characters to avoid highlighting common words
        if (strlen($word) > 1) {
            // Use word boundaries to match whole words and partial matches
            $pattern = '/(' . preg_quote($word, '/') . ')/i';
            $replacement = '<mark class="' . $css_class . '">$1</mark>';
            $highlighted_text = preg_replace($pattern, $replacement, $highlighted_text);
        }
    }
    
    return $highlighted_text;
}
?>