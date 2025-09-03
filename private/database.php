<?php

$config = parse_ini_file(__DIR__ . '/../.env');
if (!$config) {
    exit("Failed to load .env file.");
}

function db_connect() {
    global $config; 
    $connection = mysqli_connect(
        $config['DB_SERVER'],
        $config['DB_USER'],
        $config['DB_PASS'],
        $config['DB_NAME']
    );
    confirm_db_connect();
    return $connection;
}

function db_disconnect($connection) {
    if (isset($connection)) {
        mysqli_close($connection);
    }
}

function db_escape($db, $string) {
    return mysqli_real_escape_string($db, (string) $string);
}

function confirm_db_connect() {
    if (mysqli_connect_errno()) {
        $msg = "Database connection failed: ";
        $msg .= mysqli_connect_error();
        $msg .= " (" . mysqli_connect_errno() . ")";
        exit($msg);
    }
}

function confirm_result_set($result_set) {
    if (!$result_set) {
        exit("Database query failed.");
    }
}
?>
