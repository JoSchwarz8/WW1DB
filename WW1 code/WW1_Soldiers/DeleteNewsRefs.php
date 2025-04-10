<?php
// DeleteNewsRefs.php
// This file deletes a record from the Newspaper_ref table based on unique identifying fields.

require_once 'DBconnect.php';  // This should initialize the $connect variable (a mysqli connection)

// Process the deletion only if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Retrieve the identifying fields from the POST data.
    // In this example, we're assuming that Surname, Forename, and Newspaper Date uniquely identify a record.
    $surname = $_POST['Surname'] ?? '';
    $forename = $_POST['Forename'] ?? '';
    $newspaperDate = $_POST['Newspaper_Date'] ?? ''; // Make sure the front-end sends this field name exactly

    // Check for required data
    if (empty($surname) || empty($forename) || empty($newspaperDate)) {
        echo "Missing required fields for deletion.";
        exit;
    }
    
    // Prepare a DELETE query with placeholders
    $sql = "DELETE FROM Newspaper_ref WHERE Surname = ? AND Forename = ? AND `Newspaper Date` = ?";
    
    if ($stmt = $connect->prepare($sql)) {
        // Bind the values to the query (using sss for three strings)
        $stmt->bind_param("sss", $surname, $forename, $newspaperDate);
        
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
