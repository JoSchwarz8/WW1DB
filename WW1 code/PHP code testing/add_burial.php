<?php
$conn = new mysqli("localhost", "root", "", "ww1_soldiers");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents("php://input"), true);

$sql = "INSERT INTO those_buried_in_bradford (surname, age, cemetery, dod, forename, grave_ref, info, rank, regiment, service_number, unit)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sisssssssis",
  $data['surname'], $data['age'], $data['cemetery'], $data['dod'],
  $data['forename'], $data['grave_ref'], $data['info'], $data['rank'],
  $data['regiment'], $data['service_number'], $data['unit']
);

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
