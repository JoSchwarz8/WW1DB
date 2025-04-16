<?php

require_once 'DBconnect.php';  // This should initialize the $connect variable (a mysqli connection)

// Process the deletion only if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Retrieve the identifying fields from the POST data.
    // In this example, we're assuming that Surname, Forename, and Newspaper Date uniquely identify a record.
    $surname = $_POST['Surname'] ?? '';
    $memorial = $_POST['Memorial'] ?? '';

    // Check for required data
    if (empty($surname) || empty($memorial)) {
        echo "Missing required fields for deletion.";
        exit;
    }
    
    // Prepare a DELETE query with placeholders
    $sql = "DELETE FROM Memorials WHERE Surname = ? AND Memorial = ?";
    
    if ($stmt = $connect->prepare($sql)) {
        // Bind the values to the query (using sss for three strings)
        $stmt->bind_param("ss", $surname, $memorial);
        
        // Execute the query
        $stmt->execute();
        
        // Check if a record was deleted and provide feedback
        if ($stmt->affected_rows > 0) {
            echo "Record deleted successfully.";
        } else {
            echo "No matching record found.";
        }
        
        $stmt->close();
    } else {
        echo "SQL Error: " . $connect->error;
    }
}
?>
