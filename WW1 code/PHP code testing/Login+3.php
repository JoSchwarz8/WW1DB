<?php
session_start(); // Start the session to store attempts

require_once 'DBConnection.php';

// Initialize the attempts counter if it doesn't exist
if (!isset($_SESSION['attempts'])) {
    $_SESSION['attempts'] = 0;
}

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
            // Reset the attempts counter on a successful login
            $_SESSION['attempts'] = 0;
            header("Location: dashboard.html");
            exit();
        } else {
            // Increment the counter for a failed attempt
            $_SESSION['attempts']++;

            if ($_SESSION['attempts'] >= 3) {
                // If 3 or more failed attempts, "lock" the login page.
                echo "<h3>Too many failed login attempts. The page is now locked.</h3>";
                exit();
            } else {
                echo "<h3>Login Failed. Invalid username or password. Attempt " . $_SESSION['attempts'] . " of 3.</h3>";
            }
        }
    } catch (Exception $e) {
        echo "<h3>Error: " . htmlspecialchars($e->getMessage()) . "</h3>";
    }
}
?>
