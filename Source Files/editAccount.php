<?php

//require database connection file
require_once('config.php');
session_start();
//SQL statement that returns all of the user's collections and the data they include 

$userID = $_SESSION['id'];
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$email = $_POST['email'];

$sql = "UPDATE users 
        SET fname = ?, lName = ?, email = ?
        WHERE ID = ?";

$statement = $db->prepare($sql);
$result = $statement->execute([$firstName, $lastName, $email, $userID]);

if($result){
    echo "yes";
}else{
    echo "error";
}
?>