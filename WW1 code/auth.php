<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["role"] = $user["role"];
        echo json_encode(["status" => "success", "message" => "Login successful", "role" => $user["role"]]);
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid credentials"]);
    }
}
?>
