jQuery(document).ready(function ($) {
    // Register AJAX
    $('#register-submit').on('click', function (e) {
        e.preventDefault(); // Prevent the default form submission behavior

        // Disable the button to prevent multiple clicks
        // $(this).prop('disabled', true);
        
        var errorMessages = document.querySelectorAll('.error-message');

var error_username = document.getElementById('error-username').innerText;
var error_email = document.getElementById('error-email').innerText;
var error_firstname = document.getElementById('error-firstname').innerText;
var error_lastname = document.getElementById('error-lastname').innerText;
var error_user_role = document.getElementById('error-user-role').innerText;
var error_pasword = document.getElementById('error-password').innerText;


if(error_username != '' || error_firstname != ''|| error_lastname != ''|| error_user_role != ''||error_email != ''|| error_pasword!= ''){
    console.log('errros');
    return 0;
}

// console.log(errorMessages)
//         if (errorMessages.length > 0) {
//             console.log(errorMessages.length)
//             // If there are error messages, do not proceed with the AJAX call
//             return ;
//         }


        // Show a loader
        $('#loader').attr("src", "https://ritik.devwork.in/wp-content/uploads/2023/12/loader.gif");
        $('#loader').show();

        var data = {
            action: 'ajax_register',
            security: ajax_auth_object.nonce,
            username: $('#register-username').val(),
            email: $('#register-email').val(),
            first_name: $('#first_name').val(),
            last_name: $('#last_name').val(),
            password: $('#register-password').val(),
            role: $('#user_role').val(),
        };

            // console.log($('#register-password').val());
            // console.log($('#register-email').val());
            // console.log($('#first_name').val());
            // console.log($('#last_name').val());
            // console.log($('#user_role').val());
            // return 0;
        $.post(ajax_auth_object.ajaxurl, data, function (response) {
            console.log(response);

            // Hide the loader
            $('#loader').hide();

            // Enable the button after the registration process is complete
            $('#register-submit').prop('disabled', false);

            // Display the message in #register-message
            $('#register-message').html(response.message);

            // Check if registered successfully
            if (response.registered) {
                // Optionally, you can redirect or perform other actions here
                // window.location.href = "https://ritik.devwork.in"; // Redirect to the site URL
                                window.location.href = "https://ritik.devwork.in/user-details";

            }
        }).fail(function (xhr, status, error) {
            // Log and display an error message if the request fails
            console.error(error);
            $('#register-message').html('An error occurred while processing your request.');

            // Hide the loader
            $('#loader').hide();

            // Enable the button after the registration process is complete
            $('#register-submit').prop('disabled', false);
        });
    });
});
