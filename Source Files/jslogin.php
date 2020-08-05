<?php
session_start();
require_once('config.php');

$email = $_POST['email'];
$password = sha1($_POST['password']);

$sql = "SELECT * FROM users WHERE email = ? AND password = ? LIMIT 1";
$statement = $db->prepare($sql);
$result = $statement->execute([$email, $password]);

if ($result){
    $user = $statement->fetch(PDO::FETCH_ASSOC);
    if($statement->rowCount() > 0){
        $_SESSION['userlogin'] = $user;
        echo "1";
    }else{
        echo "No user with that email and password found.";
    }
}else{
    echo "Could not connect to database";
}

?>