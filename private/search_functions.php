<?php

// Safe search functions for courses and publishers using prepared statements

function keyword_search_courses($db, $search) {
    $words = preg_split('/\s+/', trim($search));
    $where = [];
    $params = [];
    
    foreach ($words as $word) {
        $word_conds = [];
        // Search course name
        $word_conds[] = "course_name LIKE ?";
        $params[] = "%$word%";
        // Search course ID
        $word_conds[] = "course_id LIKE ?";
        $params[] = "%$word%";
        
        // Combine fields for this word as OR
        $where[] = '(' . implode(' OR ', $word_conds) . ')';
    }
    
    $sql = "SELECT * FROM courses WHERE " . implode(' AND ', $where) . " ORDER BY course_name ASC";
    
    $stmt = $db->prepare($sql);
    $types = str_repeat('s', count($params));
    if ($params) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

function keyword_search_publishers($db, $search) {
    $words = preg_split('/\s+/', trim($search));
    $where = [];
    $params = [];
    
    foreach ($words as $word) {
        $word_conds = [];
        // Search publisher name
        $word_conds[] = "publisher_name LIKE ?";
        $params[] = "%$word%";
        // Search publisher ID
        $word_conds[] = "publisher_id LIKE ?";
        $params[] = "%$word%";
        
        // Combine fields for this word as OR
        $where[] = '(' . implode(' OR ', $word_conds) . ')';
    }
    
    $sql = "SELECT * FROM publishers WHERE " . implode(' AND ', $where) . " ORDER BY publisher_name ASC";
    
    $stmt = $db->prepare($sql);
    $types = str_repeat('s', count($params));
    if ($params) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

?>
