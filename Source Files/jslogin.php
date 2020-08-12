<?php
session_start();
require_once('config.php');

//Values from login form
$email = $_POST['email'];
$password = sha1($_POST['password']);

//SQL query to get user information
$sql = "SELECT * FROM users WHERE email = ? AND password = ? LIMIT 1";
$statement = $db->prepare($sql);
$result = $statement->execute([$email, $password]);

if ($result){
    $user = $statement->fetch(PDO::FETCH_ASSOC);
    //Checks that user is found successfully
    if($statement->rowCount() > 0){
        $_SESSION['id'] = $user['ID'];
        $_SESSION['fName'] = $user['fName'];
        $_SESSION['lName'] = $user['lName'];
        $_SESSION['email'] = $user['email'];

        $_SESSION['userlogin'] = $user;
        echo "1";
    }else{
        echo "No user with that email and password found.";
    }
}else{
    echo "Could not connect to database";
}

?>