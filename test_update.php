<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include database connection
require_once 'DBconnect.php';

// Test data for update
$serviceNo = "12345"; // Replace with a service number that exists in your table
$surname = "Test Surname " . time(); // Add timestamp to make it unique
$forename = "Test Forename";
$regiment = "Test Regiment";
$biography = "Test Biography";

// First check if the record exists
$checkQuery = "SELECT COUNT(*) as count FROM Biography_Information WHERE `Service no` = ?";
$checkStmt = mysqli_prepare($connect, $checkQuery);

if (!$checkStmt) {
    die("Prepare statement failed: " . mysqli_error($connect));
}

mysqli_stmt_bind_param($checkStmt, "s", $serviceNo);
mysqli_stmt_execute($checkStmt);
$checkResult = mysqli_stmt_get_result($checkStmt);
$row = mysqli_fetch_assoc($checkResult);
$recordExists = ($row['count'] > 0);

echo "<h2>Testing database update</h2>";

if ($recordExists) {
    echo "<p>Record with Service_no = '$serviceNo' exists. Attempting update.</p>";
    
    // Prepare UPDATE statement
    $updateQuery = "UPDATE Biography_Information SET Surname=?, Forename=?, Regiment=?, `Service no`=?, Biography=? WHERE `Service no`=?";
    $updateStmt = mysqli_prepare($connect, $updateQuery);
    
    if (!$updateStmt) {
        die("Prepare statement failed: " . mysqli_error($connect));
    }
    
    mysqli_stmt_bind_param($updateStmt, "ssssss", $surname, $forename, $regiment, $serviceNo, $biography, $serviceNo);
    $updateResult = mysqli_stmt_execute($updateStmt);
    
    if ($updateResult) {
        echo "<p>Update successful. " . mysqli_affected_rows($connect) . " rows affected.</p>";
    } else {
        echo "<p>Update failed: " . mysqli_error($connect) . "</p>";
    }
    
    mysqli_stmt_close($updateStmt);
} else {
    echo "<p>Record with Service_no = '$serviceNo' does not exist. Attempting insert.</p>";
    
    // Prepare INSERT statement
    $insertQuery = "INSERT INTO Biography_Information (Surname, Forename, Regiment, `Service no`, Biography) VALUES (?, ?, ?, ?, ?)";
    $insertStmt = mysqli_prepare($connect, $insertQuery);
    
    if (!$insertStmt) {
        die("Prepare statement failed: " . mysqli_error($connect));
    }
    
    mysqli_stmt_bind_param($insertStmt, "sssss", $surname, $forename, $regiment, $serviceNo, $biography);
    $insertResult = mysqli_stmt_execute($insertStmt);
    
    if ($insertResult) {
        echo "<p>Insert successful. New record ID: " . mysqli_insert_id($connect) . "</p>";
    } else {
        echo "<p>Insert failed: " . mysqli_error($connect) . "</p>";
    }
    
    mysqli_stmt_close($insertStmt);
}

// Display the current record
$selectQuery = "SELECT * FROM Biography_Information WHERE `Service no` = ?";
$selectStmt = mysqli_prepare($connect, $selectQuery);

if (!$selectStmt) {
    die("Prepare statement failed: " . mysqli_error($connect));
}

mysqli_stmt_bind_param($selectStmt, "s", $serviceNo);
mysqli_stmt_execute($selectStmt);
$result = mysqli_stmt_get_result($selectStmt);

echo "<h3>Current record data:</h3>";
echo "<table border='1'>";
echo "<tr><th>Field</th><th>Value</th></tr>";

if ($row = mysqli_fetch_assoc($result)) {
    foreach ($row as $field => $value) {
        echo "<tr><td>{$field}</td><td>" . htmlspecialchars($value ?? 'NULL') . "</td></tr>";
    }
} else {
    echo "<tr><td colspan='2'>No record found</td></tr>";
}

echo "</table>";

mysqli_stmt_close($selectStmt);
mysqli_close($connect);
?> 