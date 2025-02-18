<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $role = $_POST["role"]; // "admin" or "guest"

    if (!in_array($role, ["admin", "guest"])) {
        echo json_encode(["status" => "error", "message" => "Invalid role"]);
        exit();
    }

    // Check if username exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        echo json_encode(["status" => "error", "message" => "Username already exists"]);
        exit();
    }

    // Hash the password before storing
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->execute([$username, $hashed_password, $role]);

    echo json_encode(["status" => "success", "message" => "User registered successfully"]);
}
?>
