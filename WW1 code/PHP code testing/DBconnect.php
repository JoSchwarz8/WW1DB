<?php
$connect = mysqli_connect("localhost", "root", "root", "WW1_Soldiers"); //change 3: make sure the username and password match 
if(!$connect){
    die("DB not connected");
}
?>
