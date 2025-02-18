<?php
session_start();
if (!isset($_SESSION["role"])) {
    header("Location: index.php");
    exit();
}

$role = $_SESSION["role"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>WW1 Bradford Heroes - Dashboard</title>
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
        <p><b>Select a Database:</b></p>
        <table>
            <tr>
                <td><a href="BradSurrTowns.php">Bradford & Surrounding Townships</a></td>
                <td><a href="BradMem.php">Names on Bradford Memorials</a></td>
                <td><a href="BurBrad.php">Buried in Bradford</a></td>
            </tr>
            <tr>
                <td><a href="NewsRefs.php">Newspaper References</a></td>
                <td><a href="Bios.php">Biographies</a></td>
                <td><a href="logout.php">Logout</a></td>
            </tr>
        </table>
    </main>
</body>
</html>
