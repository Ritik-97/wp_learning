jQuery(document).ready(function ($) {
    // Register AJAX
    $('#register-submit').on('click', function (e) {
        e.preventDefault(); // Prevent the default form submission behavior

// console.log('hiii')
        // if (hasErrors) {
        //     // If the condition is met, don't proceed with the AJAX call
        //     return;
        // }

        

  // Check if any error messages are present
        var errorMessages = document.querySelectorAll('.error-message');
        // var hasErrors = Array.from(errorMessages).some(function (element) {
        //     return element.textContent.trim() !== '';
        // });



        if (errorMessages.length > 0){
            // console.log('error');
            return 0;
        }


        // setTimeout(()=>{



        $(this).prop('disabled', true);

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
        // },700)

    });
});
