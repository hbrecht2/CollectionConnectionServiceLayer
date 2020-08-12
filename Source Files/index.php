<?php
require_once('config.php');

    session_start();
    if(isset($_SESSION['userlogin'])){
        header("Location: userHomePage.php");
    }
?>

<!DOCTYPE>
<html>
    <head>
        <title>Connection Collection</title>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <link rel="stylesheet" href="stylesheet.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
        <script type="text/javascript" src="scripts.js"></script>
    
    </head>

    <body>     
        <!--Navigation Header-->
        <nav class="navbar navbar-expand-md navbar-li ght pt-0">
            <div class="container-fluid">
                <a class="navbar-brand" href="#"><img src="../DesignDocuments/collectionConnectionLogo.png"></a>
                <button class="btn btn-secondary" type="button" data-toggle="modal" data-target="#loginForm">Log In</button>
            </div>
        </nav>

        <!--Home page main content-->
        <div id="mainPageContent" class="container-fluid">
            <div class="jumbotron pt-0 mt-0 mx-auto text-center bg-white" style="width: 75%">
                <h1 class="display-4 font-weight-bold">Welcome!</h1>
                <p class="lead font-weight-bold">Collection Connection aims to serve all collectors by providing a space to keep track of all items owned. You can also share your collections with fellow collectors to make trading easier than ever!</p>
                <hr class="my-2">
                <div>
                    <button class="btn btn-lg btn-secondary" type="button" data-toggle="modal" data-target="#createAccountForm">Create Account</button><br>
                    <button class="btn btn-link btn-link-dkPink" type="button" data-toggle="modal" data-target="#loginForm">Log In</button>
                </div>    
            </div>    
        </div>

        <!--Login Form Modal-->
        <div class="modal fade" id="loginForm" tabindex="-1" role="dialog" aria-labelledby="#loginForm" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <form id="login">
                    <div class="modal-header">
                        <h5 class="modal-title" id="loginFormTitle">Please login to continue...</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body mx-5">
                        <form action="index.php" method="post">
                            <div class="form-group">
                                <label for="inputEmail">Email</label>
                                <input type="text" class="form-control" id="inputEmail" name="inputEmail" aria-describedby="inputEmail" placeholder="Enter email" required>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword">Password</label>
                                <input type="password" class="form-control" id="inputPassword" name="inputPassword" aria-describedby="inputPassword" placeholder="Enter password" required autocomplete="off">
                            </div>
                        </form>
                        <small>     
                            Don't have an account? 
                            <button class="btn btn-link btn-link-dkPink p-0" type="button" data-toggle="modal" data-dismiss="modal" data-target="#createAccountForm">
                                <small>Create Account</small>
                            </button>
                        </small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" id="loginBtn" class="btn btn-primary" data-dismiss="modal">Login</button>
                    </div>
                </form>
                </div>
            </div>
        </div>

        <!--Create Account Form Modal-->
        <div class="modal fade" id="createAccountForm" tabindex="-1" role="dialog" aria-labelledby="#createAccountForm" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <form action="index.php" method="post" id="createAccount">
                    <div class="modal-header">
                        <h5 class="modal-title" id="loginFormTitle">Please create an account to continue..</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body mx-5">
                            <div class="form-group">
                                <label for="fName">First Name</label>
                                <input type="text" class="form-control" id="fName" name="fName" aria-describedby="firstName" placeholder="First Name" required>
                            </div>
                            <div class="form-group">
                                <label for="lName">Last Name</label>
                                <input type="text" class="form-control" id="lName" name="lName" aria-describedby="lastName" placeholder="Last Name" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" aria-describedby="email" placeholder="Enter email" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" aria-describedby="password" placeholder="Enter password"  autocomplete="off" required>
                            </div>
                        <small>     
                            Already have an account? 
                            <button class="btn btn-link btn-link-dkPink p-0" type="button" data-toggle="modal" data-dismiss="modal" data-target="#loginForm">
                                <small>Log In</small>
                            </button>
                        </small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <br>
                        <button type="submit" name="createAccount" id="createAccountBtn" class="btn btn-primary">Create Account</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    
    </body>
</html>