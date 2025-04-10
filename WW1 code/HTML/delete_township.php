<?php
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "error" => "POST method required"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data['service_number'])) {
    echo json_encode(["success" => false, "error" => "Missing service_number"]);
    exit;
}

$serviceNumber = $data['service_number'];

$conn = new mysqli("localhost", "root", "", "ww1-2");
if ($conn->connect_error) {
    echo json_encode(["success" => false, "error" => "Connection failed"]);
    exit;
}

$stmt = $conn->prepare("DELETE FROM surrounding_towns WHERE `Service No` = ?");
$stmt->bind_param("s", $serviceNumber);
$success = $stmt->execute();

echo json_encode(["success" => $success]);

$stmt->close();
$conn->close();
?>
