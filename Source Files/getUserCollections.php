<?php
//require database connection file
require_once('config.php');
session_start();

$userID = '46';

//SQL statement that returns all of the user's collections and the data they include 

$sql = "SELECT collectionID 
        FROM userCollections
        WHERE userID = ? ";

$statement = $db->prepare($sql);
$result = $statement->execute([$userID]);

if ($result->num_rows > 0){

}else{
    echo "No collections found for you. Please create a collection to get started.";
}


?>