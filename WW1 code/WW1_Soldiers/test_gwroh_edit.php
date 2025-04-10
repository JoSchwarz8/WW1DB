<?php
// test_gwroh_edit.php - Test direct EditGwroh functionality
require_once 'EditDAO.php';
require_once 'EditGwroh.php';

// Enable detailed error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Create EditGwroh object with test data
$gwroh = new EditGwroh();

// Set required fields
$gwroh->setSurname('Test');
$gwroh->setForename('User');
$gwroh->setService_no('TEST123'); // New service number

// Pick a valid service number from your database to test the update
$gwroh->setOriginal_Service_no('7/25834'); // Original service number to update

// Set other fields (optional)
$gwroh->setRank('Private');
$gwroh->setRegiment('Test Regiment');

// Debug output before save
echo "<pre>About to save with data:<br>";
print_r($gwroh->debugOutput());
echo "</pre>";

// Connect to database through DAO
$dao = new EditDAO();

try {
    // Test connection
    $connection = $dao->testConnection();
    if (!$connection) {
        die("Database connection failed");
    }
    
    // Save the record
    $result = $gwroh->save($dao);
    
    if ($result) {
        echo "<h2>Success!</h2>";
        echo "Record was successfully updated.";
    } else {
        echo "<h2>Error</h2>";
        echo "Failed to update record.";
    }
} catch (Exception $e) {
    echo "<h2>Exception</h2>";
    echo "An error occurred: " . $e->getMessage();
}
?> 