<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>

<?php
require_once 'DBconnect.php';  // Database connection
require_once 'function.php'; // Function file
$result= display_Burials(); //Calls on function to fill rows 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Those buried in Bradford</title>
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
  <h1>Those buried in Bradford</h1>
  <div class="search-row">
    <div class="input-group">
      <label for="forename">Forename:</label>
      <input type="text" id="forename" placeholder="Enter forename">
    </div>
    <div class="input-group">
      <label for="surname">Surname:</label>
      <input type="text" id="surname" placeholder="Enter surname">
    </div>
    <div class="input-group">
      <label for="cemetery">Cemetery:</label>
      <input type="text" id="cemetery" placeholder="Enter cemetery">
    </div>
    <div class="search-buttons">
      <button type="button" id="clearFieldsBtn">Clear Fields</button>
      <button type="button" id="searchBtn">Search</button>
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
            <th>Age</th>
            <th>Medals</th>
            <th>Date of Death</th>
            <th>Rank</th>
            <th>Service Number</th>
            <th>Regiment</th>
            <th>Unit</th>
            <th>Cemetery</th>
            <th>Grave Reference</th>
            <th>Info</th>
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
            <td><?php echo $row['DoB']; ?></td>
            <td><?php echo $row['Medals']; ?></td>
            <td><?php echo $row['Date_of_Death']; ?></td>
            <td><?php echo $row['Rank']; ?></td>
            <td><?php echo $row['Service_Number']; ?></td>
            <td><?php echo $row['Regiment']; ?></td>
            <td><?php echo $row['Battalion']; ?></td>
            <td><?php echo $row['Cemetery']; ?></td>
            <td><?php echo $row['Grave_Reference']; ?></td>
            <td><?php echo $row['Info']; ?></td>
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
<script>
  const clearFieldsBtn = document.getElementById('clearFieldsBtn');
  clearFieldsBtn.addEventListener('click', () => {
    document.getElementById('forename').value = '';
    document.getElementById('surname').value = '';
    document.getElementById('cemetery').value = '';
  });
  document.getElementById('searchBtn').addEventListener('click', () => {
    alert('Search functionality not implemented.');
  });
</script>
</body>
</html>
