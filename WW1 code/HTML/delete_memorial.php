<?php
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "error" => "POST method required"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data['memorial_id'])) {
    echo json_encode(["success" => false, "error" => "Missing memorial_id"]);
    exit;
}

$memorialId = $data['memorial_id'];

$conn = new mysqli("localhost", "root", "", "ww1-2");
if ($conn->connect_error) {
    echo json_encode(["success" => false, "error" => "Connection failed"]);
    exit;
}

$stmt = $conn->prepare("DELETE FROM memorials WHERE `Memorial_ID` = ?");
$stmt->bind_param("i", $memorialId);
$success = $stmt->execute();

echo json_encode(["success" => $success]);

$stmt->close();
$conn->close();
?>
