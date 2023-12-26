

        jQuery(document).ready(function ($) {
            $('#submit').click(function () {
                var username = $('#username').val();
                var password = $('#password').val();

                // Clear previous error messages
                $('.error-message').remove();

                // If there are no validation errors, proceed with AJAX
                if (!username || !password) {
                    // Validation for username and password
                    if (!username) {
                        $('#username').after('<p class="error-message" style="color: red;">Please enter a username/email.</p>');
                    }

                    if (!password) {
                        $('#password').after('<p class="error-message" style="color: red;">Please enter a password.</p>');
                    }

                    return; // Stop further processing if there are validation errors
                }

                // Disable the button and show loading indicator
                var $submitButton = $('#submit');
                $submitButton.prop('disabled', true).html('<img src="https://ritik.devwork.in/wp-content/uploads/2023/12/loader.gif" alt="Loading..." style="width: 20px; height: 20px; margin-right: 5px;"> Logging in...');

                $.ajax({
                    type: 'POST',
                    url: window.location.href,
                    data: {
                        'username': username,
                        'password': password,
                        'btn_submit': true
                    },
                    success: function (response) {
                        // Handle the response
                        console.log(response);

                        if (response.includes('Invalid login credentials')) {
                            $('#form').append('<p class="error-message" style="color: red; text-align: center;">Invalid login credentials</p>');
                        } else {
                            window.location.href = "https://ritik.devwork.in/user-details/";
                            // window.location.href = "https://ritik.devwork.in/wp-admin/profile.php/";
                        }
                    },
                    error: function (error) {
                        // Handle errors
                        console.log(error);
                    },
                    complete: function () {
                        // Enable the button and hide loading indicator after processing
                        $submitButton.prop('disabled', false).html('Log in');
                    }
                });
            });
        });