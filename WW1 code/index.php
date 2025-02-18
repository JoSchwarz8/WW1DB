<?php
session_start();
if (isset($_SESSION["role"])) {
    header("Location: dashboard.php");
    exit();
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST["password"];

    // Define credentials (replace with database authentication if needed)
    $admin_password = "admin123"; 
    $guest_password = "guest123";

    if ($password === $admin_password) {
        $_SESSION["role"] = "admin";
        header("Location: dashboard.php");
        exit();
    } elseif ($password === $guest_password) {
        $_SESSION["role"] = "guest";
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>WW1 Bradford Heroes - Login</title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="styles.css" />
</head>
<body>
    <header>
        <div class="website header">
            <b>WW1: Bradford Databases</b>
        </div>
    </header>
    <main>
        <form method="POST">
            <label for="password">Password: </label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Login</button>
        </form>
        <?php if ($error): ?>
            <p style="color: red;"><?= $error ?></p>
        <?php endif; ?>
    </main>
</body>
</html>
