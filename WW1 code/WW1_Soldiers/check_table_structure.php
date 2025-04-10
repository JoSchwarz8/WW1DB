<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include database connection
require_once 'DBconnect.php';

// Get the table structure
$query = "DESCRIBE Biography_Information";
$result = mysqli_query($connect, $query);

if (!$result) {
    die("Error executing query: " . mysqli_error($connect));
}

echo "<h2>Biography_Information Table Structure</h2>";
echo "<table border='1'>";
echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>{$row['Field']}</td>";
    echo "<td>{$row['Type']}</td>";
    echo "<td>{$row['Null']}</td>";
    echo "<td>{$row['Key']}</td>";
    echo "<td>{$row['Default']}</td>";
    echo "<td>{$row['Extra']}</td>";
    echo "</tr>";
}

echo "</table>";

// Get sample data
$query = "SELECT * FROM Biography_Information LIMIT 5";
$result = mysqli_query($connect, $query);

if (!$result) {
    die("Error executing query: " . mysqli_error($connect));
}

echo "<h2>Sample Data</h2>";
echo "<table border='1'>";

// Print header row
$firstRow = true;
while ($row = mysqli_fetch_assoc($result)) {
    if ($firstRow) {
        echo "<tr>";
        foreach ($row as $column => $value) {
            echo "<th>{$column}</th>";
        }
        echo "</tr>";
        $firstRow = false;
    }
    
    echo "<tr>";
    foreach ($row as $value) {
        echo "<td>" . htmlspecialchars($value ?? 'NULL') . "</td>";
    }
    echo "</tr>";
}

echo "</table>";

mysqli_close($connect);
?> 