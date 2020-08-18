<?php
session_start();
require_once('config.php');

//Values from login form
$userID = $_SESSION['id'];
$currentPassword = sha1($_POST['currentPassword']);
$newPassword = sha1($_POST['newPassword']);

//SQL query to get user information
$sql = "SELECT password FROM users WHERE ID = ? LIMIT 1";
$statement = $db->prepare($sql);
$result = $statement->execute([$userID]);

if ($result){
    $encryptedPassword = $statement->fetchColumn();
    //Checks that user is found successfully
    if($currentPassword === $encryptedPassword){
        $sql = "UPDATE users 
                SET password = ?
                WHERE ID = ?";
        $statement = $db->prepare($sql);
        $result = $statement->execute([$newPassword, $userID]);

        if($result){
            echo "3";
        }else{
            echo "1";
        }
    }else{
        echo "2";
    }
}else{
    echo "1";
}

/*Error codes
1 - Database connection or SQL error
2 - Current password was incorrect 
3 - Changed successfully
?>