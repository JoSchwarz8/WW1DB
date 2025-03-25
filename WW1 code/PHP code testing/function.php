<?php
require_once 'DBconnect.php';
function display_Bios(){
    global $connect;
    $query = "SELECT * FROM Biography_Information"; //change 2: users to BI to see if it works woth the specific example. 
    $result = mysqli_query($connect, $query);
    return $result;
}
function display_gwroh(){
    global $connect;
    $query = "SELECT * FROM gwroh"; // Selecting Data from gwroh table 
    $result = mysqli_query($connect, $query);
    return $result;
}
function display_NewsRefs(){
    global $connect;
    $query = "SELECT * FROM Newspaper_ref"; // Selecting Data from NewsRefs table 
    $result = mysqli_query($connect, $query);
    return $result;
}

function display_Burials(){
    global $connect;
    $query = "SELECT * FROM Burials"; //Selecting Data from Burials table
    $result = mysqli_query($connect, $query);
    return $result;
}

function display_Memorials(){
    global $connect;
    $query = "SELECT * FROM Memorials";  //Selecting Data from Memorials table
    $result = mysqli_query($connect, $query);
    return $result;
}

?>