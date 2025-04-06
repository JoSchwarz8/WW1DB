<?php
// Update-Memorials.php
require_once 'EditPHP.php';
require_once 'EditDAO.php';

// Get data from URL parameters if available
$surname = isset($_GET['surname']) ? htmlspecialchars($_GET['surname']) : '';
$forename = isset($_GET['forename']) ? htmlspecialchars($_GET['forename']) : '';
$regiment = isset($_GET['regiment']) ? htmlspecialchars($_GET['regiment']) : '';
$unit = isset($_GET['unit']) ? htmlspecialchars($_GET['unit']) : '';
$memorial = isset($_GET['memorial']) ? htmlspecialchars($_GET['memorial']) : '';
$memorial_location = isset($_GET['memorial_location']) ? htmlspecialchars($_GET['memorial_location']) : '';
$memorial_info = isset($_GET['memorial_info']) ? htmlspecialchars($_GET['memorial_info']) : '';
$memorial_postcode = isset($_GET['memorial_postcode']) ? htmlspecialchars($_GET['memorial_postcode']) : '';
$district = isset($_GET['district']) ? htmlspecialchars($_GET['district']) : '';
$photo_available = isset($_GET['photo_available']) ? htmlspecialchars($_GET['photo_available']) : '';

// Store original values for update where clause
$original_surname = $surname;
$original_forename = $forename;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Update Memorials</title>
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
  <h1>Update Memorials</h1>
  <?php if (!empty($surname)): ?>
  <div style="background-color: #eaf7ea; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
    <p style="margin: 0; color: #28a745;"><strong>You are editing an existing record.</strong> Make your changes and click "Update Record" to save.</p>
  </div>
  <?php else: ?>
  <div style="background-color: #f8f9fa; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
    <p style="margin: 0; color: #6c757d;"><strong>You are creating a new record.</strong> Fill in the form and click "Create Record" to save.</p>
  </div>
  <?php endif; ?>
  <form id="addRecordForm" class="form-section">
    <!-- Hidden fields for original values -->
    <input type="hidden" id="original_surname" name="original_surname" value="<?php echo $original_surname; ?>">
    <input type="hidden" id="original_forename" name="original_forename" value="<?php echo $original_forename; ?>">
    
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
      <label for="unit">Unit</label>
      <input type="text" id="unit" name="unit" placeholder="Enter unit" value="<?php echo $unit; ?>">
    </div>
    <div class="input-group">
      <label for="memorial">Memorial</label>
      <input type="text" id="memorial" name="memorial" placeholder="Enter memorial" value="<?php echo $memorial; ?>">
    </div>
    <div class="input-group">
      <label for="memorial_location">Memorial Location</label>
      <input type="text" id="memorial_location" name="memorial_location" placeholder="Enter memorial location" value="<?php echo $memorial_location; ?>">
    </div>
    <div class="input-group">
      <label for="memorial_info">Memorial Info</label>
      <input type="text" id="memorial_info" name="memorial_info" placeholder="Enter memorial info" value="<?php echo $memorial_info; ?>">
    </div>
    <div class="input-group">
      <label for="memorial_postcode">Memorial Postcode</label>
      <input type="text" id="memorial_postcode" name="memorial_postcode" placeholder="Enter memorial postcode" value="<?php echo $memorial_postcode; ?>">
    </div>
    <div class="input-group">
      <label for="district">District</label>
      <input type="text" id="district" name="district" placeholder="Enter district" value="<?php echo $district; ?>">
    </div>
    <div class="input-group">
      <label for="photo_available">Photo Available</label>
      <input type="text" id="photo_available" name="photo_available" placeholder="Yes/No" value="<?php echo $photo_available; ?>">
    </div>
    <div class="form-buttons">
      <button type="submit" id="submitBtn"><?php echo !empty($surname) ? 'Update Record' : 'Create Record'; ?></button>
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
        <!-- New rows will be added here if desired -->
        </tbody>
      </table>
    </div>
  </div>
  <div class="bottom-section" style="margin-top:20px;">
    <a class="back-button" href="BradMem.php">Back</a>
  </div>
</div>

<script>
  document.getElementById('addRecordForm').addEventListener('submit', function(event) {
    event.preventDefault();
    
    // Get the surname to determine if this is an update or a new record
    const surname = document.getElementById('surname').value.trim();
    const isUpdate = document.getElementById('original_surname').value.trim() !== '';
    
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
      unit: document.getElementById('unit').value,
      memorial: document.getElementById('memorial').value,
      memorial_location: document.getElementById('memorial_location').value,
      memorial_info: document.getElementById('memorial_info').value,
      memorial_postcode: document.getElementById('memorial_postcode').value,
      district: document.getElementById('district').value,
      photo_available: document.getElementById('photo_available').value,
      original_surname: document.getElementById('original_surname').value,
      original_forename: document.getElementById('original_forename').value
    };
    
    // Debug output
    console.log("Sending data:", recordValues);
    
    // Use AJAX to submit the data
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'process_memorial.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
      console.log("Response status:", xhr.status);
      console.log("Response text:", xhr.responseText);
      
      if (xhr.status === 200) {
        // Build query parameters for potential redirect
        const params = new URLSearchParams();
        params.set("newRecord", isUpdate ? "0" : "1");
        Object.entries(recordValues).forEach(([key, value]) => {
          params.set(key, value);
        });

        // Message based on whether it was an update or creation
        const successMessage = isUpdate ? 
          "Record updated successfully. Would you like to view the updated Memorials table?" :
          "Record created successfully. Would you like to view the updated Memorials table?";

        // Ask if they want to view the updated table
        if (confirm(successMessage)) {
          window.location.href = "BradMem.php?" + params.toString();
        } else {
          alert(isUpdate ? "Record updated successfully." : "Record created successfully.");
        }
      } else {
        alert("Error saving record: " + xhr.responseText);
      }
    };
    
    // Prepare data for sending
    const formData = new URLSearchParams();
    Object.entries(recordValues).forEach(([key, value]) => {
      formData.append(key, value);
    });
    
    // Send the data
    xhr.send(formData.toString());
  });

  // Add event listener for the clear fields button
  document.getElementById('clearFormBtn').addEventListener('click', function() {
    if (confirm("Are you sure you want to clear all fields?")) {
      document.getElementById('surname').value = '';
      document.getElementById('forename').value = '';
      document.getElementById('regiment').value = '';
      document.getElementById('unit').value = '';
      document.getElementById('memorial').value = '';
      document.getElementById('memorial_location').value = '';
      document.getElementById('memorial_info').value = '';
      document.getElementById('memorial_postcode').value = '';
      document.getElementById('district').value = '';
      document.getElementById('photo_available').value = '';
      // Don't clear original values
    }
  });
</script>
</body>
</html>