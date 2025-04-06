<?php
// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database connection
$connect = mysqli_connect("localhost", "root", "root", "WW1_Soldiers");
if(!$connect){
    die("DB not connected: " . mysqli_connect_error());
}

// Set character set to ensure proper encoding
mysqli_set_charset($connect, "utf8");

// Optional: Test connection with a simple query
try {
    $test_query = "SELECT 1";
    $test_result = mysqli_query($connect, $test_query);
    if (!$test_result) {
        error_log("DB connection test failed: " . mysqli_error($connect));
    } else {
        error_log("DB connection test successful");
    }
} catch (Exception $e) {
    error_log("DB connection test exception: " . $e->getMessage());
}
?>
