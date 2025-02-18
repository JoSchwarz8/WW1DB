<?php
session_start();
if (!isset($_SESSION["role"])) {
    header("Location: index.php");
    exit();
}

include 'config.php';

$results = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $surname = $_POST["surname"] ?? '';
    $forename = $_POST["forename"] ?? '';

    $query = "SELECT * FROM biographies WHERE 1=1";
    $params = [];

    if ($surname) {
        $query .= " AND surname LIKE ?";
        $params[] = "%$surname%";
    }
    if ($forename) {
        $query .= " AND forename LIKE ?";
        $params[] = "%$forename%";
    }

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Search Biographies</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header><b>WW1: Bradford Biographies</b></header>
    <main>
        <h2>Search Biographies</h2>
        <form method="POST">
            <label for="surname">Surname:</label>
            <input type="text" id="surname" name="surname">
            <label for="forename">Forename:</label>
            <input type="text" id="forename" name="forename">
            <button type="submit">Search</button>
        </form>

        <?php if ($results): ?>
            <h3>Results:</h3>
            <table border="1">
                <tr><th>Surname</th><th>Forename</th><th>Biography</th></tr>
                <?php foreach ($results as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row["surname"]) ?></td>
                        <td><?= htmlspecialchars($row["forename"]) ?></td>
                        <td><a href="fetch_bio.php?id=<?= $row['id'] ?>">Download</a></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
        <a href="dashboard.php">Back</a>
    </main>
</body>
</html>
