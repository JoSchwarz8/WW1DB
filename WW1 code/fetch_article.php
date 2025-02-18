<?php
session_start();
include 'config.php';

if (!isset($_SESSION["role"])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit();
}

$article_id = $_GET["id"];

$stmt = $pdo->prepare("SELECT article_path FROM newspaper_references WHERE id = ?");
$stmt->execute([$article_id]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result && file_exists($result["article_path"])) {
    header("Content-Type: application/pdf");
    header("Content-Disposition: attachment; filename=" . basename($result["article_path"]));
    readfile($result["article_path"]);
    exit();
} else {
    echo json_encode(["status" => "error", "message" => "Document not found"]);
}
?>
