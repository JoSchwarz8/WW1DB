<?php
session_start();
include 'config.php';

if (!isset($_SESSION["user_id"])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit();
}

$table = $_GET["table"];
$search = $_GET["query"];
$column = $_GET["column"];

$stmt = $pdo->prepare("SELECT * FROM $table WHERE $column LIKE ?");
$stmt->execute(["%$search%"]);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($data);
?>
