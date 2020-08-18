<?php

//require database connection file
require_once('config.php');
session_start();
//SQL statement that returns all of the user's collections and the data they include 

$userID = $_SESSION['id'];
$itemToDelete = $_POST['itemName'];
$collectionName = $_POST['collectionName'];

$sql = "SELECT collectionID 
        FROM collections 
        WHERE collectionName = ?";

$statement = $db->prepare($sql);
$result = $statement->execute([$collectionName]);

if($result){
        $collectionID = $statement->fetchColumn();
        
        //SQL query to delete row from user collections table
        $sql = "SELECT ID 
                FROM usercollections 
                WHERE collectionID = ? AND userID = ?";

        $statement = $db->prepare($sql);
        $result = $statement->execute([$collectionID, $userID]);  
        
        if($result){
            $userCollectionID = $statement->fetchColumn();

            $sql = "DELETE FROM items 
                    WHERE userCollectionID = ? AND name = ?";

            $statement = $db->prepare($sql);
            $result = $statement->execute([$userCollectionID, $itemToDelete]);        
        }
};
?>