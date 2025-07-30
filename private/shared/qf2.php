

<?php

//alternative versions

function advanced_search_items($db, $params) {
    $where = [];
    $sql_params = [];

    // Title
    if ($params['title']) {
         $words = preg_split('/\s+/', trim($params['title']));
        $conds = [];
        foreach ($words as $word) {
        if ($params['fuzzy']) {
            $where[] = "SOUNDEX(items.title) = SOUNDEX(?)";
            $sql_params[] = $params['title'];
        } else {
            $where[] = "items.title LIKE ?";
            $sql_params[] = "%{$params['title']}%";
        }
    }
    // Author/Creator
    if ($params['author']) {
         $words = preg_split('/\s+/', trim($params['title']));
        $conds = [];
        foreach ($words as $word) {
        if ($params['fuzzy']) {
            $where[] = "SOUNDEX(creators.creator_name) = SOUNDEX(?)";
            $sql_params[] = $params['author'];
        } else {
            $where[] = "creators.creator_name LIKE ?";
            $sql_params[] = "%{$params['author']}%";
        }
    }
    // Year
    if ($params['year']) {
        $where[] = "items.publication_year = ?";
        $sql_params[] = $params['year'];
    }
    // ISBN
    if ($params['isbn']) {
        $where[] = "items.isbn = ?";
        $sql_params[] = $params['isbn'];
    }
    // Publisher
    if ($params['publisher']) {
         $words = preg_split('/\s+/', trim($params['title']));
        $conds = [];
        foreach ($words as $word) {
        if ($params['fuzzy']) {
            $where[] = "SOUNDEX(publishers.publisher_name) = SOUNDEX(?)";
            $sql_params[] = $params['publisher'];
        } else {    
            $where[] = "publishers.publisher_name LIKE ?";
            $sql_params[] = "%{$params['publisher']}%";
        }
    }

    $sql = "
        SELECT items.*, 
               GROUP_CONCAT(creators.creator_name SEPARATOR ', ') AS creators, 
               publishers.publisher_name AS pub
        FROM items
        LEFT JOIN item_creators ON items.item_id = item_creators.item_id
        LEFT JOIN creators ON item_creators.creator_id = creators.creator_id
        LEFT JOIN publishers ON items.publisher_id = publishers.publisher_id
    ";
    if ($where) {
        $sql .= " WHERE " . implode(" AND ", $where);
    }
    $sql .= " GROUP BY items.item_id ORDER BY items.title ASC";

    $stmt = $db->prepare($sql);
    if ($sql_params) {
        $types = str_repeat('s', count($sql_params));
        $stmt->bind_param($types, ...$sql_params);
    }
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

function keyword_search_items($db, $search, $fuzzy = false) {
    // Search across title, creators, pub, isbn
    $words = preg_split('/\s+/', trim($search));
    $where = [];
    $params = [];
    foreach (['title', 'creators', 'pub', 'isbn'] as $field) {
        $field_conds = [];
        foreach ($words as $word) {
            if ($fuzzy) {
                $field_conds[] = "SOUNDEX($field) = SOUNDEX(?)";
                $params[] = $word;
            } else {
                $field_conds[] = "$field LIKE ?";
                $params[] = "%$word%";
            }
        }
        $where[] = '(' . implode(' OR ', $field_conds) . ')';
    }
    $sql = "SELECT * FROM items WHERE " . implode(' OR ', $where) . " ORDER BY title ASC";
    $stmt = $db->prepare($sql);
    $types = str_repeat('s', count($params));
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

