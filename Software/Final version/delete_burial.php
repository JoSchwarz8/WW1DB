<?php
$conn = new mysqli("localhost", "root", "root", "WW1_Soldiers");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents("php://input"), true);
$surname = $data['surname'];

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
