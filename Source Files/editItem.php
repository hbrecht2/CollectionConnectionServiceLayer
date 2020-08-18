<?php
session_start();
require_once('config.php');

//Store item information from form in variables to use in SQL query 

$userID = $_SESSION['id'];
$collectionName = $_POST['collectionName'];
$itemToUpdate = $_POST['itemToUpdate'];

$itemName = $_POST['updatedItemName'];
$itemYear = $_POST['updatedItemYear'];
$itemDescription = $_POST['updatedItemDescription'];


//Check if new image was uploaded
if($_FILES['updatedImgPath']['error'] == 4){
    $target = $_POST['imagePath']; 
    //SQL Query if image not updated
    $sql = "SELECT ID 
            FROM userCollections as uc 
            JOIN collections as c 
            ON uc.collectionID = c.collectionID 
            WHERE collectionName = ? AND uc.userID = ?";
            
    $statement = $db->prepare($sql);
    $result = $statement->execute([$collectionName, $userID]);

    $userCollectionID = $statement->fetchColumn();

    if($result){
        $sql = "UPDATE items 
            SET name = ?, imagePath = ?, year = ?, description = ?
            WHERE name = ? AND userCollectionID = ?";
 
            $statement = $db->prepare($sql);
            $result = $statement->execute([$itemName, $target, $itemYear, $itemDescription, $itemToUpdate, $userCollectionID]);

            echo "1";
        };

//If uploaded, rename and store file 
}else{
    $newImageName = uniqid() . "_" . time();
    $ext=pathinfo($_FILES['updatedImgPath']['name'], PATHINFO_EXTENSION);

    $basename= $newImageName . "." . $ext;
    $target = "../UserUploads/{$basename}";

    if($ext!="jpg" && $ext!="JPG" && $ext!="jpeg" && $ext!="png"){
        echo "2";
    }else if($_FILES['updatedImgPath']['error'] == 1){
        echo "3";
    }else if(move_uploaded_file($_FILES['updatedImgPath']['tmp_name'], $target)){
        //SQL Query if image is uploaded
    $sql = "SELECT ID 
            FROM userCollections as uc 
            JOIN collections as c 
            ON uc.collectionID = c.collectionID 
            WHERE collectionName = ? AND uc.userID = ?";
            
        $statement = $db->prepare($sql);
        $result = $statement->execute([$collectionName, $userID]);

        $userCollectionID = $statement->fetchColumn();

        if($result){
            $sql = "UPDATE items 
                SET name = ?, imagePath = ?, year = ?, description = ?
                WHERE name = ? AND userCollectionID = ?";

                $statement = $db->prepare($sql);
                $result = $statement->execute([$itemName, $target, $itemYear, $itemDescription, $itemToUpdate, $userCollectionID]);

                echo "1";
        };
    };
};



/*Image upload message codes-- Presents a different alert message based on validation of the image and whether item is successfully added
1- Item updated successfully.
2- File with this extension not accepted 
3- Image is too large. 
*/


?>
