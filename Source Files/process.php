<?php
//require database connection file
require_once('config.php');

if(isset($_POST)){
    $fName = $_POST['fName'];
    $lName = $_POST['lName'];
    $email = $_POST['email'];
    //Hash function to encrypt password
    $password = sha1($_POST['password']);

    //SQL statement to insert user data into users table
    $sql = "INSERT INTO users (fName, lName, email, password) VALUES(?,?,?,?)";

    //Prepare to and excute statement 
    $statementInsert = $db->prepare($sql);
    $result = $statementInsert->execute([$fName, $lName, $email, $password]);

    //Show success or errors of inserting into database
    if ($result){
        echo 'Saved successfully';
    }else{
        echo 'There was an error while saving data.';
    };
}else{
    echo 'No data';
}

?>