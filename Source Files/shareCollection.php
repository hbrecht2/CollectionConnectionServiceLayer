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

?>


<!DOCTYPE>
<html>

<head>
    <title>Share Collections</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="stylesheet.css">

    <!--Icons-->
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
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
                    <p class="navbar-text d-none d-sm-inline-block"> Hello, User!</p>
                    <button class="navbar-toggler btn" type="button" data-toggle="collapse"
                        data-target="#navCollapseMenu">
                        <i class="fa fa-bars fa-2x" aria-hidden="true"></i>
                    </button>

                    <div class="collapse navbar-collapse" id="navCollapseMenu">
                        <div class="btn-group" role="group" aria-label="Navigation Options">
                            <a class="btn btn-secondary" href="userHomePage.php">My Collections</a>
                            <a class="btn btn-secondary active" href="shareCollection.php">Share My Collection</a>
                            <a class="btn btn-secondary" href="shareCollection.php?logout=true">Logout</a>
                        </div>
                    </div>

                </div>
            </div>
        </nav>

        <!--Share Collection Page Main Content-->
        <div class="container-fluid shareCollectionInfo">
            <h1 class="col-12 text-center">Share Your Collections!</h1>
            <h6 class="col-8 offset-2 text-center">Collection Connection will share your collection with other
                collectors if you desire.
                We will send a formatted PDF version of your collection including the item name, image, year, and
                description that you have provided to us when creating the collection.
                Simply provide us with the e-mail of the fellow collector and fill out the form below to send it on it's
                way!
            </h6>
        </div>
        <div class="container-fluid emailForm">
            <form>
                <div class="form-group">
                    <label for="recipientEmail">Email</label>
                    <input type="email" class="form-control" id="recipientEmail" aria-describedby="recipientEmail"
                        placeholder="Enter enter the recipient's email here..">
                </div>
                <div class="form-group">
                    <label for="emailMessage">Message</label>
                    <textarea id="emailMessage" class="form-control" name="emailMessage" aria-describedby="emailMessage"
                        placeholder="Type message to send with the collection list here.."></textarea>
                </div>
                <div class="formgroup">
                    <label for="collectionToSend">Collection List</label>
                    <select class="custom-select">
                        <option selected>Choose which collection list to be sent</option>
                        <option value="listName">List Name</option>
                    </select>
                </div>
                <div class="text-center mt-4">
                    <button type="reset" class="btn btn-secondary right-align">Reset</button>
                    <button type="submit" class="btn btn-secondary right-align">Send</button>
                </div>
            </form>
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
            <a class="btn btn-link" href="myAccount.php">My Account</button>
        </div>
    </footer>
</body>

</html>