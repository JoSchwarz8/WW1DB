<?php
require_once 'DBconnect.php'; // This should initialize $connect (a mysqli connection)

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve unique keys from POST data. Adjust names if needed.
    $surname = $_POST['Surname'] ?? '';
    $serviceNo = $_POST['Service_no'] ?? '';

    if (empty($surname) || empty($serviceNo)) {
        echo "Missing required fields for deletion.";
        exit;
    }
    
    $sql = "DELETE FROM Biography_Information WHERE Surname = ? AND Service_no = ?";
    if ($stmt = $connect->prepare($sql)) {
        $stmt->bind_param("ss", $surname, $serviceNo);
        $stmt->execute();

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

