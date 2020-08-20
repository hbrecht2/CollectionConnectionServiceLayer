<?php

session_start();

// Load Composer's autoloader
require 'vendor/autoload.php';

//Connect to database 
require_once('config.php');

// Import PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Import Dompdf class 
use Dompdf\Dompdf;

//Get database information on collection to send
$userID = $_SESSION['id'];
$collectionName = $_POST['collectionToSend'];

$sql = "SELECT uc.ID 
        FROM userCollections as uc
        JOIN collections as c  
        ON uc.collectionID = c.collectionID
        WHERE collectionName = ? and userID = ?";

$statement = $db->prepare($sql);
$result = $statement->execute([$collectionName, $userID]);

if($result){
    $userCollectionID = $statement->fetchColumn();

    $sql = "SELECT name, imagePath, year, description
            FROM items 
            WHERE userCollectionID = ?";

    $statement = $db->prepare($sql);
    $result = $statement->execute([$userCollectionID]);
    
    $collectionItems = $statement->fetchAll();

    $html = '
                <div> 
                <h1> ' . $collectionName . '</h1>
            ';
    foreach($collectionItems as $item){
        $html .= '<div>
                    <h3> Item: ' . $item['name'] . '</h3>
                    <a href="' . $item['imagePath'] . '">Link To Download Image</a>
                    <p> Item Year: ' . $item['year'] . '</p>
                    <p> Item Description: ' . $item['description'] . '</p>
                    </div>';
    }
    $html .= '
                </div>
            ';
}else{
    echo "something has gone wrong";
}


//Instaniate a new dompdf class 
$dompdf = new Dompdf();
$dompdf->loadHtml($html);

//Create file name 
$fileName = md5(rand()) . '_' . $collectionName . '.pdf';

//Render document and save to file variable 
$dompdf->render();
$file = $dompdf->output();

file_put_contents($fileName, $file);


//PHPMailer variables to send mail

$toEmail = $_POST['recipientEmail'];
$fromEmail = 'collectionconnectioncontactus@gmail.com';
$subject = 'Someone has sent you a Collection List from Collection Connection!';
$message =  $_POST['emailMessage'];


// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = false;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = "smtp.gmail.com";                       // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = getenv('MAIL_USERNAME');                // SMTP username
    $mail->Password   = getenv('MAIL_PASSWORD');                // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom($fromEmail);
    $mail->addAddress($toEmail);                                // Add the recipient

    //Adds the Collection PDF as Attachment
    $mail->AddAttachment($fileName); 

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $subject ;
    $mail->Body    = 'Message: ' . $message;

    $mail->send();

    unlink($fileName);

    echo "1";
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}


    

?>