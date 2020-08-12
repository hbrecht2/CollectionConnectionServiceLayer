<?php
//Start session in order to access session variables 
session_start();


//require database connection file
require_once('config.php');


if(isset($_POST)){
    $collectionName = $_POST['collectionName'];
    $userID = $_SESSION['id'];

    //SQL statement to insert user data into users table
    $sql = "INSERT INTO collections (collectionName)
            VALUES (?)";
 
    $statement = $db->prepare($sql);
    $result = $statement->execute([$collectionName]);
    $collectionID = $db->lastInsertId();

    //Show success or errors of inserting into database
    if ($result){
        $sql = "INSERT INTO userCollections (userID, collectionID)
            VALUES (?, ?)";
 
        $statement = $db->prepare($sql);
        $result = $statement->execute([$userID, $collectionID]);
        
    }else{
        echo 'There was an error while saving data.';
    };
}else{
    echo 'No data';
}

?>