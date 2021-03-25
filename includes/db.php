<?php

ob_start();
session_start();

$timezone = date_default_timezone_set("Asia/Hong_Kong");

// Development connection
//$db['DB_HOST'] = "localhost";
//$db['DB_USER'] = "root";
//$db['DB_PASS'] = "";
//$db['DB_NAME'] = "musicapp";

// Remote database
$db['DB_HOST'] = "remotemysql.com";
$db['DB_USER'] = "Nhp9cHQs1s";
$db['DB_PASS'] = "Hhfvt4WD13";
$db['DB_NAME'] = "Nhp9cHQs1s";


// Set them to be constant, it is more secure to ourself
foreach($db as $key => $value) {
    define($key, $value);
}

// Set DSN
$dsn = 'mysql:host=' . DB_HOST . ';port=3306' . ';dbname=' . DB_NAME;

try {
    // Create a PDO instance
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
} catch (Exception $ex) {
    echo ("Internal error, please contact support.");
    error_log("db.php, SQL error=" . $ex->getMessage());
    return;
}

$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>
