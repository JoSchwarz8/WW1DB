<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>

<?php
require_once 'DBconnect.php';  // Database connection
require_once 'function.php'; // Function file
$result= display_NewsRefs(); //Calls on function to fill rows 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Newspaper index</title>
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
  <h1>Newspaper index</h1>
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
      <button type="button" id="clearBtn">Clear fields</button>
      <button type="button" id="searchBtn">Search</button>
    </div>
  </div>
  <div class="main-content">
    <div class="table-container">
      <div class="table-wrapper">
        <table id="dataTable">
          <thead>
          <tr>
            <th></th>
            <th>Surname</th>
            <th>Forename</th>
            <th>Rank</th>
            <th>Address</th>
            <th>Regiment</th>
            <th>Unit</th>
            <th>Article Comment</th>
            <th>Newspaper Name</th>
            <th>Newspaper Date</th>
            <th>Page/Col</th>
            <th>Photo incl</th>
          </tr>
          </thead>
          <tbody>
          <tr>
            <?php

            while($row= mysqli_fetch_assoc($result)){ //fills rows with data from db

            ?>
            <td class="radio-cell"><input type="radio" name="recordSelect"></td>
            <td><?php echo $row['Surname']; ?></td>
            <td><?php echo $row['Forename']; ?></td>
            <td><?php echo $row['Rank']; ?></td>
            <td><?php echo $row['Address']; ?></td>
            <td><?php echo $row['Regiment']; ?></td>
            <td><?php echo $row['Battalion']; ?></td>
            <td><?php echo $row['Article Comment']; ?></td>
            <td><?php echo $row['Newspaper Name']; ?></td>
            <td><?php echo $row['Newspaper Date']; ?></td>
            <td><?php echo $row['PageCol']; ?></td>
            <td><?php echo $row['PhotoIncl']; ?></td>
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
    <div class="search-results">No of search results: <span id="resultsCount">0</span></div>
    <div class="nav-buttons">
      <button type="button" id="prevBtn">&larr;</button>
      <button type="button" id="nextBtn">&rarr;</button>
    </div>
    <a class="back-button" href="dashboardGuest.html">Back</a>
  </div>
</div>
<script>
  document.getElementById('clearBtn').addEventListener('click', () => {
    document.getElementById('forename').value = '';
    document.getElementById('surname').value = '';
  });
  document.getElementById('searchBtn').addEventListener('click', () => {
    alert('Search functionality not implemented.');
  });
  document.getElementById('prevBtn').addEventListener('click', () => {
    alert('Previous page not implemented.');
  });
  document.getElementById('nextBtn').addEventListener('click', () => {
    alert('Next page not implemented.');
  });
</script>
</body>
</html>
