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

            if(password.length >= 8 &&  password.match(/[A-z]/) && password.match(/[A-Z]/) && password.match(/\d/)){

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
            }else{
                $('.pswdCheckMessage').text("Password does not fit requirements. Please enter a new password.")
            }
        }
    });

    //Login function 
    $('#loginBtn').click(function (e) {
        var valid = $('#login')[0].checkValidity();

        if (valid) {
            var inputEmail = $('#inputEmail').val();
            var inputPassword = $('#inputPassword').val();
        
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: 'jslogin.php',
            data: { email: inputEmail, password: inputPassword },
            success: function (data) {
                if ($.trim(data) === "1") {
                    window.location.href= "userHomePage.php";
                }else{
                    $(".errorMessage").text(data)
                }
            },
            error: function (data) {
                alert("There were errors while logging in");
            }
        })
    }else{
        $(".errorMessage").text("Please fill out both fields below to continue.")
    }


    });

    //Password info for users 
    $('input[type=password]').keyup(function() {
        var pswd = $(this).val();
        //Validate length 
        if ( pswd.length < 8 ) {
            $('#length').removeClass('valid').addClass('invalid');
        } else {
            $('#length').removeClass('invalid').addClass('valid');
        }

        //Validate letter 
        if ( pswd.match(/[A-z]/) ) {
            $('#letter').removeClass('invalid').addClass('valid');
        } else {
            $('#letter').removeClass('valid').addClass('invalid');
        }

        //validate capital letter
        if ( pswd.match(/[A-Z]/) ) {
            $('#capital').removeClass('invalid').addClass('valid');
        } else {
            $('#capital').removeClass('valid').addClass('invalid');
        }

        //validate number
        if ( pswd.match(/\d/) ) {
            $('#number').removeClass('invalid').addClass('valid');
        } else {
            $('#number').removeClass('valid').addClass('invalid');
        }
    }).focus(function() {
        $('#pswd_info').show();
    }).blur(function() {
        $('#pswd_info').hide();
    });

});
