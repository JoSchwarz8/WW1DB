<?php
// Update-Burials.php - Process burial record updates
require_once 'EditDAO.php';
require_once 'EditBurials.php';
require_once 'DBconnect.php';

// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Handle POST request - process the update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Log file access for debugging
    error_log("Update-Burials.php POST accessed at " . date('Y-m-d H:i:s'));
    error_log("POST data: " . json_encode($_POST));
    
    // Process form data
    try {
        // Get data from POST
        $id = isset($_POST['id']) ? trim($_POST['id']) : '';
        $surname = isset($_POST['surname']) ? trim($_POST['surname']) : '';
        $forename = isset($_POST['forename']) ? trim($_POST['forename']) : '';
        $dob = isset($_POST['dob']) ? trim($_POST['dob']) : '';
        $medals = isset($_POST['medals']) ? trim($_POST['medals']) : '';
        $date_of_death = isset($_POST['date_of_death']) ? trim($_POST['date_of_death']) : '';
        $rank = isset($_POST['rank']) ? trim($_POST['rank']) : '';
        $service_number = isset($_POST['service_number']) ? trim($_POST['service_number']) : '';
        $regiment = isset($_POST['regiment']) ? trim($_POST['regiment']) : '';
        $battalion = isset($_POST['battalion']) ? trim($_POST['battalion']) : '';
        $cemetery = isset($_POST['cemetery']) ? trim($_POST['cemetery']) : '';
        $grave_reference = isset($_POST['grave_reference']) ? trim($_POST['grave_reference']) : '';
        $info = isset($_POST['info']) ? trim($_POST['info']) : '';
        $original_service_number = isset($_POST['original_service_number']) ? trim($_POST['original_service_number']) : '';
        
        // Validate required fields
        if (empty($service_number) || empty($surname) || empty($forename)) {
            $error_message = 'Required fields (service_number, surname, forename) cannot be empty';
            $error_code = 1;
        } else if (empty($original_service_number)) {
            $error_message = 'Original service number is required for update operations';
            $error_code = 1;
        } else {
            // Create EditBurials object
            $burials = new EditBurials();
            $burials->setSurname($surname);
            $burials->setForename($forename);
            $burials->setDoB($dob);
            $burials->setMedals($medals);
            $burials->setDate_of_Death($date_of_death);
            $burials->setRank($rank);
            $burials->setService_Number($service_number);
            $burials->setRegiment($regiment);
            $burials->setBattalion($battalion);
            $burials->setCemetery($cemetery);
            $burials->setGrave_Reference($grave_reference);
            $burials->setInfo($info);
            
            // Set original service number for update identification
            $burials->setOriginal_Service_Number($original_service_number);
            
            // Connect to database through DAO
            $dao = new EditDAO();
            
            // Test connection
            $connection = $dao->testConnection();
            if (!$connection) {
                $error_message = 'Database connection failed';
                $error_code = 1;
            } else {
                // Save the record (update only)
                $result = $burials->save($dao);
                
                if ($result) {
                    // Redirect back to BurBrad.php with success
                    header('Location: BurBrad.php?success=1');
                    exit;
                } else {
                    $error_message = 'Failed to update burial record';
                    $error_code = 1;
                }
            }
        }
    } catch (Exception $e) {
        $error_message = 'An error occurred: ' . $e->getMessage();
        $error_code = 2;
    }
}

// Handle GET request or display form after POST with errors
// Get parameters for pre-filling the form
$service_number = isset($_GET['service_number']) ? trim($_GET['service_number']) : '';
$surname = isset($_GET['surname']) ? trim($_GET['surname']) : '';
$forename = isset($_GET['forename']) ? trim($_GET['forename']) : '';

// If service_number provided, fetch the record
$record = null;
if (!empty($service_number)) {
    $query = "SELECT * FROM Burials WHERE Service_Number = ?";
    $stmt = mysqli_prepare($connect, $query);
    mysqli_stmt_bind_param($stmt, "s", $service_number);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $record = mysqli_fetch_assoc($result);
    }
}

