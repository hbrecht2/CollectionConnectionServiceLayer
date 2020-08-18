<?php
session_start();
require_once('config.php');

//Store item information from form in variables to use in SQL query 

$userID = $_SESSION['id'];
$collectionName = $_POST['collectionName'];

$itemName = $_POST['itemName'];
$itemYear = $_POST['itemYear'];
$itemDescription = $_POST['itemDescription'];


$newImageName = uniqid() . "_" . time();
$ext=pathinfo($_FILES['itemImg']['name'], PATHINFO_EXTENSION);

$basename= $newImageName . "." . $ext;
$target = "../UserUploads/{$basename}";

if($ext!="jpg" && $ext!="JPG" && $ext!="jpeg" && $ext!="png"){
    echo "2";
}else if($_FILES['itemImg']['error'] == 1){
    echo "3";
}else if (move_uploaded_file($_FILES['itemImg']['tmp_name'], $target)){
    //SQL Query 
    $sql = "SELECT ID 
            FROM userCollections as uc 
            JOIN collections as c 
            ON uc.collectionID = c.collectionID 
            WHERE collectionName = ? AND uc.userID = ?";
            
    $statement = $db->prepare($sql);
    $result = $statement->execute([$collectionName, $userID]);

    $userCollectionID = $statement->fetchColumn();

    if($result){
        $sql = "INSERT INTO items (userCollectionID, name, imagePath, year, description)
            VALUES (?, ?, ?, ?, ?)";
 
            $statement = $db->prepare($sql);
            $result = $statement->execute([$userCollectionID, $itemName, $target, $itemYear, $itemDescription]);
            echo "1";
        };
};


/*Success data codes -- Presents a different alert message based on validation of the image and whether item is successfully added
1- Item added successfully.
2- File with this extension not accepted 
3- Image is too large. 
*/
?>
