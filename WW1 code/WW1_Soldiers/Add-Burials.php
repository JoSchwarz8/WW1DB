<?php
require_once 'DBconnect.php';
require_once 'function.php'; // where add_Bios() is defined

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    add_Burials();
    echo "Record added successfully";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add to Database - Those Buried in Bradford</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    /* Consistent theme styling */
    .form-section {
      background-color: #999;
      padding: 20px;
      border-radius: 8px;
      margin-bottom: 20px;
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      align-items: flex-start;
    }
    .form-section .input-group {
      flex: 1 1 200px;
      display: flex;
      flex-direction: column;
    }
    .form-section label {
      color: #9b111e;
      font-weight: bold;
      margin-bottom: 5px;
      font-size: 0.9rem;
    }
    .form-section input[type="text"],
    .form-section input[type="date"] {
      padding: 8px 12px;
      font-size: 0.9rem;
      border: 1px solid #ccc;
      border-radius: 4px;
      background-color: #fff;
    }
    .form-buttons {
      display: flex;
      gap: 10px;
      width: 100%;
      margin-top: 10px;
    }
    .table-container {
      margin-top: 20px;
      overflow-x: auto;
    }
    .table-container table {
      width: 100%;
      border-collapse: collapse;
    }
    .table-container th,
    .table-container td {
      border: 1px solid #ddd;
      padding: 6px 8px;
      font-size: 0.8rem;
      white-space: nowrap;
    }
    .table-container thead {
      background-color: #9b111e;
      color: #fff;
    }
  </style>
</head>
<body class="table-page">
<div class="container">
  <h1>Add to Database - Those Buried in Bradford</h1>
  <form id="addRecordForm" class="form-section" method="post">
    <!-- Input groups for each field -->
    <div class="input-group">
      <label for="surname">Surname</label>
      <input type="text" id="surname" name="Surname" placeholder="Enter surname" required>
    </div>
    <div class="input-group">
      <label for="forename">Forename</label>
      <input type="text" id="forename" name="Forename" placeholder="Enter forename" required>
    </div>
    <div class="input-group">
      <label for="age">Age</label>
      <input type="text" id="age" name="DoB" placeholder="Enter age">
    </div>
    <div class="input-group">
      <label for="medals">Medals</label>
      <input type="text" id="medals" name="Medals" placeholder="Enter medals">
    </div>
    <div class="input-group">
      <label for="dateOfDeath">Date of Death</label>
      <input type="date" id="dateOfDeathBurials" name="Date_of_Death">
    </div>
    <div class="input-group">
      <label for="rank">Rank</label>
      <input type="text" id="rank" name="Rank" placeholder="Enter rank">
    </div>
    <div class="input-group">
      <label for="serviceNumber">Service Number</label>
      <input type="text" id="serviceNumberBurials" name="Service_Number" placeholder="Enter service number">
    </div>
    <div class="input-group">
      <label for="regiment">Regiment</label>
      <input type="text" id="regiment" name="Regiment" placeholder="Enter regiment">
    </div>
    <div class="input-group">
      <label for="unit">Unit</label>
      <input type="text" id="unit" name="Battalion" placeholder="Enter unit">
    </div>
    <div class="input-group">
      <label for="cemetery">Cemetery</label>
      <input type="text" id="cemetery" name="Cemetery" placeholder="Enter cemetery">
    </div>
    <div class="input-group">
      <label for="graveReference">Grave Reference</label>
      <input type="text" id="graveReference" name="Grave_Reference" placeholder="Enter grave reference">
    </div>
    <div class="input-group">
      <label for="info">Info</label>
      <input type="text" id="info" name="Info" placeholder="Enter additional info">
    </div>
    <div class="form-buttons">
      <button type="submit" id="submitBtn" class="btn btn-primary">Add Record</button>
      <button type="reset" id="clearFormBtn">Clear Fields</button>
    </div>
  </form>

  <!-- Optional table to display records on this page -->
  <div class="table-container">
    <table id="recordsTable">
      <thead>
      <tr>
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
      <!-- New rows will be added here if you choose not to redirect -->
      </tbody>
    </table>
  </div>

  <div class="bottom-section" style="margin-top:20px;">
    <a class="back-button" href="dashboard.html">Back</a>
  </div>
</div>

<script>
  document.getElementById('addRecordForm').addEventListener('submit', function(event) {
    
    const recordValues = {
      surname: document.getElementById('Surname').value,
      forename: document.getElementById('Forename').value,
      age: document.getElementById('DoB').value,
      medals: document.getElementById('Medals').value,
      dateOfDeath: document.getElementById('Date_of_Death').value,
      rank: document.getElementById('Rank').value,
      serviceNumber: document.getElementById('Service_Number').value,
      regiment: document.getElementById('Regiment').value,
      unit: document.getElementById('Unit').value,
      cemetery: document.getElementById('Cemetery').value,
      graveReference: document.getElementById('Grave_Reference').value,
      info: document.getElementById('Info').value
    };
    const params = new URLSearchParams();
    params.set("newRecord", "1");
    for (const key in recordValues) {
      params.set(key, recordValues[key]);
    }
    if (confirm("Record added successfully. Would you like to view the updated Those Buried in Bradford table?")) {
      window.location.href = "BurBrad.php?" + params.toString();
    } else {
      alert("Record added successfully. You can continue adding records.");
      this.reset();
    }
  });
</script>
</body>
</html>
