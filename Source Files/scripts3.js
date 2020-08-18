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

})