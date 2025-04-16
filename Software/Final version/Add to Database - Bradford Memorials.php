a<?php
require_once 'DBconnect.php';
require_once 'function.php'; // where add_Bios() is defined

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    add_Memorials();
    echo "Record added successfully";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Add to Database - Bradford Memorials</title>
  <link rel="stylesheet" href="styles.css">
  <style>
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
      display: flex;
      flex-direction: column;
      flex: 1 1 200px;
    }
    .form-section label {
      color: #9b111e;
      font-weight: bold;
      margin-bottom: 5px;
      font-size: 0.9rem;
    }
    .form-section input[type="text"] {
      border: 1px solid #ccc;
      border-radius: 4px;
      padding: 8px 12px;
      background-color: #fff;
      font-size: 0.9rem;
    }
    .form-buttons {
      display: flex;
      gap: 10px;
      width: 100%;
      justify-content: flex-start;
      margin-top: 10px;
    }
    .table-wrapper {
      overflow-x: auto;
    }
    .table-container table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    .table-container th,
    .table-container td {
      border: 1px solid #ddd;
      padding: 6px 8px;
      white-space: nowrap;
      font-size: 0.8rem;
    }
    .table-container thead {
      background-color: #9b111e;
      color: #fff;
    }
  </style>
</head>
<body class="table-page">
<div class="container">
  <h1>Add to Database - Bradford Memorials</h1>
  <form id="addRecordForm" class="form-section" method="post">
    <!-- Bradford Memorial fields -->
    <div class="input-group">
      <label for="surname">Surname</label>
      <input type="text" id="surname" name="Surname" placeholder="Enter surname" required>
    </div>
    <div class="input-group">
      <label for="forename">Forename</label>
      <input type="text" id="forename" name="Forename" placeholder="Enter forename" required>
    </div>
    <div class="input-group">
      <label for="regiment">Regiment</label>
      <input type="text" id="regiment" name="Regiment" placeholder="Enter regiment">
    </div>
    <div class="input-group">
      <label for="Battalion">Battalion</label>
      <input type="text" id="Battalion" name="Battalion" placeholder="Enter Battalion">
    </div>
    <div class="input-group">
      <label for="memorial">Memorial</label>
      <input type="text" id="memorial" name="Memorial" placeholder="Enter memorial">
    </div>
    <div class="input-group">
      <label for="memorialLocation">Memorial Location</label>
      <input type="text" id="memorialLocation" name="MemorialLocation" placeholder="Enter memorial location">
    </div>
    <div class="input-group">
      <label for="memorialInfo">Memorial Info</label>
      <input type="text" id="memorialInfo" name="MemorialInfo" placeholder="Enter memorial info">
    </div>
    <div class="input-group">
      <label for="memorialPostcode">Memorial Postcode</label>
      <input type="text" id="memorialPostcode" name="MemorialPostcode" placeholder="Enter memorial postcode">
    </div>
    <div class="input-group">
      <label for="district">District</label>
      <input type="text" id="district" name="District" placeholder="Enter district">
    </div>
    <div class="input-group">
      <label for="photoAvailable">Photo Available</label>
      <input type="text" id="photoAvailable" name="PhotoAvailable" placeholder="Enter photo available status">
    </div>
    <div class="form-buttons">
      <button type="submit" id="submitBtn" class="btn btn-primary">Add Record</button>
      <button type="reset" id="clearFormBtn">Clear Fields</button>
    </div>
  </form>
  <!-- Optional table to display records on this page -->
  <div class="table-container">
    <div class="table-wrapper">
      <table id="recordsTable">
        <thead>
        <tr>
          <th>Surname</th>
          <th>Forename</th>
          <th>Regiment</th>
          <th>Unit</th>
          <th>Memorial</th>
          <th>Memorial Location</th>
          <th>Memorial Info</th>
          <th>Memorial Postcode</th>
          <th>District</th>
          <th>Photo Available</th>
        </tr>
        </thead>
        <tbody>
        <!-- New rows will be added here if you choose not to redirect -->
        </tbody>
      </table>
    </div>
  </div>
  <div class="bottom-section" style="margin-top:20px;">
    <a class="back-button" href="dashboard.html">Back</a>
  </div>
</div>
<script>
  document.getElementById('addRecordForm').addEventListener('submit', function(event) {
    const recordValues = {
      surname: document.getElementById('surname').value,
      forename: document.getElementById('forename').value,
      regiment: document.getElementById('regiment').value,
      battalion: document.getElementById('battalion').value,
      memorial: document.getElementById('memorial').value,
      memorialLocation: document.getElementById('memorialLocation').value,
      memorialInfo: document.getElementById('memorialInfo').value,
      memorialPostcode: document.getElementById('memorialPostcode').value,
      district: document.getElementById('district').value,
      photoAvailable: document.getElementById('photoAvailable').value
    };
    const params = new URLSearchParams();
    params.set("newRecord", "1");
    params.set("Surname", recordValues.surname);
    params.set("Forename", recordValues.forename);
    params.set("Regiment", recordValues.regiment);
    params.set("Battalion", recordValues.battalion);
    params.set("Memorial", recordValues.memorial);
    params.set("MemorialLocation", recordValues.memorialLocation);
    params.set("MemorialInfo", recordValues.memorialInfo);
    params.set("MemorialPostcode", recordValues.memorialPostcode);
    params.set("District", recordValues.district);
    params.set("PhotoAvailable", recordValues.photoAvailable);



    if (confirm("Record added successfully. Would you like to view the updated Bradford Memorials table?")) {
      window.location.href = "BradMem.php?" + params.toString();
    } else {
      alert("Record added successfully.");
      this.reset();
    }
  });
</script>
</body>
</html>
