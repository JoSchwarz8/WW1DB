<?php
/*
require_once 'DBconnect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['guestusername'] ?? '';
    $password = $_POST['guestpassword'] ?? '';

    try {
        $conn = DBConnection::getConnection();
        $sql = "SELECT * FROM user_details WHERE `User Type` = ? AND password = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute(["Guest", $password]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            header("Location: dashboardGuest.html");
            exit();
        } else {
            echo "<h3>Login Failed. Invalid username or password.</h3>";
        }
    } catch (Exception $e) {
        echo "<h3>Error: " . htmlspecialchars($e->getMessage()) . "</h3>";
    }
}

?>
*/

session_start();  // Start the session at the very beginning

require_once 'DBconnect.php'; // Ensure this file sets up the $connect variable

// Define constants for maximum attempts and lockout duration
define('MAX_ATTEMPTS', 3);
define('LOCKOUT_DURATION', 15 * 60); // 15 minutes in seconds

// Initialize session variables if not set
if (!isset($_SESSION['failed_attempts'])) {
    $_SESSION['failed_attempts'] = 0;
}
if (!isset($_SESSION['lockout_time'])) {
    $_SESSION['lockout_time'] = null;
}

// Check if the user is currently locked out
if ($_SESSION['lockout_time'] !== null) {
    $remainingLockout = ($_SESSION['lockout_time'] + LOCKOUT_DURATION) - time();
    if ($remainingLockout > 0) {
        die("<h3>Too many unsuccessful login attempts. Please try again in " . ceil($remainingLockout / 60) . " minute(s).</h3>");
    } else {
        // Reset lockout after duration has passed
        $_SESSION['lockout_time'] = null;
        $_SESSION['failed_attempts'] = 0;
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $guestpassword = $_POST['guestpassword'] ?? '';

    // Prepare the SQL query using a prepared statement
    $sql = "SELECT * FROM user_details WHERE `User Type` = ? AND BINARY password = ?";
    if ($stmt = $connect->prepare($sql)) {
        $userType = "Guest";
        $stmt->bind_param("ss", $userType, $guestpassword);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            // Successful login: reset the failed_attempts counter and lockout_time
            $_SESSION['failed_attempts'] = 0;
            $_SESSION['lockout_time'] = null;
            header("Location: dashboardGuest.html");
            exit();
        } else {
            // Unsuccessful login: increment the failed_attempts counter
            $_SESSION['failed_attempts']++;
            if ($_SESSION['failed_attempts'] >= MAX_ATTEMPTS) {
                $_SESSION['lockout_time'] = time();
                die("<h3>Too many unsuccessful login attempts. Please try again in 15 minutes.</h3>");
            } else {
                $attemptsLeft = MAX_ATTEMPTS - $_SESSION['failed_attempts'];
                echo "<h3>Login Failed. Invalid username or password.</h3>";
                echo "<p>You have $attemptsLeft attempt(s) remaining.</p>";
            }
        }
    } else {
        echo "<h3>SQL Error: " . $connect->error . "</h3>";
    }
}
?>

