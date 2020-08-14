<?php
//require database connection file
require_once('config.php');
session_start();
//SQL statement that returns all of the user's collections and the data they include 

$userID = $_SESSION['id'];

$sql = "SELECT c.collectionName
        FROM collections AS c 
        INNER JOIN usercollections AS uc
        ON c.collectionID = uc.collectionID
        INNER JOIN users AS u 
        ON uc.userID = u.ID
        WHERE u.ID = ? ";

$statement = $db->prepare($sql);
$result = $statement->execute([$userID]);

if ($statement->rowCount() > 0){
    $userCollections = $statement->fetchAll();
    $json = json_encode($userCollections);
    echo $json;
}else{
    $userCollections = [];
    $json = json_encode($userCollections);
    echo $json;
}


?>