<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>

<?php
require_once 'DBconnect.php';  // Database connection
require_once 'function.php'; // Function file
$result= display_Memorials(); //Calls on function to fill rows 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bradford Memorials</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .table-container {
            flex: 1;
            min-width: 0;
        }
        .scrollable-table {
            overflow-x: auto;
        }
    </style>
</head>
<body class="table-page">
<div class="container">
    <h1>Bradford Memorials</h1>

    <div class="search-row">
        <div class="input-group">
            <label for="forename">Forename:</label>
            <input type="text" id="forename" placeholder="Enter forename">
        </div>
        <div class="input-group">
            <label for="surname">Surname:</label>
            <input type="text" id="surname" placeholder="Enter surname">
        </div>
        <div class="search-buttons">
            <button type="button">Clear fields</button>
            <button type="button">Search</button>
        </div>
    </div>

    <div class="main-content">
        <div class="table-container">
            <div class="scrollable-table">
                <table id="dataTable">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Surname</th>
                        <th>Forename</th>
                        <th>Regiment</th>
                        <th>Unit</th>
                        <th>Memorial</th>
                        <th>Memorial location</th>
                        <th>Memorial info</th>
                        <th>Memorial Postcode</th>
                        <th>District</th>
                        <th>Photo available</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <?php

            while($row= mysqli_fetch_assoc($result)){ //fills rows with data from db

            ?>
                        <td><input type="radio" name="recordSelect"></td>
                        <td><?php echo $row['Surname']; ?></td>
                        <td><?php echo $row['Forename']; ?></td>
                        <td><?php echo $row['Regiment']; ?></td>
                        <td><?php echo $row['Battalion']; ?></td>
                        <td><?php echo $row['Memorial']; ?></td>
                        <td><?php echo $row['MemorialLocation']; ?></td>
                        <td><?php echo $row['MemorialInfo']; ?></td>
                        <td><?php echo $row['MemorialPostcode']; ?></td>
                        <td><?php echo $row['District']; ?></td>
                        <td><?php echo $row['PhotoAvailable']; ?></td>
                    </tr>
                    <?php
                       }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="bottom-section">
        <div class="search-results">No of search results: <span id="searchResults">0</span></div>
        <div class="nav-buttons">
            <button type="button">&larr;</button>
            <button type="button">&rarr;</button>
        </div>
        <a class="back-button" href="dashboardGuest.html">Back</a>
    </div>
</div>
</body>
</html>
