<?php
require_once 'DBconnect.php';

// Collect form data
$surname = $_POST['surnameBurials'];
$forename = $_POST['forenameBurials'];
$age = $_POST['ageBurials'];
$medals = $_POST['medalsBurials'];
$dateOfDeath = $_POST['dateOfDeath'];
$rank = $_POST['rankBurials'];
$serviceNumber = $_POST['serviceNumber'];
$regiment = $_POST['regimentBurials'];
$unit = $_POST['unitBurials'];
$cemetery = $_POST['cemeteryBurials'];
$graveReference = $_POST['graveReferenceBurials'];
$info = $_POST['infoBurials'];

// Prepare SQL insert
$query = $connect->prepare("INSERT INTO Burials 
(Surname, Forename, Age, Medals, Date_of_Death, Rank, Service_Number, Regiment, Unit, Cemetery, Grave_Reference, Info) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

// Bind parameters
$query->bind_param("ssssssssssss", $surname, $forename, $age, $medals, $dateOfDeath, $rank, $serviceNumber, $regiment, $unit, $cemetery, $graveReference, $info);

// Execute query
if ($query->execute()) {
    echo "Record added successfully";
} else {
    echo "Error: " . $query->error;
}

// Clean up
$query->close();
$connect->close();
?>
