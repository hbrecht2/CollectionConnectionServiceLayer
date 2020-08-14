<?php

//require database connection file
require_once('config.php');
session_start();
//SQL statement that returns all of the user's collections and the data they include 

$userID = $_SESSION['id'];
$collectionToDelete = $_POST['collectionToDelete'];

$sql = "SELECT collectionID 
        FROM collections 
        WHERE collectionName = ?";

$statement = $db->prepare($sql);
$result = $statement->execute([$collectionToDelete]);

if($result){
        $collectionID = $statement->fetchColumn();
        
        //SQL query to delete row from user collections table
        $sql = "DELETE FROM usercollections
                WHERE userID = ? AND collectionID = ?";

        $statement = $db->prepare($sql);
        $result = $statement->execute([$userID, $collectionID]);        
};
?>