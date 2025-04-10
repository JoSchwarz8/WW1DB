<?php
session_start();  // Start session

// Initialize session variables if they don't exist
if (!isset($_SESSION['failed_attempts'])) {
    $_SESSION['failed_attempts'] = 0;
}

if (!isset($_SESSION['lockout_time'])) {
    $_SESSION['lockout_time'] = null;
}

// Check if the user is locked out
if ($_SESSION['failed_attempts'] >= 3) {
    $lockoutDuration = 15 * 60; // 15 minutes in seconds
    $currentTime = time();

    // If it's the first lockout, store the lockout time
    if ($_SESSION['lockout_time'] === null) {
        $_SESSION['lockout_time'] = $currentTime;
    }

    // Check how much time has passed
    $elapsedTime = $currentTime - $_SESSION['lockout_time'];
    if ($elapsedTime < $lockoutDuration) {
        $minutesLeft = ceil(($lockoutDuration - $elapsedTime) / 60);
        echo "<h3>Too many failed login attempts. Please try again in $minutesLeft minute(s).</h3>";
        exit;
    } else {
        // Lockout period over: reset counters
        $_SESSION['failed_attempts'] = 0;
        $_SESSION['lockout_time'] = null;
    }
}

require_once 'DBconnect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $adminusername = $_POST['adminusername'] ?? '';
    $adminpassword = $_POST['adminpassword'] ?? '';

    // Use case-sensitive password check
    $sql = "SELECT * FROM user_details WHERE `User Type` = ? AND BINARY password = ?";
    if ($stmt = $connect->prepare($sql)) {
        $userType = "Admin";
        $stmt->bind_param("ss", $userType, $adminpassword);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            // Success: reset everything
            $_SESSION['failed_attempts'] = 0;
            $_SESSION['lockout_time'] = null;
            header("Location: dashboard.html");
            exit();
        } else {
            // Failure: increment failed attempts
            $_SESSION['failed_attempts']++;
            echo "<h3>Login Failed. Invalid username or password.</h3>";

            $attemptsLeft = 3 - $_SESSION['failed_attempts'];
            if ($attemptsLeft > 0) {
                echo "<p>You have $attemptsLeft attempt(s) remaining.</p>";
            } else {
                echo "<p>You have reached the maximum number of attempts. Please try again in 15 minutes.</p>";
            }
        }
    } else {
        echo "<h3>SQL Error: " . $connect->error . "</h3>";
    }
}
?>

