<?php
session_start();
require_once('config.php');

//UserID of user to be deleted
$userID = $_SESSION['id'];


//SQL query to get user information
$sql = "SELECT ID from userCollections WHERE userID = ?";
$statement = $db->prepare($sql);
$result = $statement->execute([$userID]);

if ($result){
    $userCollectionID = $statement->fetchColumn();

    $sql = "DELETE FROM users
            WHERE ID = ?;
                
            DELETE FROM userCollections 
            WHERE ID = ?;
                
            DELETE FROM items 
            WHERE userCollectionID = ?";

    $statement = $db->prepare($sql);
    $result = $statement->execute([$userID, $userCollectionID, $userCollectionID]);    

    if($result){
        session_destroy();
        unset($_SESSION);
        header("Location: index.php");
    }else{
        echo "There was an error deleting your account.";
    }

}else{
    echo "Could not connect to database";
}

?>