<?php
// process_newsref.php - Process newspaper reference updates
require_once 'EditDAO.php';
require_once 'EditNewsRef.php';

// Set appropriate headers for AJAX response
header('Content-Type: application/json');

// Check if POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['error' => 'Only POST method is allowed']);
    exit;
}

try {
    // Get data from POST
    $id = isset($_POST['id']) ? trim($_POST['id']) : '';
    $surname = isset($_POST['surname']) ? trim($_POST['surname']) : '';
    $forename = isset($_POST['forename']) ? trim($_POST['forename']) : '';
    $rank = isset($_POST['rank']) ? trim($_POST['rank']) : '';
    $address = isset($_POST['address']) ? trim($_POST['address']) : '';
    $regiment = isset($_POST['regiment']) ? trim($_POST['regiment']) : '';
    $unit = isset($_POST['unit']) ? trim($_POST['unit']) : '';
    $article_comment = isset($_POST['article_comment']) ? trim($_POST['article_comment']) : '';
    $newspaper_name = isset($_POST['newspaper_name']) ? trim($_POST['newspaper_name']) : '';
    $newspaper_date = isset($_POST['newspaper_date']) ? trim($_POST['newspaper_date']) : '';
    $page_column = isset($_POST['page_column']) ? trim($_POST['page_column']) : '';
    $photo = isset($_POST['photo']) ? trim($_POST['photo']) : '';
    $original_surname = isset($_POST['original_surname']) ? trim($_POST['original_surname']) : '';
    $original_forename = isset($_POST['original_forename']) ? trim($_POST['original_forename']) : '';
    
    // Log the received data for debugging
    error_log("Received data in process_newsref.php: " . json_encode($_POST));
    
    // Validate required fields
    if (empty($surname) || empty($forename) || empty($newspaper_name)) {
        http_response_code(400); // Bad Request
        echo json_encode(['error' => 'Required fields (surname, forename, newspaper_name) cannot be empty']);
        exit;
    }
    
    // Create EditNewsRef object
    $newsRef = new EditNewsRef();
    $newsRef->setSurname($surname);
    $newsRef->setForename($forename);
    $newsRef->setRank($rank);
    $newsRef->setAddress($address);
    $newsRef->setRegiment($regiment);
    $newsRef->setUnit($unit);
    $newsRef->setArticleComment($article_comment);
    $newsRef->setNewspaperName($newspaper_name);
    $newsRef->setNewspaperDate($newspaper_date);
    $newsRef->setPageColumn($page_column);
    $newsRef->setPhotoIncl($photo);
    
    // Set original values for update identification
    if (!empty($original_surname) && !empty($original_forename)) {
        $newsRef->setOriginalSurname($original_surname);
        $newsRef->setOriginalForename($original_forename);
        $isUpdate = true;
    } else {
        // If no original values, use current values
        $newsRef->setOriginalSurname($surname);
        $newsRef->setOriginalForename($forename);
        $isUpdate = false;
    }
    
    // Connect to database through DAO
    $dao = new EditDAO();
    
    // Test connection
    if (!$dao->testConnection()) {
        http_response_code(500); // Internal Server Error
        echo json_encode(['error' => 'Database connection failed']);
        exit;
    }
    
    // Save the record (edit or create)
    $result = $newsRef->save($dao);
    
    if ($result) {
        http_response_code(200); // OK
        echo json_encode([
            'success' => true, 
            'message' => $isUpdate ? 'Record updated successfully' : 'Record created successfully',
            'data' => [
                'id' => $id,
                'surname' => $surname,
                'forename' => $forename,
                'rank' => $rank,
                'address' => $address,
                'regiment' => $regiment,
                'unit' => $unit,
                'article_comment' => $article_comment,
                'newspaper_name' => $newspaper_name,
                'newspaper_date' => $newspaper_date,
                'page_column' => $page_column,
                'photo' => $photo,
                'original_surname' => $original_surname,
                'original_forename' => $original_forename,
                'isUpdate' => $isUpdate
            ]
        ]);
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(['error' => 'Failed to save record']);
    }
} catch (Exception $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'An error occurred: ' . $e->getMessage()]);
} 