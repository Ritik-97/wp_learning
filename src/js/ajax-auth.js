


jQuery(document).ready(function ($) {
    // Register AJAX
    $('#register-submit').on('click', function (e) {
        e.preventDefault(); // Prevent the default form submission behavior

        // Disable the button to prevent multiple clicks
        $(this).prop('disabled', true);

        // Show the loader within the button
        $(this).html('<span id="loadergif" style="display: inline-block; vertical-align: middle;"><img src="https://ritik.devwork.in/wp-content/uploads/2023/12/loader.gif" style="width: 20px; height: 20px;"></span> Signing in');

        var errorMessages = document.querySelectorAll('.error-message');
        var error_username = document.getElementById('error-username').innerText;
        var error_email = document.getElementById('error-email').innerText;
        var error_firstname = document.getElementById('error-firstname').innerText;
        var error_lastname = document.getElementById('error-lastname').innerText;
        var error_user_role = document.getElementById('error-user-role').innerText;
        var error_password = document.getElementById('error-password').innerText;

        if (error_username !== '' || error_firstname !== '' || error_lastname !== '' || error_user_role !== '' || error_email !== '' || error_password !== '') {
            console.log('errors');

            // Hide the loader within the button
            $('#register-submit').html('Sign in');
            $(this).prop('disabled', false);

            return 0;
        }

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

        $.post(ajax_auth_object.ajaxurl, data, function (response) {
            console.log(response);

            // Enable the button after the registration process is complete
            $('#register-submit').prop('disabled', false);

            // Hide the loader within the button
            $('#register-submit').html('Sign in');

            // Display the message in #register-message
            $('#register-message').html(response.message);

            // Check if registered successfully
            if (response.registered) {
                // Optionally, you can redirect or perform other actions here
                // window.location.href = "https://ritik.devwork.in";
                window.location.href = "https://ritik.devwork.in/user-details";

            }
        }).fail(function (xhr, status, error) {
            // Log and display an error message if the request fails
            console.error(error);
            $('#register-message').html('An error occurred while processing your request.');

            // Enable the button after the registration process is complete
            $('#register-submit').prop('disabled', false);

            // Hide the loader within the button
            $('#register-submit').html('Sign in');
        });
    });
});

