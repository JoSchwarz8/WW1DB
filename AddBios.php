<?php
require_once 'DBconnect.php';

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $surname = isset($_POST['surname']) ? $_POST['surname'] : '';
    $forename = isset($_POST['forename']) ? $_POST['forename'] : '';
    $regiment = isset($_POST['regiment']) ? $_POST['regiment'] : '';
    $serviceNo = isset($_POST['serviceNo']) ? $_POST['serviceNo'] : '';
    $bioAttachment = isset($_POST['bioAttachment']) ? $_POST['bioAttachment'] : '';
    
    // Check if required fields are provided
    if (empty($surname) || empty($forename)) {
        echo "Error: Surname and forename are required fields";
        exit;
    }
    
    try {
        // Using prepared statement to prevent SQL injection
        $stmt = $connect->prepare("INSERT INTO Biography_Information (Surname, Forename, Regiment, Service_no, Biography) VALUES (?, ?, ?, ?, ?)");
        
        // Check if statement was prepared successfully
        if (!$stmt) {
            throw new Exception("Prepare statement failed: " . $connect->error);
        }
        
        // Bind parameters
        $stmt->bind_param("sssss", $surname, $forename, $regiment, $serviceNo, $bioAttachment);
        
        // Execute the statement
        if ($stmt->execute()) {
            echo "Record added successfully"; 
        } else {
            echo "Error: " . $stmt->error;
        }
        
        // Close the statement
        $stmt->close();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        // Close the connection
        $connect->close();
    }
    
    // Redirect back to the form after 2 seconds
    header("Refresh: 2; URL=Bios.php");
} else {
    echo "Error: Invalid request method";
    header("Refresh: 2; URL=Add to Database - Biographies.html");
}
?>