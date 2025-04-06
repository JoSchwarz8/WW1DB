<?php
require_once 'DBconnect.php';

$surnameMemorials = $_POST['surnameMemorials'];
$forenameMemorials = $_POST['forenameMemorials'];
$regimentMemorials = $_POST['regimentMemorials'];
$unitMemorials = $_POST['unitMemorials'];
$memorialMemorials = $_POST['memorialMemorials'];
$memorialLocationMemorials = $_POST['memorialLocationMemorials'];
$memorialInfoMemorials = $_POST['memorialInfoMemorials'];
$memorialPostcodeMemorials = $_POST['memorialPostcodeMemorials'];
$districtMemorials = $_POST['districtMemorials'];
$photoAvailableMemorials = $_POST['photoAvailableMemorials'];

// Prepare the SQL statement
$query = $connect->prepare("INSERT INTO Memorials (Surname, Forename, Regiment, Unit, Memorial, Memorial_location, Memorial_info, Postcode, District) VALUES (?, ?, ?, ?, ?,?,?,?,?)");

// Bind the parameters
$query->bind_param("sssssssss", $surnameMemorials, $forenameMemorials, $regimentMemorials, $unitMemorials, $memorialMemorials, $memorialLocationMemorials, $memorialInfoMemorials, $memorialPostcodeMemorials, $districtMemorials);

// Execute the statement
if ($query->execute()) {
    echo "Record added successfully";
} else {
    echo "Error: " . $query->error;
}

// Close the statement and connection
$query->close();
$connect->close();
?>
