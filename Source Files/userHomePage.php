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
    <title>My Collections</title>

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
</head>

<body>
    <div class="pageContent">
        <!--Navigation Header-->
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">

                <a class="navbar-brand" href="index.php"><img
                        src="../DesignDocuments/collectionConnectionLogo.png"></a>
                <div class="text-right">
                    <p class="navbar-text"> Hello, User!</p>
                    <button class="navbar-toggler btn" type="button" data-toggle="collapse"
                        data-target="#navCollapseMenu">
                        <i class="fa fa-bars fa-2x" aria-hidden="true"></i>
                    </button>

                    <div class="collapse navbar-collapse" id="navCollapseMenu">
                        <div class="btn-group" role="group" aria-label="Navigation Options">
                            <a class="btn btn-secondary active" href="userHomePage.php">My Collections</a>
                            <a class="btn btn-secondary" href="shareCollection.html">Share My Collection</a>
                            <a class="btn btn-secondary" href="userHomePage.php?logout=true">Logout</a>
                        </div>
                    </div>

                </div>
            </div>
        </nav>

        <!--Collection Page Main Content-->
        <div class="collectionListContent">
            <div class="row mb-3">
                <div class="container text-right">
                    <button id="createCollectionBtn" class="btn btn-sm btn-secondary d-inline-block mb-2 mb-md-0"
                        type="button" data-toggle="modal" data-target="#createCollectionForm">Create New
                        Collection</button>
                    <input class="form-control-sm d-inline-block mb-2 mb-md-0" type="text"
                        placeholder="Search My Collections" aria-label="Search">
                </div>
            </div>

            <div class="container collectionItemListing">
                <div class="float-none row outline pt-3">
                    <div class="col-12 col-md-8">
                        <h3>Postcards</h3>
                        <div class="row">
                            <div class="col-12">
                                <ul>
                                    <li>
                                        <button class="btn btn-link" type="button" data-toggle="modal"
                                            data-target="#itemListing">Item</button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="editingBtnDiv text-right">
                            <button id="newItem" class="btn btn-sm btn-secondary" type="button" data-toggle="modal"
                                data-target="#addItemForm">Add New Item</button>
                            <button id="editItem" class="btn btn-sm btn-secondary" type="button" data-toggle="modal"
                                data-target="#editItemForm">Edit</button>
                            <button id="shareCollection" class="btn btn-sm btn-secondary" type="button"><a
                                    href="shareCollection.html">Share Collection</a></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--Create Collection Modal-->
        <div class="modal fade" id="createCollectionForm" tabindex="-1" role="dialog"
            aria-labelledby="#createCollectionForm" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="loginFormTitle">Let's Get Started!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body mx-5">
                        <div class="form-group">
                            <label for="collectionName">Collection Name</label>
                            <input type="text" class="form-control" id="collectionName" name="collectionName"
                                aria-describedby="collectionName" placeholder="Enter collection name here..">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-secondary">Create Collection</button>
                    </div>
                </div>
            </div>
        </div>

        <!--Add Item to Collection Modal-->
        <div class="modal fade" id="addItemForm" tabindex="-1" role="dialog" aria-labelledby="#addItemForm"
            aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addItemForm">Add Item</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body mx-5">
                        <div class="form-group">
                            <label for="itemName">Item Name</label>
                            <input type="text" class="form-control" id="itemName" name="itemName"
                                aria-describedby="itemName" placeholder="Enter item name here..">
                        </div>
                        <div class="form-group">
                            <form action="/action_page.php">
                                <label for="img">Item Image:</label>
                                <input type="file" id="img" name="img" accept="image/*">
                            </form>
                        </div>
                        <div class="form-group">
                            <label for="itemYear">Item Year</label>
                            <input type="text" class="form-control" id="itemYear" name="itemYear"
                                aria-describedby="itemYear" placeholder="Enter item year here..">
                        </div>
                        <div class="form-group">
                            <label for="itemDescription">Item Description</label>
                            <textarea id="itemDescription" class="form-control" name="itemDescription"
                                aria-describedby="itemDescription"
                                placeholder="Enter item description here.."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-secondary">Add Item</button>
                    </div>
                </div>
            </div>
        </div>

        <!--Edit Item Modal-->
        <div class="modal" id="editItemForm">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editItemFormTitle">Edit Item</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body mx-5">
                        <div class="form-group">
                            <label for="itemToEdit">Choose an item to edit:</label>
                            <select name="itemToEdit" id="itemToEdit">
                                <option value="item">Item</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="itemName">Item Name</label>
                            <input type="text" class="form-control" id="itemName" name="itemName"
                                aria-describedby="itemName" placeholder="Previous item content">
                        </div>
                        <div class="form-group">
                            <form action="/action_page.php">
                                <label for="img">Item Image:</label>
                                <input type="file" id="img" name="img" accept="image/*">
                            </form>
                        </div>
                        <div class="form-group">
                            <label for="itemYear">Item Year</label>
                            <input type="text" class="form-control" id="itemYear" name="itemYear"
                                aria-describedby="itemYear" placeholder="Previous item content">
                        </div>
                        <div class="form-group">
                            <label for="itemDescription">Item Year</label>
                            <textarea id="itemDescription" class="form-control" name="itemDescription"
                                aria-describedby="itemDescription" placeholder="Previous item content"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-secondary">Add Item</button>
                    </div>
                </div>
            </div>

        </div>




        <!--Item Listing Modal-->
        <div class="modal" id="itemListing">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <!-- header with Item Name-->
                    <div class="modal-header text-center">
                        <h4 class="modal-title w-100">Item Name</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Body with Item Image, Year, and Description -->
                    <div class="modal-body text-center">
                        <img src="../DesignDocuments/collectionConnectionLogo.png">
                        <div class="row">
                            <div class="col-4 text-right">
                                Year:
                            </div>
                            <div class="col-8 text-left">
                                2002
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4 text-right">
                                Description:
                            </div>
                            <div class="col-8 text-left breakText">
                                ahsdjfhaskjldfjasdflkasjdfl;ajsdlk;fjasdl;fj;lasdjflasdjflkasdjflkasjdfl;ajsdklfjaslkdfjasjflkasdjfklasjdflkasdjfklasjdlfkjasdfjasdfjaklsdfj
                            </div>
                        </div>
                    </div>

                    <!-- Footer with Close Button -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>


        <!--Contact Us Modal-->
        <div class="modal fade" id="contactUsForm" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <!-- Header-->
                    <div class="modal-header text-center">
                        <h4 class="modal-title w-100">Contact Us</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Contact Form-->
                    <div class="modal-body text-left">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="recipientEmail"
                                aria-describedby="recipientEmail" placeholder="Enter your email here..">
                        </div>
                        <div class="form-group">
                            <label for="contactMessage">Message</label>
                            <textarea id="contactMessage" class="form-control" name="contactMessage"
                                aria-describedby="contactMessage" placeholder="Enter your message here.."></textarea>
                        </div>
                    </div>

                    <!-- Footer with Cancel and Delete Button -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-secondary" data-dismiss="modal">Send</button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <footer class="text-center footer">
        <div class="container-fluid text-center">
            <button class="btn btn-link" type="button" data-toggle="modal" data-target="#contactUsForm">Contact
                Us</button>
            <span>|</span>
            <a class="btn btn-link" href="myAccount.html">My Account</button>
        </div>
    </footer>
</body>

</html>