<?php

//require database connection file
require_once('config.php');
session_start();


$userID = $_SESSION['id'];
$collectionToDelete = $_POST['collectionToDelete'];

//SQL statement that returns userCOllectionID 
$sql = "SELECT uc.ID
        FROM usercollections as uc 
        JOIN collections as c
        ON uc.collectionID = c.collectionID
        WHERE c.collectionName = ?";

$statement = $db->prepare($sql);
$result = $statement->execute([$collectionToDelete]);

if($result){
        $userCollectionID = $statement->fetchColumn();

        //SQL query to delete row from user collections table
        $sql = "DELETE FROM usercollections
                WHERE ID = ?;
                
                DELETE FROM items 
                WHERE userCollectionID = ?";

        $statement = $db->prepare($sql);
        $result = $statement->execute([$userCollectionID, $userCollectionID]);    
};
?>