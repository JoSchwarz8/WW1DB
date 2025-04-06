<?php
require_once 'DBconnect.php';

// Collect POST data
$surname = $_POST['surnamegwroh'];
$forename = $_POST['forenamegwroh'];
$address = $_POST['addressgwroh'];
$electoralWard = $_POST['electoralWardgwroh'];
$town = $_POST['towngwroh'];
$rank = $_POST['rankgwroh'];
$regiment = $_POST['regimentgwroh'];
$unit = $_POST['unitgwroh'];
$company = $_POST['companygwroh'];
$age = $_POST['agegwroh'];
$serviceNo = $_POST['serviceNogwroh'];
$otherRegiment = $_POST['otherRegimentgwroh'];
$otherUnit = $_POST['otherUnitgwroh'];
$otherServiceNo = $_POST['otherServiceNogwroh'];
$medals = $_POST['medalsgwroh'];
$enlistmentDate = $_POST['enlistmentDategwroh'];
$dischargeDate = $_POST['dischargeDategwroh'];
$deathDate = $_POST['deathDategwroh'];
$miscInfo = $_POST['miscInfogwroh'];
$cemeteryMemorial = $_POST['cemeteryMemorialgwroh'];
$cemeteryMemorialRef = $_POST['cemeteryMemorialRefgwroh'];
$cemeteryMemorialCountry = $_POST['cemeteryMemorialCountrygwroh'];
$additionalCWGC = $_POST['additionalCWGCgwroh'];

// Prepare the SQL insert
$query = $connect->prepare("INSERT INTO GWROH (
    Surname, Forename, Address, Electoral_Ward, Town, Rank, Regiment, Unit, Company, Age,
    Service_no, Other_Regiment, Other_Unit, Other_Service_no, Medals, Enlistment_Date, Discharge_Date, Death_Date,
    Misc_Info, Cemetery_Memorial, Cemetery_Memorial_Ref, Cemetery_Memorial_Country, Additional_CWGC
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

// Bind all 23 parameters
$query->bind_param(
    "sssssssssssssssssssssss",
    $surname, $forename, $address, $electoralWard, $town, $rank, $regiment, $unit, $company, $age,
    $serviceNo, $otherRegiment, $otherUnit, $otherServiceNo, $medals, $enlistmentDate, $dischargeDate, $deathDate,
    $miscInfo, $cemeteryMemorial, $cemeteryMemorialRef, $cemeteryMemorialCountry, $additionalCWGC
);

// Execute and check for success
if ($query->execute()) {
    echo "Record added successfully";
} else {
    echo "Error: " . $query->error;
}

// Close everything
$query->close();
$connect->close();
?>
