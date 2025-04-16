<?php
require_once 'DBconnect.php';
require_once 'function.php'; // where add_Bios() is defined

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    add_Bios();
    echo "Record added successfully";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Add to Database - Biographies</title>
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
  <h1>Add to Database - Biographies</h1>
  <form id="addRecordForm" class="form-section" method="post">
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
      <label for="serviceNo">Service No</label>
      <input type="text" id="serviceNo" name="ServiceNo" placeholder="Enter service number">
    </div>
    <div class="input-group">
      <label for="bioAttachment">Biography Attachment</label>
      <input type="text" id="bioAttachment" name="Biography" placeholder="Enter biography attachment">
    </div>
    <div class="form-buttons">
      <button type="submit" id="submitBtn" class="btn btn-primary">Add Record</button>
      <button type="reset" id="clearFormBtn">Clear Fields</button>
    </div>
  </form>
  <div class="table-container">
    <div class="table-wrapper">
      <table id="recordsTable">
        <thead>
        <tr>
          <th>Surname</th>
          <th>Forename</th>
          <th>Regiment</th>
          <th>Service No</th>
          <th>Biography Attachment</th>
        </tr>
        </thead>
        <tbody>
        <!-- New rows will be added here if desired -->
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
    //event.preventDefault();
    const recordValues = {
      surname: document.getElementById('Surname').value,
      forename: document.getElementById('Forename').value,
      regiment: document.getElementById('Regiment').value,
      serviceNo: document.getElementById('Service_no').value,
      bioAttachment: document.getElementById('Biography').value
    };
    // Build query parameters
    const params = new URLSearchParams();
    params.set("newRecord", "1");
    params.set("Surname", recordValues.surname);
    params.set("Forename", recordValues.forename);
    params.set("Regiment", recordValues.regiment);
    params.set("Service_no", recordValues.serviceNo);
    params.set("Biography", recordValues.bioAttachment);

    // Instead of auto-redirect, ask the user if they want to view the updated Bios table.
    if (confirm("Record added successfully. Would you like to view the updated Biographies table?")) {
      window.location.href = "Bios.php?" + params.toString();
    } else {
      alert("Record added successfully. You can continue adding records.");
      this.reset();
      // Optionally, you might want to update the records table on this page as well.
    }
  });
</script>
</body>
</html>
