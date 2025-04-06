<?php
// Update-gwroh.php - Process gwroh record updates
require_once 'EditDAO.php';
require_once 'EditGwroh.php';
require_once 'DBconnect.php';

// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Handle POST request - process the update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Log file access for debugging
    error_log("Update-gwroh.php POST accessed at " . date('Y-m-d H:i:s'));
    error_log("POST data: " . json_encode($_POST));
    
    // Process form data
    try {
        // Get data from POST
        $id = isset($_POST['id']) ? trim($_POST['id']) : '';
        $surname = isset($_POST['surname']) ? trim($_POST['surname']) : '';
        $forename = isset($_POST['forename']) ? trim($_POST['forename']) : '';
        $address = isset($_POST['address']) ? trim($_POST['address']) : '';
        $electoral_ward = isset($_POST['electoral_ward']) ? trim($_POST['electoral_ward']) : '';
        $town = isset($_POST['town']) ? trim($_POST['town']) : '';
        $rank = isset($_POST['rank']) ? trim($_POST['rank']) : '';
        $regiment = isset($_POST['regiment']) ? trim($_POST['regiment']) : '';
        $battalion = isset($_POST['battalion']) ? trim($_POST['battalion']) : '';
        $company = isset($_POST['company']) ? trim($_POST['company']) : '';
        $dob = isset($_POST['dob']) ? trim($_POST['dob']) : '';
        $service_no = isset($_POST['service_no']) ? trim($_POST['service_no']) : '';
        $other_regiment = isset($_POST['other_regiment']) ? trim($_POST['other_regiment']) : '';
        $other_unit = isset($_POST['other_unit']) ? trim($_POST['other_unit']) : '';
        $other_service_no = isset($_POST['other_service_no']) ? trim($_POST['other_service_no']) : '';
        $medals = isset($_POST['medals']) ? trim($_POST['medals']) : '';
        $enlistment_date = isset($_POST['enlistment_date']) ? trim($_POST['enlistment_date']) : '';
        $discharge_date = isset($_POST['discharge_date']) ? trim($_POST['discharge_date']) : '';
        $date = isset($_POST['date']) ? trim($_POST['date']) : '';
        $misc_info_nroh = isset($_POST['misc_info_nroh']) ? trim($_POST['misc_info_nroh']) : '';
        $misc_info_cwgc = isset($_POST['misc_info_cwgc']) ? trim($_POST['misc_info_cwgc']) : '';
        $cemetery_memorial = isset($_POST['cemetery_memorial']) ? trim($_POST['cemetery_memorial']) : '';
        $cemetery_memorial_ref = isset($_POST['cemetery_memorial_ref']) ? trim($_POST['cemetery_memorial_ref']) : '';
        $cemetery_memorial_country = isset($_POST['cemetery_memorial_country']) ? trim($_POST['cemetery_memorial_country']) : '';
        $original_service_no = isset($_POST['original_service_no']) ? trim($_POST['original_service_no']) : '';
        
        // Validate required fields
        if (empty($service_no) || empty($surname) || empty($forename)) {
            $error_message = 'Required fields (service_no, surname, forename) cannot be empty';
            $error_code = 1;
        } else if (empty($original_service_no)) {
            $error_message = 'Original service number is required for update operations';
            $error_code = 1;
        } else {
            // Create EditGwroh object
            $gwroh = new EditGwroh();
            $gwroh->setSurname($surname);
            $gwroh->setForename($forename);
            $gwroh->setAddress($address);
            $gwroh->setElectoral_Ward($electoral_ward);
            $gwroh->setTown($town);
            $gwroh->setRank($rank);
            $gwroh->setRegiment($regiment);
            $gwroh->setBattalion($battalion);
            $gwroh->setCompany($company);
            $gwroh->setDoB($dob);
            $gwroh->setService_no($service_no);
            $gwroh->setOther_Regiment($other_regiment);
            $gwroh->setOther_Unit($other_unit);
            $gwroh->setOther_Service_no($other_service_no);
            $gwroh->setMedals($medals);
            $gwroh->setEnlistment_Date($enlistment_date);
            $gwroh->setDischarge_Date($discharge_date);
            $gwroh->setDate($date);
            $gwroh->setMisc_info_Nroh($misc_info_nroh);
            $gwroh->setMisc_info_cwgc($misc_info_cwgc);
            $gwroh->setCemetery_Memorial($cemetery_memorial);
            $gwroh->setCemetery_Memorial_Ref($cemetery_memorial_ref);
            $gwroh->setCemetery_Memorial_Country($cemetery_memorial_country);
            
            // Set original service number for update identification
            $gwroh->setOriginal_Service_no($original_service_no);
            
            // Debug: Output all data being saved
            error_log("About to save gwroh record with original_service_no: " . $original_service_no);
            error_log("All gwroh data: " . json_encode($gwroh->debugOutput()));
            
            // Connect to database through DAO
            $dao = new EditDAO();
            
            // Test connection
            $connection = $dao->testConnection();
            if (!$connection) {
                $error_message = 'Database connection failed';
                $error_code = 1;
            } else {
                // Save the record (update only)
                error_log("Connection successful, calling gwroh->save()...");
                $result = $gwroh->save($dao);
                error_log("Save result: " . ($result ? "success" : "failure"));
                
                if ($result) {
                    // Redirect back to gwroh.php with success
                    header('Location: gwroh.php?success=1');
                    exit;
                } else {
                    $error_message = 'Failed to update gwroh record. Check apache error logs for details.';
                    $error_code = 1;
                    // Display detailed error information for debugging
                    error_log("Failed to update record. Current data state: " . json_encode($gwroh->debugOutput()));
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
$service_no = isset($_GET['service_no']) ? trim($_GET['service_no']) : '';
$surname = isset($_GET['surname']) ? trim($_GET['surname']) : '';
$forename = isset($_GET['forename']) ? trim($_GET['forename']) : '';

// If service_no provided, fetch the record
$record = null;
if (!empty($service_no)) {
    $query = "SELECT * FROM gwroh WHERE `Service no` = ?";
    $stmt = mysqli_prepare($connect, $query);
    mysqli_stmt_bind_param($stmt, "s", $service_no);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $record = mysqli_fetch_assoc($result);
    }
}

// Variables for form values - use either record data, GET params, or POST values (in case of error)
$form_surname = isset($record['Surname']) ? $record['Surname'] : (isset($_POST['surname']) ? $_POST['surname'] : $surname);
$form_forename = isset($record['Forename']) ? $record['Forename'] : (isset($_POST['forename']) ? $_POST['forename'] : $forename);
$form_address = isset($record['Address']) ? $record['Address'] : (isset($_POST['address']) ? $_POST['address'] : '');
$form_electoral_ward = isset($record['Electoral Ward']) ? $record['Electoral Ward'] : (isset($_POST['electoral_ward']) ? $_POST['electoral_ward'] : '');
$form_town = isset($record['Town']) ? $record['Town'] : (isset($_POST['town']) ? $_POST['town'] : '');
$form_rank = isset($record['Rank']) ? $record['Rank'] : (isset($_POST['rank']) ? $_POST['rank'] : '');
$form_regiment = isset($record['Regiment']) ? $record['Regiment'] : (isset($_POST['regiment']) ? $_POST['regiment'] : '');
$form_battalion = isset($record['Battalion']) ? $record['Battalion'] : (isset($_POST['battalion']) ? $_POST['battalion'] : '');
$form_company = isset($record['Company']) ? $record['Company'] : (isset($_POST['company']) ? $_POST['company'] : '');
$form_dob = isset($record['DoB']) ? $record['DoB'] : (isset($_POST['dob']) ? $_POST['dob'] : '');
$form_service_no = isset($record['Service no']) ? $record['Service no'] : (isset($_POST['service_no']) ? $_POST['service_no'] : $service_no);
$form_other_regiment = isset($record['Other Regiment']) ? $record['Other Regiment'] : (isset($_POST['other_regiment']) ? $_POST['other_regiment'] : '');
$form_other_unit = isset($record['Other Unit']) ? $record['Other Unit'] : (isset($_POST['other_unit']) ? $_POST['other_unit'] : '');
$form_other_service_no = isset($record['Other Service no']) ? $record['Other Service no'] : (isset($_POST['other_service_no']) ? $_POST['other_service_no'] : '');
$form_medals = isset($record['Medals']) ? $record['Medals'] : (isset($_POST['medals']) ? $_POST['medals'] : '');
$form_enlistment_date = isset($record['Enlistment Date']) ? $record['Enlistment Date'] : (isset($_POST['enlistment_date']) ? $_POST['enlistment_date'] : '');
$form_discharge_date = isset($record['Discharge Date']) ? $record['Discharge Date'] : (isset($_POST['discharge_date']) ? $_POST['discharge_date'] : '');
$form_date = isset($record['Death (in service) date']) ? $record['Death (in service) date'] : (isset($_POST['date']) ? $_POST['date'] : '');
$form_misc_info_nroh = isset($record['Misc info (Nroh)']) ? $record['Misc info (Nroh)'] : (isset($_POST['misc_info_nroh']) ? $_POST['misc_info_nroh'] : '');
$form_misc_info_cwgc = isset($record['Misc info (cwgc)']) ? $record['Misc info (cwgc)'] : (isset($_POST['misc_info_cwgc']) ? $_POST['misc_info_cwgc'] : '');
$form_cemetery_memorial = isset($record['Cemetery/Memorial']) ? $record['Cemetery/Memorial'] : (isset($_POST['cemetery_memorial']) ? $_POST['cemetery_memorial'] : '');
$form_cemetery_memorial_ref = isset($record['Cemetery/Memorial Ref']) ? $record['Cemetery/Memorial Ref'] : (isset($_POST['cemetery_memorial_ref']) ? $_POST['cemetery_memorial_ref'] : '');
$form_cemetery_memorial_country = isset($record['Cemetery/Memorial Country']) ? $record['Cemetery/Memorial Country'] : (isset($_POST['cemetery_memorial_country']) ? $_POST['cemetery_memorial_country'] : '');

// Original service number is needed for updating the correct record
$form_original_service_no = isset($_POST['original_service_no']) ? $_POST['original_service_no'] : $service_no;

// Determine if we're updating an existing record
$is_update = !empty($form_service_no);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Update Bradford and Townships Record</title>
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
  <h1>Update Bradford and Townships Record</h1>
  
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
  
  <form action="Update-gwroh.php" method="POST" class="form-section">
    <!-- Hidden field for original service number -->
    <input type="hidden" id="original_service_no" name="original_service_no" value="<?php echo htmlspecialchars($form_original_service_no); ?>">
    
    <div class="input-group">
      <label for="surname">Surname</label>
      <input type="text" id="surname" name="surname" placeholder="Enter surname" value="<?php echo htmlspecialchars($form_surname); ?>" required>
    </div>
    
    <div class="input-group">
      <label for="forename">Forename</label>
      <input type="text" id="forename" name="forename" placeholder="Enter forename" value="<?php echo htmlspecialchars($form_forename); ?>" required>
    </div>
    
    <div class="input-group">
      <label for="service_no">Service Number</label>
      <input type="text" id="service_no" name="service_no" placeholder="Enter service number" value="<?php echo htmlspecialchars($form_service_no); ?>" required>
    </div>
    
    <div class="input-group">
      <label for="address">Address</label>
      <input type="text" id="address" name="address" placeholder="Enter address" value="<?php echo htmlspecialchars($form_address); ?>">
    </div>
    
    <div class="input-group">
      <label for="electoral_ward">Electoral Ward</label>
      <input type="text" id="electoral_ward" name="electoral_ward" placeholder="Enter electoral ward" value="<?php echo htmlspecialchars($form_electoral_ward); ?>">
    </div>
    
    <div class="input-group">
      <label for="town">Town</label>
      <input type="text" id="town" name="town" placeholder="Enter town" value="<?php echo htmlspecialchars($form_town); ?>">
    </div>
    
    <div class="input-group">
      <label for="rank">Rank</label>
      <input type="text" id="rank" name="rank" placeholder="Enter rank" value="<?php echo htmlspecialchars($form_rank); ?>">
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
      <label for="company">Company</label>
      <input type="text" id="company" name="company" placeholder="Enter company" value="<?php echo htmlspecialchars($form_company); ?>">
    </div>
    
    <div class="input-group">
      <label for="dob">Age</label>
      <input type="text" id="dob" name="dob" placeholder="Enter age" value="<?php echo htmlspecialchars($form_dob); ?>">
    </div>
    
    <div class="input-group">
      <label for="other_regiment">Other Regiment</label>
      <input type="text" id="other_regiment" name="other_regiment" placeholder="Enter other regiment" value="<?php echo htmlspecialchars($form_other_regiment); ?>">
    </div>
    
    <div class="input-group">
      <label for="other_unit">Other Unit</label>
      <input type="text" id="other_unit" name="other_unit" placeholder="Enter other unit" value="<?php echo htmlspecialchars($form_other_unit); ?>">
    </div>
    
    <div class="input-group">
      <label for="other_service_no">Other Service No.</label>
      <input type="text" id="other_service_no" name="other_service_no" placeholder="Enter other service number" value="<?php echo htmlspecialchars($form_other_service_no); ?>">
    </div>
    
    <div class="input-group">
      <label for="medals">Medals</label>
      <input type="text" id="medals" name="medals" placeholder="Enter medals" value="<?php echo htmlspecialchars($form_medals); ?>">
    </div>
    
    <div class="input-group">
      <label for="enlistment_date">Enlistment Date</label>
      <input type="text" id="enlistment_date" name="enlistment_date" placeholder="Enter enlistment date" value="<?php echo htmlspecialchars($form_enlistment_date); ?>">
    </div>
    
    <div class="input-group">
      <label for="discharge_date">Discharge Date</label>
      <input type="text" id="discharge_date" name="discharge_date" placeholder="Enter discharge date" value="<?php echo htmlspecialchars($form_discharge_date); ?>">
    </div>
    
    <div class="input-group">
      <label for="date">Death (in service) Date</label>
      <input type="text" id="date" name="date" placeholder="Enter death date" value="<?php echo htmlspecialchars($form_date); ?>">
    </div>
    
    <div class="input-group">
      <label for="cemetery_memorial">Cemetery/Memorial</label>
      <input type="text" id="cemetery_memorial" name="cemetery_memorial" placeholder="Enter cemetery/memorial" value="<?php echo htmlspecialchars($form_cemetery_memorial); ?>">
    </div>
    
    <div class="input-group">
      <label for="cemetery_memorial_ref">Cemetery/Memorial Ref</label>
      <input type="text" id="cemetery_memorial_ref" name="cemetery_memorial_ref" placeholder="Enter cemetery/memorial reference" value="<?php echo htmlspecialchars($form_cemetery_memorial_ref); ?>">
    </div>
    
    <div class="input-group">
      <label for="cemetery_memorial_country">Cemetery/Memorial Country</label>
      <input type="text" id="cemetery_memorial_country" name="cemetery_memorial_country" placeholder="Enter cemetery/memorial country" value="<?php echo htmlspecialchars($form_cemetery_memorial_country); ?>">
    </div>
    
    <div class="input-group" style="flex: 1 1 100%;">
      <label for="misc_info_nroh">Misc Info (Nroh)</label>
      <textarea id="misc_info_nroh" name="misc_info_nroh" placeholder="Enter miscellaneous information" rows="3"><?php echo htmlspecialchars($form_misc_info_nroh); ?></textarea>
    </div>
    
    <div class="input-group" style="flex: 1 1 100%;">
      <label for="misc_info_cwgc">Additional CWGC Info</label>
      <textarea id="misc_info_cwgc" name="misc_info_cwgc" placeholder="Enter CWGC information" rows="3"><?php echo htmlspecialchars($form_misc_info_cwgc); ?></textarea>
    </div>
    
    <div class="form-buttons">
      <button type="submit"><?php echo $is_update ? 'Update Record' : 'Create Record'; ?></button>
      <button type="reset">Clear Fields</button>
      <a href="gwroh.php" style="padding: 8px 16px; background-color: #6c757d; color: white; text-decoration: none; border-radius: 4px; font-weight: bold;">Cancel</a>
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
            <th>Address</th>
            <th>Service No.</th>
            <th>Regiment</th>
            <th>Battalion</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><?php echo htmlspecialchars($form_surname); ?></td>
            <td><?php echo htmlspecialchars($form_forename); ?></td>
            <td><?php echo htmlspecialchars($form_address); ?></td>
            <td><?php echo htmlspecialchars($form_service_no); ?></td>
            <td><?php echo htmlspecialchars($form_regiment); ?></td>
            <td><?php echo htmlspecialchars($form_battalion); ?></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <?php endif; ?>
  
  <div class="bottom-section" style="margin-top:20px;">
    <a class="back-button" href="gwroh.php">Back</a>
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