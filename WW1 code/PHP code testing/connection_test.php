<?php
// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<h1>Database Connection Test</h1>";

echo "<h2>Testing connection with DBconnect.php</h2>";
require_once 'DBconnect.php';

if ($connect) {
    echo "<p style='color:green'>Connection successful!</p>";
    
    // Get table structure
    $tableQuery = "SHOW TABLES";
    $tableResult = mysqli_query($connect, $tableQuery);
    
    if (!$tableResult) {
        echo "<p style='color:red'>Error showing tables: " . mysqli_error($connect) . "</p>";
    } else {
        echo "<h3>Tables in database:</h3>";
        echo "<ul>";
        while ($row = mysqli_fetch_row($tableResult)) {
            echo "<li>" . $row[0] . "</li>";
        }
        echo "</ul>";
        
        // Specifically check Biography_Information table
        $bioTableQuery = "DESCRIBE Biography_Information";
        $bioTableResult = mysqli_query($connect, $bioTableQuery);
        
        if (!$bioTableResult) {
            echo "<p style='color:red'>Error describing Biography_Information table: " . mysqli_error($connect) . "</p>";
        } else {
            echo "<h3>Biography_Information table structure:</h3>";
            echo "<table border='1'>";
            echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
            
            while ($row = mysqli_fetch_assoc($bioTableResult)) {
                echo "<tr>";
                echo "<td>" . $row['Field'] . "</td>";
                echo "<td>" . $row['Type'] . "</td>";
                echo "<td>" . $row['Null'] . "</td>";
                echo "<td>" . $row['Key'] . "</td>";
                echo "<td>" . ($row['Default'] ?? 'NULL') . "</td>";
                echo "<td>" . $row['Extra'] . "</td>";
                echo "</tr>";
            }
            
            echo "</table>";
            
            // Show a sample of data
            $sampleQuery = "SELECT * FROM Biography_Information LIMIT 3";
            $sampleResult = mysqli_query($connect, $sampleQuery);
            
            if (!$sampleResult) {
                echo "<p style='color:red'>Error getting sample data: " . mysqli_error($connect) . "</p>";
            } else {
                echo "<h3>Sample data from Biography_Information:</h3>";
                if (mysqli_num_rows($sampleResult) == 0) {
                    echo "<p>No data found in the table.</p>";
                } else {
                    echo "<table border='1'>";
                    $first = true;
                    
                    while ($row = mysqli_fetch_assoc($sampleResult)) {
                        if ($first) {
                            echo "<tr>";
                            foreach ($row as $column => $value) {
                                echo "<th>" . $column . "</th>";
                            }
                            echo "</tr>";
                            $first = false;
                        }
                        
                        echo "<tr>";
                        foreach ($row as $value) {
                            echo "<td>" . ($value ?? 'NULL') . "</td>";
                        }
                        echo "</tr>";
                    }
                    
                    echo "</table>";
                }
            }
        }
    }
} else {
    echo "<p style='color:red'>Connection failed!</p>";
}

echo "<h2>Testing direct connection</h2>";
try {
    $directConnect = mysqli_connect("localhost", "root", "root", "WW1_Soldiers");
    if ($directConnect) {
        echo "<p style='color:green'>Direct connection successful!</p>";
        mysqli_close($directConnect);
    } else {
        echo "<p style='color:red'>Direct connection failed: " . mysqli_connect_error() . "</p>";
    }
} catch (Exception $e) {
    echo "<p style='color:red'>Direct connection exception: " . $e->getMessage() . "</p>";
}

echo "<h2>Testing PDO connection (used in EditDAO.php)</h2>";
try {
    $DB_HOST = 'localhost';
    $DB_NAME = 'WW1_Soldiers';
    $DB_USER = 'root';
    $DB_PASS = 'root';
    
    $pdo = new PDO("mysql:host={$DB_HOST};dbname={$DB_NAME}", $DB_USER, $DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<p style='color:green'>PDO connection successful!</p>";
    
    // Test query
    $stmt = $pdo->query("SELECT 1");
    echo "<p>Test query result: " . $stmt->fetchColumn() . "</p>";
    
} catch (PDOException $e) {
    echo "<p style='color:red'>PDO connection exception: " . $e->getMessage() . "</p>";
}
?> 