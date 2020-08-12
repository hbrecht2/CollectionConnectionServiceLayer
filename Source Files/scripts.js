$(function () {
    //Create account function
    $('#createAccountBtn').click(function (e) {
        var valid = $('#createAccount')[0].checkValidity();

        //Checks that form values are valid 
        if (valid) {
            //Gets value of form inputs and sets to respective variables
            var fName = $('#fName').val();
            var lName = $('#lName').val();
            var email = $('#email').val();
            var password = $('#password').val();
        
        //Prevents submission of from prematurely
        e.preventDefault();

        //POST Account Info from form to DB
        $.ajax({
            type: 'POST',
            url: 'process.php',
            data: { fName: fName, lName: lName, email: email, password: password },
            success: function (data) {
                $('#createAccountForm').modal('hide');
                alert("Successfully created your account. Please login to start documenting today!")

            },
            error: function (data) {
                console.log("An error occurred and we could not create your account.")
            }
        });

    }

    });

    //Login function 
    $('#loginBtn').click(function (e) {
        var valid = $('#login')[0].checkValidity();

        if (valid) {
            var inputEmail = $('#inputEmail').val();
            var inputPassword = $('#inputPassword').val();
        }
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: 'jslogin.php',
            data: { email: inputEmail, password: inputPassword },
            success: function (data) {
                if ($.trim(data) === "1") {
                    window.location.href= "userHomePage.php";
                }
            },
            error: function (data) {
                alert("There were errors while logging in");
            }
        })


    });

});
