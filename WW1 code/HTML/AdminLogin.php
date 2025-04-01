<?php

require_once 'DBConnection.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['adminusername'] ?? '';
    $password = $_POST['adminpassword'] ?? '';

    try {
        $conn = DBConnection::getConnection();
        $sql = "SELECT * FROM user_details WHERE `User Type` = ? AND password = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute(["Admin", $password]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            header("Location: dashboard.html");
            exit();
        } else {
            echo "<h3>Login Failed. Invalid username or password. Go back to the login page and try again.</h3>";
        }
    } catch (Exception $e) {
        echo "<h3>Error: " . htmlspecialchars($e->getMessage()) . "</h3>";
    }
}

?>
