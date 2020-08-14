$(function () {

    
    //Loads the user's collections when the page loads 
    loadUserCollections();
    getCollectionName();

    
    function loadUserCollections(){
        $.ajax({
            type: 'GET',
            url: 'getUserCollections.php',
            dataType: "json",
            success: function(data){
                var collectionNameArray = [];
                $.each(data, function(index, value){
                    collectionNameArray.push(value['collectionName']);
                })
                displayCollection(collectionNameArray);
            },
            error: function(data){
                console.log("There was an error while loading user collection data. Please try again or contact website admin.")
            }
        })

    }

     $('#createCollectionBtn').click(function (e) {
        var valid = $('#createCollection')[0].checkValidity();

        //Checks that form values are valid 
        if (valid) {
            //  value of form inputs and sets to respective variables
            var collectionName = $('#collectionName').val();
        
            //Prevents submission of from prematurely
            e.preventDefault();

            //POST Account Info from form to DB
            $.ajax({
                type: 'POST',
                url: 'createCollection.php',
                data: { collectionName: collectionName },
                success: function (data) {
                    $("#createCollectionForm").modal('hide');3
                    window.location.reload();
                },
                error: function (data) {
                    console.log("An error occurred and we could not create your collection")
                }
            });
        }
    });

    $('#deleteCollectionBtn').click(function(e){
        var valid = $('#deleteCollection')[0].checkValidity();

        if(valid){
            var collectionToDelete = $('#collectionToDelete option:selected').text();

            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: 'deleteCollection.php',
                data: { collectionToDelete: collectionToDelete },
                success: function (data) {
                    $("#deleteCollectionForm").modal('hide');3
                    window.location.reload();
                },
                error: function (data) {
                    console.log("An error occurred")
                }
            });
        }
    });

    function addItemToCollection(collectionName){
        $('#addItemBtn').click(function (e) {
            var valid = $('#addItem')[0].checkValidity();    
    
            //Checks that form values are valid 
            if (valid) {
                //  value of form inputs and sets to respective variables
                var itemName = $('#itemName').val();
                var itemImg = $('#itemImg')
                var itemYear = $('#itemYear').val();
                var itemDescription = $('#itemDescription').val();
    
               
            }
        });

    }

    //Displays personal collection information for each user
    function displayCollection(collectionNames){
        if(collectionNames.length === 0){
            $("#userCollectionsDiv").append(
                `<div class="message">
                    <p> You don't have any collections at this time.<button class="btn btn-link link-text" type="button" data-toggle="modal" data-target="#createCollectionForm">Create Collection</button>to get started! </p>
                </div>            
                `  );
            $("#collectionControls").hide();
        }else{
        collectionNames.forEach(element => {
            $("#userCollectionsDiv").append(
                `<div class="container collectionItemListing mb-3">
                    <div class="float-none row outline pt-3">
                        <div class="col-12 col-md-8">
                            <h3 class="collectionName">` + element + `</h3>
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
                                <button id="`+element+`" class="btn btn-sm btn-secondary addItemBtn" type="button" data-toggle="modal"
                                    data-target="#addItemForm">Add New Item</button>
                                <button id="editItem" class="btn btn-sm btn-secondary" type="button" data-toggle="modal"
                                    data-target="#editItemForm">Edit</button>
                                <button id="shareCollection" class="btn btn-sm btn-secondary" type="button"><a
                                        href="shareCollection.html">Share Collection</a></button>
                            </div>
                        </div>
                    </div>
                </div>`);

            $("#collectionToDelete").append(
                `<option>` + element + `</option>`
            ); 
        });  
    }      
    }


    //Returns the name of the collection that the user wants to manipulate 
    function getCollectionName(){
        //Uses on() function as click() event doesn't consider dynamically created elements 
        $(".collectionListContent").on("click", '.addItemBtn', (function() {
            collectionName = (this.id);
            addItemToCollection(collectionName);
        })
        )
    };

});