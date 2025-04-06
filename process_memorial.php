<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include required files
require_once 'DBconnect.php';  // First include DBconnect to ensure $connect is available
require_once 'EditPHP.php';
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
    $unit = isset($_POST['unit']) ? $_POST['unit'] : '';
    $memorial = isset($_POST['memorial']) ? $_POST['memorial'] : '';
    $memorial_location = isset($_POST['memorial_location']) ? $_POST['memorial_location'] : '';
    $memorial_info = isset($_POST['memorial_info']) ? $_POST['memorial_info'] : '';
    $memorial_postcode = isset($_POST['memorial_postcode']) ? $_POST['memorial_postcode'] : '';
    $district = isset($_POST['district']) ? $_POST['district'] : '';
    $photo_available = isset($_POST['photo_available']) ? $_POST['photo_available'] : '';
    
    // Get the original values to use in the WHERE clause
    $original_surname = isset($_POST['original_surname']) ? $_POST['original_surname'] : $surname;
    $original_forename = isset($_POST['original_forename']) ? $_POST['original_forename'] : $forename;
    
    debug_log("Received data:", [
        'surname' => $surname,
        'forename' => $forename,
        'regiment' => $regiment,
        'unit' => $unit,
        'memorial' => $memorial,
        'memorial_location' => $memorial_location,
        'memorial_info' => $memorial_info,
        'memorial_postcode' => $memorial_postcode,
        'district' => $district,
        'photo_available' => $photo_available,
        'original_surname' => $original_surname,
        'original_forename' => $original_forename
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
        
        // First, let's check the actual column names in the table
        $columnsQuery = "SHOW COLUMNS FROM Memorials";
        $columnsResult = mysqli_query($connect, $columnsQuery);
        debug_log("Table columns:");
        $columnNames = [];
        while ($column = mysqli_fetch_assoc($columnsResult)) {
            $columnNames[] = $column['Field'];
            debug_log("Column: " . $column['Field']);
        }

        // Check if record exists based on original values
        $checkQuery = "SELECT * FROM Memorials WHERE Surname = ? AND Forename = ? LIMIT 1";
        $checkStmt = mysqli_prepare($connect, $checkQuery);
        
        if (!$checkStmt) {
            debug_log("Prepare check statement failed: " . mysqli_error($connect));
            throw new Exception("Prepare check statement failed: " . mysqli_error($connect));
        }
        
        debug_log("Checking for existing record using original values:", [
            'original_surname' => $original_surname,
            'original_forename' => $original_forename
        ]);
        
        mysqli_stmt_bind_param($checkStmt, "ss", $original_surname, $original_forename);
        mysqli_stmt_execute($checkStmt);
        $checkResult = mysqli_stmt_get_result($checkStmt);
        $recordExists = (mysqli_num_rows($checkResult) > 0);
        
        if ($recordExists) {
            $existingRecord = mysqli_fetch_assoc($checkResult);
            debug_log("Found existing record:", $existingRecord);
        } else {
            debug_log("No existing record found, will create new");
        }
        
        mysqli_stmt_close($checkStmt);
        
        if ($recordExists) {
            // Update existing record - using original values in the WHERE clause
            $updateQuery = "UPDATE Memorials SET 
                Surname=?, 
                Forename=?, 
                Regiment=?, 
                Battalion=?, 
                Memorial=?, 
                MemorialLocation=?, 
                MemorialInfo=?, 
                MemorialPostcode=?, 
                District=?, 
                PhotoAvailable=? 
                WHERE Surname=? AND Forename=?";
            
            $updateStmt = mysqli_prepare($connect, $updateQuery);
            
            if (!$updateStmt) {
                debug_log("Prepare update statement failed: " . mysqli_error($connect));
                throw new Exception("Prepare update statement failed: " . mysqli_error($connect));
            }
            
            debug_log("Update parameters", [
                'new_surname' => $surname,
                'new_forename' => $forename,
                'regiment' => $regiment,
                'unit' => $unit,
                'memorial' => $memorial,
                'memorial_location' => $memorial_location,
                'memorial_info' => $memorial_info,
                'memorial_postcode' => $memorial_postcode,
                'district' => $district,
                'photo_available' => $photo_available,
                'where_surname' => $original_surname,
                'where_forename' => $original_forename
            ]);
            
            mysqli_stmt_bind_param($updateStmt, "ssssssssssss", 
                $surname, 
                $forename, 
                $regiment, 
                $unit, 
                $memorial, 
                $memorial_location, 
                $memorial_info, 
                $memorial_postcode, 
                $district, 
                $photo_available,
                $original_surname,  // WHERE clause - original value
                $original_forename  // WHERE clause - original value
            );
            
            $updateResult = mysqli_stmt_execute($updateStmt);
            $rowsAffected = mysqli_affected_rows($connect);
            
            debug_log("Update execute result: " . ($updateResult ? "Success" : "Failed"));
            debug_log("Rows affected by update: " . $rowsAffected);
            
            if ($updateResult && $rowsAffected > 0) {
                debug_log("Direct update successful. Rows affected: " . $rowsAffected);
                echo "Update successful. Database record updated.";
            } else {
                debug_log("Update affected 0 rows or failed: " . mysqli_error($connect));
                throw new Exception("Update failed: " . mysqli_error($connect));
            }
            
            mysqli_stmt_close($updateStmt);
        } else {
            // Insert new record
            $insertQuery = "INSERT INTO Memorials (
                Surname, 
                Forename, 
                Regiment, 
                Battalion, 
                Memorial, 
                MemorialLocation, 
                MemorialInfo, 
                MemorialPostcode, 
                District, 
                PhotoAvailable
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $insertStmt = mysqli_prepare($connect, $insertQuery);
            
            if (!$insertStmt) {
                debug_log("Prepare insert statement failed: " . mysqli_error($connect));
                throw new Exception("Prepare insert statement failed: " . mysqli_error($connect));
            }
            
            debug_log("Insert parameters", [
                'surname' => $surname,
                'forename' => $forename,
                'regiment' => $regiment,
                'unit' => $unit,
                'memorial' => $memorial,
                'memorial_location' => $memorial_location,
                'memorial_info' => $memorial_info,
                'memorial_postcode' => $memorial_postcode,
                'district' => $district,
                'photo_available' => $photo_available
            ]);
            
            mysqli_stmt_bind_param($insertStmt, "ssssssssss", 
                $surname, 
                $forename, 
                $regiment, 
                $unit, 
                $memorial, 
                $memorial_location, 
                $memorial_info, 
                $memorial_postcode, 
                $district, 
                $photo_available
            );
            
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