<?php
// fetchGwroh.php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'DBconnect.php'; // This should initialize $connect

// Get offset and limit from GET parameters, with defaults.
$offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
$limit  = isset($_GET['limit'])  ? (int)$_GET['limit']  : 100; // Adjust batch size as needed

$query = "SELECT * FROM gwroh LIMIT ?, ?";
if ($stmt = $connect->prepare($query)) {
    // Bind offset and limit as integers (use 'ii' for two integer parameters)
    $stmt->bind_param("ii", $offset, $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    $stmt->close();
    header('Content-Type: application/json');
    echo json_encode($rows);
} else {
    http_response_code(500);
    echo json_encode(["error" => $connect->error]);
}
?>
