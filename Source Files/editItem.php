<?php
session_start();
require_once('config.php');

require 'vendor/autoload.php';
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

$bucketName = getenv('S3_BUCKET_NAME');
$IAM_KEY = getenv('IAM_KEY');
$IAM_SECRET = getenv('IAM_SECRET');

$s3 = S3Client::factory(
    array(
        'credentials' => array(
            'key' => $IAM_KEY,
            'secret' => $IAM_SECRET
        ),
        'version' => 'latest',
        'region'  => 'us-east-2'
    ));

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
    $keyName = uniqid() . "_" . time();
    $target = 'https://s3.us-east-2.amazonaws.com/' . $bucketName . '/' . $keyName;


    $ext=pathinfo($_FILES['updatedImgPath']['name'], PATHINFO_EXTENSION);

    if($ext!="jpg" && $ext!="JPG" && $ext!="jpeg" && $ext!="png"){
        echo "2";
    }else if($_FILES['updatedImgPath']['error'] == 1){
        echo "3";
    }else{
        try {
            // Uploaded:
            $file = $_FILES["updatedImgPath"]['tmp_name'];
    
            $s3->putObject(
                array(
                    'Bucket'=>$bucketName,
                    'Key' =>  $keyName,
                    'SourceFile' => $file,
                    'StorageClass' => 'REDUCED_REDUNDANCY'
                )
            );

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
        } catch (S3Exception $e) {
            die('Error:' . $e->getMessage());
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        };
    
    };
};



/*Image upload message codes-- Presents a different alert message based on validation of the image and whether item is successfully added
1- Item updated successfully.
2- File with this extension not accepted 
3- Image is too large. 
*/


?>