// Variables for form values - use either record data, GET params, or POST values (in case of error)
$form_surname = isset($record['Surname']) ? $record['Surname'] : (isset($_POST['surname']) ? $_POST['surname'] : $surname);
$form_forename = isset($record['Forename']) ? $record['Forename'] : (isset($_POST['forename']) ? $_POST['forename'] : $forename);
$form_service_number = isset($record['Service_Number']) ? $record['Service_Number'] : (isset($_POST['service_number']) ? $_POST['service_number'] : $service_number);
$form_dob = isset($record['DoB']) ? $record['DoB'] : (isset($_POST['dob']) ? $_POST['dob'] : '');
$form_medals = isset($record['Medals']) ? $record['Medals'] : (isset($_POST['medals']) ? $_POST['medals'] : '');
$form_date_of_death = isset($record['Date_of_Death']) ? $record['Date_of_Death'] : (isset($_POST['date_of_death']) ? $_POST['date_of_death'] : '');
$form_rank = isset($record['Rank']) ? $record['Rank'] : (isset($_POST['rank']) ? $_POST['rank'] : '');
$form_regiment = isset($record['Regiment']) ? $record['Regiment'] : (isset($_POST['regiment']) ? $_POST['regiment'] : '');
$form_battalion = isset($record['Battalion']) ? $record['Battalion'] : (isset($_POST['battalion']) ? $_POST['battalion'] : '');
$form_cemetery = isset($record['Cemetery']) ? $record['Cemetery'] : (isset($_POST['cemetery']) ? $_POST['cemetery'] : '');
$form_grave_reference = isset($record['Grave_Reference']) ? $record['Grave_Reference'] : (isset($_POST['grave_reference']) ? $_POST['grave_reference'] : '');
$form_info = isset($record['Info']) ? $record['Info'] : (isset($_POST['info']) ? $_POST['info'] : '');

// Original service number is needed for updating the correct record
$form_original_service_number = isset($_POST['original_service_number']) ? $_POST['original_service_number'] : $service_number;

