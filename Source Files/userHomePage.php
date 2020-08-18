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


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
        crossorigin="anonymous"></script>
    <script type="text/javascript" src="scripts2.js"></script>

    
</head>

<body>
    <div class="pageContent">
        <!--Navigation Header-->
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">

                <a class="navbar-brand" href="index.php"><img
                        src="../DesignDocuments/collectionConnectionLogo.png"></a>
                <div class="text-right">
                    <p class="navbar-text d-none d-sm-inline-block"> Hello, <?php  echo $_SESSION['fName'] ?>!</p>
                    <button class="navbar-toggler btn" type="button" data-toggle="collapse"
                        data-target="#navCollapseMenu">
                        <i class="fa fa-bars fa-2x" aria-hidden="true"></i>
                    </button>

                    <div class="collapse navbar-collapse" id="navCollapseMenu">
                        <div class="btn-group" role="group" aria-label="Navigation Options">
                            <a class="btn btn-secondary active" href="userHomePage.php">My Collections</a>
                            <a class="btn btn-secondary" href="shareCollection.php">Share My Collection</a>
                            <a class="btn btn-secondary" href="userHomePage.php?logout=true">Logout</a>
                        </div>
                    </div>

                </div>
            </div>
        </nav>

        <!--Collection Page Main Content-->
        <div class="collectionListContent">
            <div class="row mb-3">
                <div id="collectionControls" class="container text-right">
                    <button class="btn btn-sm btn-secondary d-inline-block mb-2 mb-md-0"
                        type="button" data-toggle="modal" data-target="#createCollectionForm">Create New
                        Collection</button>
                    <button class="btn btn-sm btn-secondary d-inline-block mb-2 mb-md-0"
                        type="button" data-toggle="modal" data-target="#deleteCollectionForm">Delete
                        Collection</button>
                    <input class="form-control-sm d-inline-block mb-2 mb-md-0" type="text"
                        placeholder="Search My Collections" aria-label="Search">
                </div>
            </div>

            <div id="userCollectionsDiv">
    
            </div>

            
        </div>

        <!--Create Collection Modal-->
        <div class="modal fade" id="createCollectionForm" tabindex="-1" role="dialog"
            aria-labelledby="#createCollectionForm" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form id="createCollection">
                    <div class="modal-header">
                        <h5 class="modal-title">Let's Get Started!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body mx-5">
                        <div class="form-group">
                            <label for="collectionName">Collection Name</label>
                            <input type="text" class="form-control" id="collectionName" name="collectionName"
                                aria-describedby="collectionName" placeholder="Enter collection name here.." required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-secondary" id="createCollectionBtn">Create Collection</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!--Delete Collection Modal-->
        <div class="modal fade" id="deleteCollectionForm" tabindex="-1" role="dialog"
            aria-labelledby="#deleteCollectionForm" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form id="deleteCollection">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete A Collection</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body mx-5">
                        <div class="form-group">
                            <label for="collectionToDelete">Which collection would you like to remove? </label>
                            <select name="collectionToDelete" id="collectionToDelete" required>
                                <option hidden disabled selected value> -- select a collection below -- </option>
                            </select>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="collectionDeleteCheck" required>
                            <label class="form-check-label" for="collectionDeleteCheck">
                                Deleting a collection is permanent and cannot be undone. Check this box to continue with removing the collection.  
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-secondary" id="deleteCollectionBtn">Delete Collection</button>
                    </div>
                    </form>
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
                    <form id="addItem" action="addItem.php" method="post" enctype="multipart/form-data">
                    <div class="modal-body mx-5">
                        <div class="form-group">
                            <label for="itemName">Item Name</label>
                            <input type="text" class="form-control" id="itemName" name="itemName"
                                aria-describedby="itemName" placeholder="Enter item name here.." required>
                        </div>
                        <div class="form-group">
                            <label for="itemImg">Item Image:</label>
                            <input type="file" id="itemImg" name="itemImg" accept="image/*" required>
                        </div>
                        <div class="form-group itemYearDiv">
                            <label for="itemYear">Item Year</label>
                            <input type="text" class="form-control" id="itemYear" name="itemYear"
                                aria-describedby="itemYear" placeholder="Enter item year here.." required>
                        </div>
                        <div class="form-group">
                            <label for="itemDescription">Item Description</label>
                            <textarea id="itemDescription" class="form-control" name="itemDescription"
                                aria-describedby="itemDescription"
                                placeholder="Enter item description here.." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn" data-dismiss="modal">Cancel</button>
                        <button id="addItemBtn" type="button" class="btn btn-secondary">Add Item</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!--Edit Item Modal-->
        <div class="modal modal-small" id="editItemForm">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editItemFormTitle" data-item=""></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="editItem" action="editItem.php" method="post" enctype="multipart/form-data">
                        <div class="modal-body mx-5">
                            <div class="form-group">
                                <label for="updatedItemName">Item Name</label>
                                <input type="text" class="form-control" id="updatedItemName" name="updatedItemName"
                                    aria-describedby="updatedItemName" value="">
                            </div>
                            <div class="form-group">
                                    <label for="updatedImgPath">Item Image:</label>
                                    <br>
                                    <img id="previousPhoto" src="">
                                    <input type="file" id="updatedImgPath" name="updatedImgPath" accept="image/*" value="">
                            </div>
                            <div class="form-group itemYearDiv">
                                <label for="updatedItemYear">Item Year</label>
                                <input type="text" class="form-control" id="updatedItemYear" name="updatedItemYear"
                                    aria-describedby="updatedItemYear" value="">
                            </div>
                            <div class="form-group">
                                <label for="updatedItemDescription">Item Description</label>
                                <textarea id="updatedItemDescription" class="form-control" name="updatedItemDescription"
                                    aria-describedby="updatedItemDescription" value=""></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn" data-dismiss="modal">Cancel</button>
                            <button id="submitEditsBtn" type="button" class="btn btn-secondary" data-collection="" data-img="">Edit Item</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>


        
        <!--Item Listing Modal-->
        <div class="modal" id="itemListing">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <!-- header with Item Name-->
                    <div class="modal-header text-center">
                        <h4 id= "modalItemName" class="modal-title w-100"></h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Body with Item Image, Year, and Description -->
                    <div class="modal-body text-center">
                        <img id= "modalItemImg" class="itemListingImage" src="">
                        <div class="row">
                            <div class="col-4 text-right">
                                Year:
                            </div>
                            <div id= "modalItemYear" class="col-8 text-left">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4 text-right">
                                Description:
                            </div>
                            <div id= "modalItemDescription" class="col-8 text-left breakText">

                            </div>
                        </div>
                    </div>

                    <!-- Footer with Close Button -->
                    <div class="modal-footer">
                        <button id="deleteItemBtn" type="button" class="btn btn-link mr-auto" data-collection="" data-name="">Delete Item</button>
                        <button id="editItemBtn" class="btn btn-sm btn-secondary" type="button" data-toggle="modal"
                                    data-target="#editItemForm" data-dismiss="modal" data-collection="" data-name="" data-img="" data-year="" data-description="" >Edit Item</button>
                    </div>

                </div>
            </div>
        </div>

        <!--Confirm Item Delete Modal-->
        <div id="confirmItemDelete" class="modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class= "modal-content">

                    <div id="confirmDeleteMessage" class="modal-body confirmDeleteText">
                    </div>
                    
                    <div class="modal-footer">
                        <button id="deleteItemConfirmBtn" type="button" data-dismiss="modal" class="btn btn-primary" >Delete</button>
                        <button type="button" data-dismiss="modal" class="btn">Cancel</button>
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
    <p id="linkMessage" class="text-center mb-0" >To get more information, edit, or delete an item, click on the item in the list.</p>
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