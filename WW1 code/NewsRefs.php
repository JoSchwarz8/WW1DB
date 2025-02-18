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

    $query = "SELECT * FROM newspaper_references WHERE 1=1";
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
    <title>Newspaper References</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="website header">
            <b>WW1: Newspaper References</b>
        </div>
    </header>
    <main>
        <h2>Search Newspaper References</h2>
        <form method="POST">
            <label for="surname">Surname:</label>
            <input type="text" id="surname" name="surname">
            <label for="forename">Forename:</label>
            <input type="text" id="forename" name="forename">
            <button type="submit">Search</button>
            <button type="reset">Clear</button>
        </form>

        <?php if ($results): ?>
            <h3>Results:</h3>
            <table border="1">
                <tr><th>Surname</th><th>Forename</th><th>Newspaper Name</th><th>Article Description</th><th>Published Date</th><th>Download</th></tr>
                <?php foreach ($results as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row["surname"]) ?></td>
                        <td><?= htmlspecialchars($row["forename"]) ?></td>
                        <td><?= htmlspecialchars($row["newspaper_name"]) ?></td>
                        <td><?= htmlspecialchars($row["article_description"]) ?></td>
                        <td><?= htmlspecialchars($row["paper_date"]) ?></td>
                        <td>
                            <?php if (!empty($row["article_path"])): ?>
                                <a href="fetch_article.php?id=<?= $row['id'] ?>">Download</a>
                            <?php else: ?>
                                No file available
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
        <a href="dashboard.php">Back</a>
    </main>
</body>
</html>
