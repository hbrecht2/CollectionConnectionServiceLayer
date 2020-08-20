$(function () {



$('#editAccountBtn').click(function(e){
    var valid = $('#editAccount')[0].checkValidity();

    if(valid){
        var firstName = $('#firstName').val()
        var lastName = $('#lastName').val()
        var email = $('#accountEmail').val()

        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: 'editAccount.php',
            data: { firstName: firstName, lastName: lastName, email: email},
            success: function (data) {
                window.location.reload();
            },
            error: function (data) {
                console.log("An error occurred while deleting collection. Please try again and contact website administrators if issue persists.")
            }
        });
    }
})

$('#changePasswordBtn').click(function(e){
    var valid = $('#changePassword')[0].checkValidity();

    if(valid){

        e.preventDefault();

        var currentPassword = $('#currentPassword').val();
        var newPassword = $('#newPassword').val();
        var confirmNewPassword = $('#confirmNewPassword').val();

        if(newPassword !== confirmNewPassword){
            $('.passwordMessageDiv').html('<p class="wrongInputAlert">Passwords do not match.</p>')
        }else if(newPassword.length < 8 &&  !newPassword.match(/[A-z]/) && !newPassword.match(/[A-Z]/) && !newPassword.match(/\d/)){
            $('.passwordMessageDiv').html('<p class="wrongInputAlert">New password does not meet password criteria.</p>')
        }else{
            $('.wrongInputAlert').hide()
            $.ajax({
                type: 'POST',
                url: 'changePassword.php',
                data:{currentPassword: currentPassword, newPassword: newPassword},
                success: function (data) {
                    if(data === "1"){
                        $('.passwordMessageDiv').html('<p class="wrongInputAlert">An error occurred while changing your password account. Please try again and contact website administrators if issue persists.</p>')
                        $('#changePassword')[0].reset();
                    }else if(data === "2"){
                        $('.incorrectPasswordDiv').html('<p class="wrongInputAlert">Password was incorrect. Please try again.</p>')
                        $('#changePassword')[0].reset();
                    }else if(data === "3"){
                        alert("Successfully changed password.")
                        window.location.reload()
                    }
                },
                error: function (data) {
                    console.log("An error occurred while changing your password. Please try again and contact website administrators if issue persists.")
                }
            });
        }
    }
})

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

$('#deleteAccountBtn').click(function(e){
    var valid = $('#deleteAccountCheck').prop("checked")
    if(valid){
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: 'deleteAccount.php',
            success: function (data) {
                window.location.reload()
            },
            error: function (data) {
                console.log("An error occurred while deleting account. Please try again and contact website administrators if issue persists.")
            }
        });
    }else{
        $('.deleteMessageDiv').html('<p class="wrongInputAlert">You must check box above prior to submitting in order to delete your account.</p>')
    }
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

})