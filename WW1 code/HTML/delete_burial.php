<?php
$conn = new mysqli("localhost", "root", "", "WW1_soldiers");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get the JSON input
$data = json_decode(file_get_contents("php://input"), true);
$surname = $data['surname'];

// SQL to delete the row
$sql = "DELETE FROM those_buried_in_bradford WHERE surname = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $surname);

$response = [];

if ($stmt->execute()) {
  $response["success"] = true;
} else {
  $response["success"] = false;
  $response["error"] = $stmt->error;
}

echo json_encode($response);
$conn->close();
?>
