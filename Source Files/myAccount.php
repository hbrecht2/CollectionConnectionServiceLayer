<?php
session_start();
    if(!isset($_SESSION['userlogin'])){
        header("Location: index.php");
    }
    
    if(isset($_GET['logout'])){
        session_destroy();
        unset($_SESSION);
        header("Location: index.php");
    }

require('config.php');

$userID=$_SESSION['id'];

$sql = "SELECT * FROM users WHERE ID = ?";

$statement = $db->prepare($sql);
$result = $statement->execute([$userID]);

if($result){
    $user = $statement->fetch(PDO::FETCH_ASSOC);
    $firstName = $user['fName'];
    $lastName = $user['lName'];
    $email = $user['email'];
    $dateCreated = $user['dateCreated'];
}

$date = DateTime::createFromFormat('Y-m-d H:i:s', $dateCreated);
$reformattedDate = $date->format('F j, Y');


?>


<!DOCTYPE>
<html>

<head>
    <title>My Account</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="stylesheet.css">

    <!--Icons-->
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
        crossorigin="anonymous"></script>
    <script type="text/javascript" src="scripts3.js"></script>
</head>

<body>
    <div class="pageContent">
        <!--Navigation Header-->
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">

                <a class="navbar-brand" href="index.php"><img
                        src="collectionConnectionLogo.png"></a>
                <div class="text-right">
                    <p class="navbar-text d-none d-sm-inline-block"> Hello, <?php echo $firstName; ?>!</p>
                    <button class="navbar-toggler btn" type="button" data-toggle="collapse"
                        data-target="#navCollapseMenu">
                        <i class="fa fa-bars fa-2x" aria-hidden="true"></i>
                    </button>

                    <div class="collapse navbar-collapse" id="navCollapseMenu">
                        <div class="btn-group" role="group" aria-label="Navigation Options">
                            <a class="btn btn-secondary" href="userHomePage.php">My Collections</a>
                            <a class="btn btn-secondary" href="shareCollection.php">Share My Collection</a>
                            <a class="btn btn-secondary" href="myAccount.php?logout=true">Logout</a>
                        </div>
                    </div>

                </div>
            </div>
        </nav>

        <!--My Account Information-->
        <div class="accountInformation">
            <div class="row">
                <div class="col-12 col-md-6 outline p-5">
                    <div class="row mb-5">
                        <div class="col-12 text-center">
                            <h4>Account Information</h4>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 col-md-5 text-md-right ">
                            <h5>Name</h5>
                        </div>
                        <div class="col-12 col-md-7 outline">
                            <h6><?php echo $firstName. ' ' . $lastName; ?></h6>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 col-md-5 text-md-right ">
                            <h5>Email</h5>
                        </div>
                        <div class="col-12 col-md-7 outline">
                            <h6><?php echo $email; ?></h6>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 col-md-5 text-md-right ">
                            <h5>Date Created</h5>
                        </div>
                        <div class="col-12 col-md-7 outline">
                            <h6><?php echo $reformattedDate; ?></h6>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 mt-5 text-center">
                    <a id="logOutBtn" class="btn btn-secondary col-12 col-md-6 offset-md-3 p-2 mb-4"
                    href="userHomePage.php?logout=true">Log Out</a>
                    <button class="btn btn-secondary col-12 col-md-6 offset-md-3 p-2 mb-4"
                        type="button" data-toggle="modal" data-target="#editAccountForm">Edit Account Info</button>
                    <button class="btn btn-secondary col-12 col-md-6 offset-md-3 p-2 mb-4"
                        type="button" data-toggle="modal" data-target="#changePasswordForm">Change Password</button>
                    <button class="btn btn-secondary col-12 col-md-6 offset-md-3 p-2 mb-4"
                        type="button" data-toggle="modal" data-target="#deleteAccountForm">Delete Account</button>
                </div>
            </div>
        </div>

        <!--Edit Account Modal-->
        <div class="modal" id="editAccountForm">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editAccountTitle">Edit Account Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="editAccount" action="editAccount.php" method="post">
                        <div class="modal-body mx-5">
                            <div class="form-group">
                                <label for="firstName">First Name</label>
                                <input type="text" class="form-control" id="firstName" name="firstName"
                                    aria-describedby="firstName" value="<?php echo $firstName; ?>">
                            </div>
                            <div class="form-group">
                                <label for="lastName">Last Name</label>
                                <input type="text" class="form-control" id="lastName" name="lastName"
                                    aria-describedby="lastName" value="<?php echo $lastName; ?>">
                            </div>
                            <div class="form-group">
                                <label for="accountEmail">Email</label>
                                <input type="email" class="form-control" id="accountEmail" name="accountEmail"
                                    aria-describedby="accountEmail" value="<?php echo $email; ?>">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn" data-dismiss="modal">Cancel</button>
                            <button id="editAccountBtn" type="submit" class="btn btn-secondary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!--Change Password Modal-->
        <div class="modal" id="changePasswordForm">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editAccountTitle">Change Password</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="changePassword"  action="changePassword.php" method="post">
                        <div class="modal-body mx-5">
                            <div class="incorrectPasswordDiv"></div>
                            <div class="form-group">
                                <label for="currentPassword">Current Password</label>
                                <input type="password" class="form-control" id="currentPassword" name="currentPassword"
                                    aria-describedby="currentPassword" autocomplete="off" required>
                            </div>
                            <div class="passwordMessageDiv">
                            </div>
                            <div class="form-group">
                                <label for="newPassword">New Password</label>
                                <input type="password" class="form-control" id="newPassword" name="newPassword"
                                    aria-describedby="newPassword" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label for="confirmNewPassword">Confirm New Password</label>
                                <input type="password" class="form-control" id="confirmNewPassword" name="confirmNewPassword"
                                    aria-describedby="confirmNewPassword" autocomplete="off" required>
                            </div>
                            <div id="pswd_info" class="form=group">
                                <p>Password must meet the following requirements:</p>
                                <ul>
                                    <li id="letter" class="invalid">At least one letter </li>
                                    <li id="capital" class="invalid">At least one capital letter </li>
                                    <li id="number" class="invalid">At least one number </li>
                                    <li id="length" class="invalid">Be at least 8 characters </li>
                                </ul>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn" data-dismiss="modal">Cancel</button>
                            <button id="changePasswordBtn" type="submit" class="btn btn-secondary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!--Delete Account Modal-->
        <div class="modal fade" id="deleteAccountForm">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                <form id="deleteAccount" action="deleteAccount.php" method="post">
                    <!-- Header-->
                    <div class="modal-header text-center">
                        <h4 class="modal-title w-100">Delete Account</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    
                    <!-- Message-->
                    <div class="modal-body text-center">
                        <p>Deletion of your account is permanent and cannot be undone. All data will
                            be lost. Check box below to confirm.</p>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="deleteAccountCheck">
                            <label class="form-check-label" for="deleteAccountCheck">
                                By checking this box, I agree to deleting my account.
                            </label>
                            <div class="deleteMessageDiv">
                            </div>
                        </div>
                    </div>

                    <!-- Footer with Cancel and Delete Button -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button id="deleteAccountBtn" type="button" class="btn btn-secondary">Delete Account</button>
                    </div>

                </form>

                </div>
            </div>
        </div>


        <!--Contact Us Modal-->
        <div class="modal fade" id="contactUsForm" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                <form id="contactUs">
                    <!-- Header-->
                    <div class="modal-header text-center">
                        <h4 class="modal-title w-100">Contact Us</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Contact Form-->
                    <div class="modal-body text-left">
                        <p class="contactFormSent successMessage"></p>
                        <div class="form-group">
                            <label for="clientEmail">Email</label>
                            <input type="email" class="form-control" id="clientEmail"
                                aria-describedby="clientEmail" placeholder="Enter your email here.." required>
                        </div>
                        <div class="form-group">
                            <label for="contactMessage">Message</label>
                            <textarea id="contactMessage" class="form-control" name="contactMessage"
                                aria-describedby="contactMessage" placeholder="Enter your message here.." required></textarea>
                        </div>
                    </div>

                    <!-- Footer with Cancel and Delete Button -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button id="contactUsBtn" type="submit" class="btn btn-secondary" >Send</button>
                    </div>
                </form>

                </div>
            </div>
        </div>

    </div>

    <footer class="text-center footer">
        <div class="container-fluid text-center">
            <button class="btn btn-link" type="button" data-toggle="modal" data-target="#contactUsForm">Contact
                Us</button>
            <span>|</span>
            <a class="btn btn-link activeLink" href="myAccount.html">My Account</button>
        </div>
    </footer>

</body>

</html>