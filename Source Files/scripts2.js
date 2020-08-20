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
                    loadCollectionItems(value['collectionID'], value['collectionName']);
                })
                displayCollection(collectionNameArray);
            },
            error: function(data){
                console.log("There was an error while loading user collection data. Please try again or contact website admin.")
            }
        })

    }

    function loadCollectionItems(collectionID, collectionName){
        $.ajax({
            type: 'GET',
            url: 'getCollectionItems.php',
            data: {collectionID: collectionID},
            dataType: "json",
            success: function(data){
                var collectionItemArray = [];
                $.each(data, function(index, value){
                    itemInformation = [value['name'], value['year'], value['imagePath'], value['description']]; 
                    collectionItemArray.push(itemInformation);
                })
                showCollectionItems(collectionItemArray, collectionName);
            },
            error: function(data){
                console.log("There was an error while loading user collection data. Please try again or contact website admin.")
            }
        });
    };

     $('#createCollectionBtn').click(function (e) {
        var valid = $('#createCollection')[0].checkValidity();

        //Checks that form values are valid 
        if (valid) {
            //  value of form inputs and sets to respective variables
            var collectionName = $('#collectionName').val();
        
            //Prevents submission of from prematurely
            e.preventDefault();

            //Disables the submit button so user can't accidentally upload many copies 
            $('#createCollectionBtn').attr("disabled", true);

            //POST Account Info from form to DB
            $.ajax({
                type: 'POST',
                url: 'createCollection.php',
                data: { collectionName: collectionName },
                success: function (data) {
                    $("#createCollectionForm").modal('hide');
                    window.location.reload();
                },
                error: function (data) {
                    console.log("An error occurred and we could not create your collection. Please try again and contact website administrators if issue persists.")
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
                    $("#deleteCollectionForm").modal('hide');
                    window.location.reload();
                },
                error: function (data) {
                    console.log("An error occurred while deleting collection. Please try again and contact website administrators if issue persists.")
                }
            });
        }
    });

    $('#submitEditsBtn').click(function(e){
        var collectionName = $('#submitEditsBtn').data('collection')
        var itemToUpdate = $('#editItemFormTitle').data('item')
        var imgPath = $('#submitEditsBtn').data('img')
        
        var file = $('#updatedImgPath').val()
        
        var valid = $('#editItem')[0].checkValidity();
        
        if(valid){
            var formData = new FormData(document.getElementById("editItem"));
            formData.append('collectionName', collectionName);
            formData.append('itemToUpdate', itemToUpdate);

            if(file===""){
                formData.append('imagePath', imgPath)
            }

            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: 'editItem.php',
                data: formData,
                contentType: false, 
                processData: false, 
                success: function (data) {
                    if(data === "1"){
                        window.location.reload();
                    }else if(data === "2"){
                        $(".itemYearDiv").prepend(
                            `<p class="wrongInputAlert">Image must be a jpg or png file.</p>`
                        )
                    }else if(data === "3"){
                        $(".itemYearDiv").prepend(
                            `<p class="wrongInputAlert">Image is too large. You must resize before uploading.</p>`
                        )
                    }else{
                        alert(data);
                    }},
                error: function (data) {
                        console.log(data)
                    }
            });
        }})

    $('#deleteItemBtn').click(function(e){
        //Get name of item to be deleted 
        var itemName = $('#deleteItemBtn').data('name')
        var collectionName = $('#deleteItemBtn').data('collection')

        //Prevent any default event from occurring on button click 
        e.preventDefault();

        //Alert users and confirm delete 
        $('#confirmDeleteMessage').text(
            `Are you sure you want to delete ` + itemName + ` from your collection?`
        )
        $("#confirmItemDelete").modal("show")

        //If users click on delete button, run this code 
        $('#deleteItemConfirmBtn').click(function(e){
            $('#itemListing').modal('hide')

            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: 'deleteItem.php',
                data: { itemName: itemName, collectionName: collectionName},
                success: function (data) {
                    window.location.reload()
                },
                error: function (data) {
                    console.log("An error occurred while deleting item. Please try again and contact website administrators if issue persists.")
                }
            });
        })




    })

    function addItemToCollection(collectionName){
        $('#addItemBtn').click(function (e) {
            var valid = $('#addItem')[0].checkValidity();  
    
            //Checks that form values are valid 
            if (valid) {

                var formData = new FormData(document.getElementById("addItem"));
                formData.append('collectionName', collectionName);

                e.preventDefault();

                //Disables the submit button so user can't accidentally upload many copies 
                $('#addItemBtn').attr("disabled", true);

                $.ajax({
                    url: 'addItem.php',
                    method: 'POST',
                    data: formData,
                    contentType: false, 
                    processData: false, 
                    success: function(data){
                        if(data === "1"){
                            $("#addItemForm").modal('hide');
                            $('#addItem')[0].reset();
                            window.location.reload();
                        }else if(data === "2"){
                            $(".itemYearDiv").prepend(
                                `<p class="wrongInputAlert">Image must be a jpg or png file.</p>`
                            )
                        }else if(data === "3"){
                            $(".itemYearDiv").prepend(
                                `<p class="wrongInputAlert">Image is too large. You must resize before uploading.</p>`
                            )
                        }else{
                            alert(data)
                        }
                    }, 
                    error: function(data){
                        alert("An error occurred while uploading item. Please try again and contact website administrators if issue persists.");
                    }
                });
            }else{
                $(".modal-body").prepend(
                    `<p class="wrongInputAlert">All fields must be filled out to continue.</p>`
                )
            }

        });

    }

    //Displays each collection that the user has created 
    function displayCollection(collectionNames){
        if(collectionNames.length === 0){
            $("#userCollectionsDiv").append(
                `<div class="message">
                    <p> You don't have any collections at this time.<button class="btn btn-link link-text" type="button" data-toggle="modal" data-target="#createCollectionForm">Create Collection</button>to get started! </p>
                </div>            
                `  );
            $("#collectionControls").hide();
            $('#linkMessage').hide();

            $("#shareCollectionPlaceholder").text(
                `No collections to share`
            ); 
        }else{
        collectionNames.forEach(element => {
            $("#userCollectionsDiv").append(
                `<div class="container collectionItemListing mb-3">
                    <div class="float-none row outline pt-3">
                        <div class="col-12 col-md-8">
                            <h3 class="collectionName">` + element + ` Collection</h3>
                            <div class="row">
                                <div class="col-12">
                                    <ul id="` + element.split(" ").join("") + `ItemList">
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="editingBtnDiv text-right">
                                <button id="`+element+`" class="btn btn-sm btn-secondary addItemBtn" type="button" data-toggle="modal"
                                    data-target="#addItemForm">Add New Item</button>
                            </div>
                        </div>
                    </div>
                </div>`);

            $("#collectionToDelete").append(
                `<option>` + element + `</option>`
            ); 

            $("#collectionToSend").append(
                `<option>` + element + `</option>`
            ); 
        });  
    }      
    }

    //Displays the items in each user collection
    function showCollectionItems(collectionItemArray, collectionName){
       //Check if collection has any items 
       if(collectionItemArray.length === 0){
        $("#" + collectionName.split(" ").join("") + "ItemList").append(
            `<li>
            <p> There are no items in the collection at this time. Click "Add Item" to get started.</p>
            </li>`  );
        }else{
            collectionItemArray.forEach(element => {
                $("#" + collectionName.split(" ").join("") + "ItemList").append(
                    `<li>
                        <button class="btn btn-link" type="button" data-toggle="modal"
                                data-target="#itemListing" data-collection="` + collectionName + `" data-name="` + element[0] + `" data-img="` + element[2] + `" data-year="` + element[1] + `" data-description="` + element[3] + `">` + element[0] + `</button>
                    </li>`
                )
            })
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



    $('#itemListing').on('show.bs.modal', function (event){
        var button = $(event.relatedTarget)

        var collectionName = button.data('collection')
        var itemName = button.data('name')
        var itemImgPath = button.data('img')
        var itemYear = button.data('year')
        var itemDescription = button.data('description')

        var modal = $(this)
        modal.find('#modalItemName').text(itemName)
        modal.find('#modalItemImg').attr('src', itemImgPath)
        modal.find('#modalItemYear').text(itemYear)
        modal.find('#modalItemDescription').text(itemDescription)
        modal.find('#deleteItemBtn').attr('data-name', itemName)
        modal.find('#deleteItemBtn').attr('data-collection', collectionName)

        modal.find('#editItemBtn').attr('data-collection', collectionName)
        modal.find('#editItemBtn').attr('data-name', itemName)
        modal.find('#editItemBtn').attr('data-img', itemImgPath)
        modal.find('#editItemBtn').attr('data-year', itemYear)
        modal.find('#editItemBtn').attr('data-description', itemDescription)
    })


    $('#editItemForm').on('show.bs.modal', function (event){
        var button = $(event.relatedTarget)

        var collectionName = button.data('collection')
        var itemName = button.data('name')
        var itemImgPath = button.data('img')
        var itemYear = button.data('year')
        var itemDescription = button.data('description')

        var modal = $(this)
        modal.find('#editItemFormTitle').text('Edit Item - ' + itemName)
        modal.find("#editItemFormTitle").attr("data-item", itemName)
        modal.find('#previousPhoto').attr('src', itemImgPath)

        modal.find('#updatedItemName').attr('value', itemName)     
        modal.find('#updatedItemYear').attr('value',itemYear)
        modal.find('#updatedItemDescription').text(itemDescription)

        modal.find('#submitEditsBtn').attr('data-collection', collectionName)  
        modal.find('#submitEditsBtn').attr('data-img', itemImgPath)       
    })


    $('#contactUsBtn').click(function(e){
        var valid = $('#contactUs')[0].checkValidity();
        if(valid){
            var clientEmail = $('#clientEmail').val()
            var contactMessage = $('#contactMessage').val()
    
            e.preventDefault();
    
            $.ajax({
                type: 'POST',
                url: 'contactUs.php',
                data: {clientEmail: clientEmail, contactMessage: contactMessage},
                success: function (data) {
                    if(data === "1"){
                    $('#contactUs')[0].reset()
                    $('.contactFormSent').text("Thank you for reaching out. We will be in touch soon.")
                    }else{
                        alert(data)
                    }
                },
                error: function (data) {
                    alert("An error occurred while sending your message. Please try again.")
                }
            });
        }
    })

});