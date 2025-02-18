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
    $cemetery = $_POST["cemetery"] ?? '';

    $query = "SELECT * FROM burials WHERE 1=1";
    $params = [];

    if ($surname) {
        $query .= " AND surname LIKE ?";
        $params[] = "%$surname%";
    }
    if ($forename) {
        $query .= " AND forename LIKE ?";
        $params[] = "%$forename%";
    }
    if ($cemetery) {
        $query .= " AND cemetery LIKE ?";
        $params[] = "%$cemetery%";
    }

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Burials in Bradford</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header><b>WW1: Buried in Bradford</b></header>
    <main>
        <h2>Search Burial Records</h2>
        <form method="POST">
            <label for="surname">Surname:</label>
            <input type="text" id="surname" name="surname">
            <label for="forename">Forename:</label>
            <input type="text" id="forename" name="forename">
            <label for="cemetery">Cemetery:</label>
            <input type="text" id="cemetery" name="cemetery">
            <button type="submit">Search</button>
        </form>

        <?php if ($results): ?>
            <h3>Results:</h3>
            <table border="1">
                <tr><th>Surname</th><th>Forename</th><th>Cemetery</th></tr>
                <?php foreach ($results as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row["surname"]) ?></td>
                        <td><?= htmlspecialchars($row["forename"]) ?></td>
                        <td><?= htmlspecialchars($row["cemetery"]) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
        <a href="dashboard.php">Back</a>
    </main>
</body>
</html>
