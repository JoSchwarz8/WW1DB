<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>

<?php
require_once 'DBconnect.php';  // Database connection
require_once 'function.php'; // Function file
$result= display_gwroh(); //Calls on function to fill rows 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Bradford and surrounding townships</title>
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
  <h1>Bradford and surrounding townships</h1>
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
            <th>Address</th>
            <th>Electoral Ward</th>
            <th>Town</th>
            <th>Rank</th>
            <th>Regiment</th>
            <th>Unit</th>
            <th>Company</th>
            <th>Age</th>
            <th>Service No.</th>
            <th>Other Regiment</th>
            <th>Other Unit</th>
            <th>Other Service No.</th>
            <th>Medals</th>
            <th>Enlistment date</th>
            <th>Discharge date</th>
            <th>Death (in service) date</th>
            <th>Misc Info Nroh</th>
            <th>Cemetery/Memorial</th>
            <th>Cemetery/Memorial Ref</th>
            <th>Cemetery/Memorial Country</th>
            <th>Additional CWGC info</th>
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
            <td><?php echo $row['Address']; ?></td>
            <td><?php echo $row['Electoral Ward']; ?></td>
            <td><?php echo $row['Town']; ?></td>
            <td><?php echo $row['Rank']; ?></td>
            <td><?php echo $row['Regiment']; ?></td>
            <td><?php echo $row['Battalion']; ?></td>
            <td><?php echo $row['Company']; ?></td>
            <td><?php echo $row['DoB']; ?></td>
            <td><?php echo $row['Service no']; ?></td>
            <td><?php echo $row['Other Regiment']; ?></td>
            <td><?php echo $row['Other Unit']; ?></td>
            <td><?php echo $row['Other Service no']; ?></td>
            <td><?php echo $row['Medals']; ?></td>
            <td><?php echo $row['Enlistment Date']; ?></td>
            <td><?php echo $row['Discharge Date']; ?></td>
            <td><?php echo $row['Death (in service) Date']; ?></td>
            <td><?php echo $row['Misc info (Nroh)']; ?></td>
            <td><?php echo $row['Misc info (cwgc)']; ?></td>
            <td><?php echo $row['Cemetery/Memorial']; ?></td>
            <td><?php echo $row['Cemetery/Memorial Ref']; ?></td>
            <td><?php echo $row['Cemetery/Memorial Country']; ?></td>
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
