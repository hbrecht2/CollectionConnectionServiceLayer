<?php
//require database connection file
require_once('config.php');
session_start();
//SQL statement that returns all of the user's collections and the data they include 

$userID = $_SESSION['id'];
$collectionID = $_GET['collectionID'];

$sql = "SELECT i.name, i.imagePath, i.year, i.description
        FROM items AS i
        INNER JOIN usercollections AS uc
        ON i.userCollectionID = uc.ID
        WHERE uc.userID = ? AND uc.collectionID = ?";

$statement = $db->prepare($sql);
$result = $statement->execute([$userID, $collectionID]);

if ($statement->rowCount() > 0){
    $collectionItems = $statement->fetchAll();
    $json = json_encode($collectionItems);
    echo $json;
}else{
    $collectionItems = [];
    $json = json_encode($collectionItems);
    echo $json;
}


?>