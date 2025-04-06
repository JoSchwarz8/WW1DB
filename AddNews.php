<?php
require_once 'DBconnect.php';

// Collect form data
$surname = $_POST['surnameNews'];
$forename = $_POST['forenameNews'];
$rank = $_POST['rankNews'];
$address = $_POST['addressNews'];
$regiment = $_POST['regimentNews'];
$unit = $_POST['unitNews'];
$articleComment = $_POST['articleCommentNews'];
$newspaperName = $_POST['newspaperName'];
$newspaperDate = $_POST['newspaperDate'];
$pageCol = $_POST['pageCol'];
$photoIncl = $_POST['photoInclNews'];

// Prepare the insert query
$query = $connect->prepare("INSERT INTO Newspaper_references 
(Surname, Forename, Rank, Address, Regiment, Unit, Article Comment, Newspaper Name, Newspaper Date, PageCol, PhotoIncl) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

// Bind values (all strings)
$query->bind_param("sssssssssss", $surname, $forename, $rank, $address, $regiment, $unit, $articleComment, $newspaperName, $newspaperDate, $pageCol, $photoIncl);

// Execute and handle response
if ($query->execute()) {
    echo "Record added successfully";
} else {
    echo "Error: " . $query->error;
}

$query->close();
$connect->close();
?>