// Determine if we're updating an existing record
$is_update = !empty($form_service_number);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Update Burial Record</title>
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
    .form-section input[type="text"],
    .form-section textarea {
      border: 1px solid #ccc;
      border-radius: 4px;
      padding: 8px 12px;
      background-color: #fff;
      font-size: 0.9rem;
    }
    .form-section textarea {
      resize: vertical;
      min-height: 80px;
    }
    .form-buttons {
      display: flex;
      gap: 10px;
      width: 100%;
      justify-content: flex-start;
      margin-top: 10px;
    }
    .form-buttons button {
      padding: 8px 16px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-weight: bold;
    }
    .form-buttons button[type="submit"] {
      background-color: #9b111e;
      color: white;
    }
    .form-buttons button[type="reset"] {
      background-color: #6c757d;
      color: white;
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
    .error-message {
      background-color: #f8d7da;
      color: #721c24;
      padding: 10px;
      border-radius: 4px;
      margin-bottom: 15px;
    }
  </style>
</head>
<body class="table-page">
<div class="container">
  <h1>Update Burial Record</h1>
  
  <?php if ($is_update): ?>
  <div style="background-color: #eaf7ea; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
    <p style="margin: 0; color: #28a745;"><strong>You are editing an existing record.</strong> Make your changes and click "Update Record" to save.</p>
  </div>
  <?php else: ?>
  <div style="background-color: #f8f9fa; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
    <p style="margin: 0; color: #6c757d;"><strong>You are creating a new record.</strong> Fill in the form and click "Create Record" to save.</p>
  </div>
  <?php endif; ?>
  
  <?php if (isset($error_code)): ?>
    <div class="error-message">
      <?php echo htmlspecialchars($error_message); ?>
    </div>
  <?php endif; ?>
  
  <form action="Update-Burials.php" method="POST" class="form-section">
    <!-- Hidden field for original service number -->
    <input type="hidden" id="original_service_number" name="original_service_number" value="<?php echo htmlspecialchars($form_original_service_number); ?>">
    
    <div class="input-group">
      <label for="surname">Surname</label>
      <input type="text" id="surname" name="surname" placeholder="Enter surname" value="<?php echo htmlspecialchars($form_surname); ?>" required>
    </div>
    
    <div class="input-group">
      <label for="forename">Forename</label>
      <input type="text" id="forename" name="forename" placeholder="Enter forename" value="<?php echo htmlspecialchars($form_forename); ?>" required>
    </div>
    
    <div class="input-group">
      <label for="service_number">Service Number</label>
      <input type="text" id="service_number" name="service_number" placeholder="Enter service number" value="<?php echo htmlspecialchars($form_service_number); ?>" required>
    </div>
    
    <div class="input-group">
      <label for="rank">Rank</label>
      <input type="text" id="rank" name="rank" placeholder="Enter rank" value="<?php echo htmlspecialchars($form_rank); ?>">
    </div>
    
    <div class="input-group">
      <label for="dob">Age</label>
      <input type="text" id="dob" name="dob" placeholder="Enter age" value="<?php echo htmlspecialchars($form_dob); ?>">
    </div>
    
    <div class="input-group">
      <label for="date_of_death">Date of Death</label>
      <input type="text" id="date_of_death" name="date_of_death" placeholder="Enter date of death" value="<?php echo htmlspecialchars($form_date_of_death); ?>">
    </div>
    
    <div class="input-group">
      <label for="regiment">Regiment</label>
      <input type="text" id="regiment" name="regiment" placeholder="Enter regiment" value="<?php echo htmlspecialchars($form_regiment); ?>">
    </div>
    
    <div class="input-group">
      <label for="battalion">Unit/Battalion</label>
      <input type="text" id="battalion" name="battalion" placeholder="Enter unit/battalion" value="<?php echo htmlspecialchars($form_battalion); ?>">
    </div>
    
    <div class="input-group">
      <label for="medals">Medals</label>
      <input type="text" id="medals" name="medals" placeholder="Enter medals" value="<?php echo htmlspecialchars($form_medals); ?>">
    </div>
    
    <div class="input-group">
      <label for="cemetery">Cemetery</label>
      <input type="text" id="cemetery" name="cemetery" placeholder="Enter cemetery" value="<?php echo htmlspecialchars($form_cemetery); ?>">
    </div>
    
    <div class="input-group">
      <label for="grave_reference">Grave Reference</label>
      <input type="text" id="grave_reference" name="grave_reference" placeholder="Enter grave reference" value="<?php echo htmlspecialchars($form_grave_reference); ?>">
    </div>
    
    <div class="input-group" style="flex: 100%;">
      <label for="info">Additional Information</label>
      <textarea id="info" name="info" placeholder="Enter additional information" rows="4"><?php echo htmlspecialchars($form_info); ?></textarea>
    </div>
    
    <div class="form-buttons">
      <button type="submit"><?php echo $is_update ? 'Update Record' : 'Create Record'; ?></button>
      <button type="reset">Clear Fields</button>
      <a href="BurBrad.php" style="padding: 8px 16px; background-color: #6c757d; color: white; text-decoration: none; border-radius: 4px; font-weight: bold;">Cancel</a>
    </div>
  </form>
  
  <?php if ($is_update): ?>
  <div class="table-container">
    <div class="table-wrapper">
      <table>
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
          <tr>
            <td><?php echo htmlspecialchars($form_surname); ?></td>
            <td><?php echo htmlspecialchars($form_forename); ?></td>
            <td><?php echo htmlspecialchars($form_dob); ?></td>
            <td><?php echo htmlspecialchars($form_medals); ?></td>
            <td><?php echo htmlspecialchars($form_date_of_death); ?></td>
            <td><?php echo htmlspecialchars($form_rank); ?></td>
            <td><?php echo htmlspecialchars($form_service_number); ?></td>
            <td><?php echo htmlspecialchars($form_regiment); ?></td>
            <td><?php echo htmlspecialchars($form_battalion); ?></td>
            <td><?php echo htmlspecialchars($form_cemetery); ?></td>
            <td><?php echo htmlspecialchars($form_grave_reference); ?></td>
            <td><?php echo htmlspecialchars($form_info); ?></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <?php endif; ?>
  
  <div class="bottom-section" style="margin-top:20px;">
    <a class="back-button" href="BurBrad.php">Back</a>
  </div>
</div>

<script>
  // Reset confirmation
  document.querySelector('button[type="reset"]').addEventListener('click', function(e) {
    if (!confirm('Are you sure you want to clear all fields?')) {
      e.preventDefault();
    }
  });
  
  // Form submission confirmation
  document.querySelector('form').addEventListener('submit', function(e) {
    const message = <?php echo $is_update ? "'Are you sure you want to update this record?'" : "'Are you sure you want to create this record?'"; ?>;
    if (!confirm(message)) {
      e.preventDefault();
    }
  });
</script>
</body>
</html> 