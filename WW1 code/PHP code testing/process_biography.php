<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include required files
require_once 'DBconnect.php';  // First include DBconnect to ensure $connect is available
require_once 'EditBiography.php';
require_once 'EditDAO.php';

// Function to log debug information
function debug_log($message, $data = null) {
    $log = date('Y-m-d H:i:s') . ' - ' . $message;
    if ($data !== null) {
        $log .= ' - ' . json_encode($data);
    }
    error_log($log);
    // Also output to response for AJAX debugging
    echo $log . "\n";
}

// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $surname = isset($_POST['surname']) ? $_POST['surname'] : '';
    $forename = isset($_POST['forename']) ? $_POST['forename'] : '';
    $regiment = isset($_POST['regiment']) ? $_POST['regiment'] : '';
    $serviceNo = isset($_POST['serviceNo']) ? $_POST['serviceNo'] : '';
    $bioAttachment = isset($_POST['bioAttachment']) ? $_POST['bioAttachment'] : '';
    
    debug_log("Received data:", [
        'surname' => $surname,
        'forename' => $forename,
        'regiment' => $regiment,
        'serviceNo' => $serviceNo,
        'bioAttachment' => $bioAttachment
    ]);
    
    // Validate required fields
    if (empty($surname) || empty($forename)) {
        http_response_code(400); // Bad request
        debug_log("Error: Surname and forename are required fields");
        exit;
    }
    
    try {
        // Check and display DB connection info
        global $connect;
        if ($connect) {
            debug_log("Database connection from DBconnect.php is available");
        } else {
            debug_log("Database connection from DBconnect.php is NOT available");
        }
        
        // Create biography object
        $biographyObj = new EditBiography();
        $biographyObj->setSurname($surname);
        $biographyObj->setForename($forename);
        $biographyObj->setRegiment($regiment);
        $biographyObj->setService_Number($serviceNo);
        $biographyObj->setBiography_attachment($bioAttachment);
        
        debug_log("Created biography object", $biographyObj->debugOutput());
        
        // Try direct database update using mysqli
        debug_log("Attempting direct database update using mysqli");
        
        // First check if record exists
        $checkQuery = "SELECT COUNT(*) as count FROM Biography_Information WHERE `Service no` = ?";
        $checkStmt = mysqli_prepare($connect, $checkQuery);
        
        if (!$checkStmt) {
            debug_log("Prepare check statement failed: " . mysqli_error($connect));
            throw new Exception("Prepare check statement failed: " . mysqli_error($connect));
        }
        
        mysqli_stmt_bind_param($checkStmt, "s", $serviceNo);
        mysqli_stmt_execute($checkStmt);
        $checkResult = mysqli_stmt_get_result($checkStmt);
        $row = mysqli_fetch_assoc($checkResult);
        $recordExists = ($row['count'] > 0);
        mysqli_stmt_close($checkStmt);
        
        debug_log("Record exists check result", ['exists' => $recordExists, 'service_no' => $serviceNo]);
        
        if (!empty($serviceNo) && $recordExists) {
            // Update existing record
            $updateQuery = "UPDATE Biography_Information SET Surname=?, Forename=?, Regiment=?, `Service no`=?, Biography=? WHERE `Service no`=?";
            $updateStmt = mysqli_prepare($connect, $updateQuery);
            
            if (!$updateStmt) {
                debug_log("Prepare update statement failed: " . mysqli_error($connect));
                throw new Exception("Prepare update statement failed: " . mysqli_error($connect));
            }
            
            debug_log("Update parameters", [
                'surname' => $surname,
                'forename' => $forename,
                'regiment' => $regiment,
                'serviceNo' => $serviceNo,
                'bioAttachment' => $bioAttachment
            ]);
            
            mysqli_stmt_bind_param($updateStmt, "ssssss", $surname, $forename, $regiment, $serviceNo, $bioAttachment, $serviceNo);
            $updateResult = mysqli_stmt_execute($updateStmt);
            
            if ($updateResult) {
                debug_log("Direct update successful. Rows affected: " . mysqli_affected_rows($connect));
                echo "Update successful. Database record updated.";
            } else {
                debug_log("Direct update failed: " . mysqli_error($connect));
                throw new Exception("Direct update failed: " . mysqli_error($connect));
            }
            
            mysqli_stmt_close($updateStmt);
        } else {
            // Insert new record
            $insertQuery = "INSERT INTO Biography_Information (Surname, Forename, Regiment, `Service no`, Biography) VALUES (?, ?, ?, ?, ?)";
            $insertStmt = mysqli_prepare($connect, $insertQuery);
            
            if (!$insertStmt) {
                debug_log("Prepare insert statement failed: " . mysqli_error($connect));
                throw new Exception("Prepare insert statement failed: " . mysqli_error($connect));
            }
            
            debug_log("Insert parameters", [
                'surname' => $surname,
                'forename' => $forename,
                'regiment' => $regiment,
                'serviceNo' => $serviceNo,
                'bioAttachment' => $bioAttachment
            ]);
            
            mysqli_stmt_bind_param($insertStmt, "sssss", $surname, $forename, $regiment, $serviceNo, $bioAttachment);
            $insertResult = mysqli_stmt_execute($insertStmt);
            
            if ($insertResult) {
                debug_log("Direct insert successful. New ID: " . mysqli_insert_id($connect));
                echo "Insert successful. New database record created.";
            } else {
                debug_log("Direct insert failed: " . mysqli_error($connect));
                throw new Exception("Direct insert failed: " . mysqli_error($connect));
            }
            
            mysqli_stmt_close($insertStmt);
        }
        
    } catch (Exception $e) {
        // Exception handling
        http_response_code(500); // Internal server error
        debug_log("Error: " . $e->getMessage());
        echo "Error: " . $e->getMessage();
    }
} else {
    // Not a POST request
    http_response_code(405); // Method not allowed
    debug_log("Method not allowed: " . $_SERVER['REQUEST_METHOD']);
    echo "Method not allowed";
} 