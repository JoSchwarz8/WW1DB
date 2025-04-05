<?php
// updateBiographies.php
require_once 'EditBiography.php';
require_once 'EditPHP.php';
require_once 'EditDAO.php'; // Asegúrate de tener este archivo y su conexión a la BD.

// Get data from URL parameters if available
$surname = isset($_GET['surname']) ? htmlspecialchars($_GET['surname']) : '';
$forename = isset($_GET['forename']) ? htmlspecialchars($_GET['forename']) : '';
$regiment = isset($_GET['regiment']) ? htmlspecialchars($_GET['regiment']) : '';
$serviceNo = isset($_GET['serviceNo']) ? htmlspecialchars($_GET['serviceNo']) : '';
$bioAttachment = isset($_GET['bioAttachment']) ? htmlspecialchars($_GET['bioAttachment']) : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Update Biographies</title>
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
  <h1>Update Biographies</h1>
  <?php if (!empty($serviceNo)): ?>
  <div style="background-color: #eaf7ea; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
    <p style="margin: 0; color: #28a745;"><strong>You are editing an existing record.</strong> Make your changes and click "Update Record" to save.</p>
  </div>
  <?php else: ?>
  <div style="background-color: #f8f9fa; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
    <p style="margin: 0; color: #6c757d;"><strong>You are creating a new record.</strong> Fill in the form and click "Update Record" to save.</p>
  </div>
  <?php endif; ?>
  <form id="addRecordForm" class="form-section">
    <div class="input-group">
      <label for="surname">Surname</label>
      <input type="text" id="surname" name="surname" placeholder="Enter surname" value="<?php echo $surname; ?>" required>
    </div>
    <div class="input-group">
      <label for="forename">Forename</label>
      <input type="text" id="forename" name="forename" placeholder="Enter forename" value="<?php echo $forename; ?>" required>
    </div>
    <div class="input-group">
      <label for="regiment">Regiment</label>
      <input type="text" id="regiment" name="regiment" placeholder="Enter regiment" value="<?php echo $regiment; ?>">
    </div>
    <div class="input-group">
      <label for="serviceNo">Service No</label>
      <input type="text" id="serviceNo" name="serviceNo" placeholder="Enter service number" value="<?php echo $serviceNo; ?>">
    </div>
    <div class="input-group">
      <label for="bioAttachment">Biography Attachment</label>
      <input type="text" id="bioAttachment" name="bioAttachment" placeholder="Enter biography attachment" value="<?php echo $bioAttachment; ?>">
    </div>
    <div class="form-buttons">
      <button type="submit" id="submitBtn"><?php echo !empty($serviceNo) ? 'Update Record' : 'Create Record'; ?></button>
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
    <a class="back-button" href="Bios.php">Back</a>
  </div>
</div>

<script>
  document.getElementById('addRecordForm').addEventListener('submit', function(event) {
    event.preventDefault();
    
    // Get the service number to determine if this is an update or a new record
    const serviceNo = document.getElementById('serviceNo').value.trim();
    const isUpdate = serviceNo !== '';
    
    // Confirm action based on whether it's an update or creation
    if (isUpdate) {
      if (!confirm("Are you sure you want to update this record?")) {
        return;
      }
    } else {
      if (!confirm("Are you sure you want to create a new record?")) {
        return;
      }
    }
    
    const recordValues = {
      surname: document.getElementById('surname').value,
      forename: document.getElementById('forename').value,
      regiment: document.getElementById('regiment').value,
      serviceNo: document.getElementById('serviceNo').value,
      bioAttachment: document.getElementById('bioAttachment').value
    };
    
    // Debug output
    console.log("Sending data:", recordValues);
    
    // Use AJAX to submit the data
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'process_biography.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
      console.log("Response status:", xhr.status);
      console.log("Response text:", xhr.responseText);
      
      if (xhr.status === 200) {
        // Build query parameters for potential redirect
        const params = new URLSearchParams();
        params.set("newRecord", isUpdate ? "0" : "1");
        params.set("surname", recordValues.surname);
        params.set("forename", recordValues.forename);
        params.set("regiment", recordValues.regiment);
        params.set("serviceNo", recordValues.serviceNo);
        params.set("bioAttachment", recordValues.bioAttachment);

        // Message based on whether it was an update or creation
        const successMessage = isUpdate ? 
          "Record updated successfully. Would you like to view the updated Biographies table?" :
          "Record created successfully. Would you like to view the updated Biographies table?";

        // Ask if they want to view the updated table
        if (confirm(successMessage)) {
          window.location.href = "Bios.php?" + params.toString();
        } else {
          alert(isUpdate ? "Record updated successfully." : "Record created successfully.");
        }
      } else {
        alert("Error saving record: " + xhr.responseText);
      }
    };
    
    // Prepare data for sending
    const formData = new URLSearchParams();
    formData.append('surname', recordValues.surname);
    formData.append('forename', recordValues.forename);
    formData.append('regiment', recordValues.regiment);
    formData.append('serviceNo', recordValues.serviceNo);
    formData.append('bioAttachment', recordValues.bioAttachment);
    
    // Log what's actually being sent
    console.log("Form data being sent:", formData.toString());
    
    // Send the data
    xhr.send(formData.toString());
  });

  // Add event listener for the clear fields button
  document.getElementById('clearFormBtn').addEventListener('click', function() {
    if (confirm("Are you sure you want to clear all fields?")) {
      document.getElementById('surname').value = '';
      document.getElementById('forename').value = '';
      document.getElementById('regiment').value = '';
      document.getElementById('serviceNo').value = '';
      document.getElementById('bioAttachment').value = '';
    }
  });
</script>
</body>
</html>
