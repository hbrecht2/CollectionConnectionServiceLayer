<?php
//Start session in order to access session variables 
session_start();


//require database connection file
require_once('config.php');


if(isset($_POST)){
    $collectionName = $_POST['collectionName'];
    $userID = $_SESSION['id'];

    //SQL statement to check if name already exists in the database 
    $sql = "SELECT collectionID
            FROM collections 
            WHERE collectionName = ?";
    $statement = $db->prepare($sql);
    $result = $statement->execute([$collectionName]);

    if($statement->rowCount()>0){
        //Get collection ID from SQL query 
        $collectionID = $statement->fetchColumn();
        //Use collectionID and userID to insert into usercollections table 

        $sql = "INSERT INTO userCollections (userID, collectionID)
            VALUES (?, ?)";
 
        $statement = $db->prepare($sql);
        $result = $statement->execute([$userID, $collectionID]);
        
    }else{
        //Insert collection name into collections 
        $sql = "INSERT INTO collections (collectionName)
            VALUES (?)";
 
        $statement = $db->prepare($sql);
        $result = $statement->execute([$collectionName]);
        $collectionID = $db->lastInsertId();
        
        if($result){
            $sql = "INSERT INTO userCollections (userID, collectionID)
            VALUES (?, ?)";
 
            $statement = $db->prepare($sql);
            $result = $statement->execute([$userID, $collectionID]);
        };
    };
};
    

?>