$(function () {

    
    //Loads the user's collections when the page loads 
    loadUserCollections();

    
    function loadUserCollections(){
        $.ajax({
            type: 'GET',
            url: 'getUserCollections.php',
            success: function(data){
                console.log(data);
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
            //Gets value of form inputs and sets to respective variables
            var collectionName = $('#collectionName').val();
        
            //Prevents submission of from prematurely
            e.preventDefault();

            //POST Account Info from form to DB
            $.ajax({
                type: 'POST',
                url: 'createCollection.php',
                data: { collectionName: collectionName },
                success: function (data) {
                    $("#createCollectionForm").modal('hide');
                    console.log(data);
                    displayCollection();
                },
                error: function (data) {
                    console.log("An error occurred and we could not create your collection")
                }
            });
        }
    });



    function displayCollection(){
        alert("hello");
    }



    
});