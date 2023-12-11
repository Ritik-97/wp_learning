

function create_posttype1() {
    register_post_type( 'news',
    // CPT Options
    array(
      'labels' => array(
       'name' => __( 'news' ),
       'singular_name' => __( 'News' )
      ),
      'public' => true,
      'has_archive' => false,
      'rewrite' => array('slug' => 'news'),
     )
    );
    }
    // Hooking up our function to theme setup
    add_action( 'init', 'create_posttype1' );
    function cw_post_type_news() {
        $supports = array(
        'title', // post title
        'editor', // post content
        'author', // post author
        'thumbnail', // featured images
        'excerpt', // post excerpt
        'custom-fields', // custom fields
        'comments', // post comments
        'revisions', // post revisions
        'post-formats', // post formats
        );
        $labels = array(
        'name' => _x('news', 'plural'),
        'singular_name' => _x('news', 'singular'),
        'menu_name' => _x('news', 'admin menu'),
        'name_admin_bar' => _x('news', 'admin bar'),
        'add_new' => _x('Add New', 'add new'),
        'add_new_item' => __('Add New news'),
        'new_item' => __('New news'),
        'taxanomy' => array('news' ),
        'edit_item' => __('Edit news'),
        'view_item' => __('View news'),
        'all_items' => __('All news'),
        'search_items' => __('Search news'),
        'not_found' => __('No news found.'),
        );
        $args = array(
        'supports' => $supports,
        'labels' => $labels,
        'public' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'news'),
        'has_archive' => true,
        'hierarchical' => false,
        );
        register_post_type('news', $args);
        }
        add_action('init', 'cw_post_type_news');






        ******custom registration page******



        <?php
/* Template Name: Custom Registration Page */
get_header();
?>
<style>
    #ajax-register-form {
        /* max-width: 37rem; */
        /* margin: auto;
         */
        justify-content: center;
        display: flex;
        width: 84%;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 8px;
        background-color: #f5f5f5;
    }

    .box{
        display: flex;
    justify-content: space-evenly;
    }

    h3 {
        text-align: center;
        color: #333;
        margin-bottom: 20px;
    }

    form {
        display: flex;
        flex-direction: column;
    }

    label {
        margin-bottom: 8px;
        color: #333;
    }

    input,
    select {
        padding: 10px;
        margin-bottom: 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        width :32rem;
    }

    button {
        padding: 12px;
        background-color: #007BFF;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    button:hover {
        background-color: #0056b3;
    }

    #register-message {
        margin-top: 16px;
        text-align: center;
        color: #333;
    }
</style>
<div id="ajax-register-form">
    
    <form id="register-form">
        <div class="box">
        <label> Enter Username</label>
        <input type="text" id="register-username" placeholder="Username">
        </div><br>
        
        <div class="box">
        <label> Enter Your Email</label>
        <input type="email" id="register-email" placeholder="Email">
        </div><br>
        
        <div class="box">
        <label> Enter Your first name</label>
        <input type="text" id="register-fname" placeholder="Firstname">
        </div><br>


        <div class="box">
        <label> Enter Your Last name</label>
        <input type="text" id="register-lname" placeholder="lastname">
        </div><br>
        
        <div class="box"> 
        <label>Enter your password</label>
        <p>
        <button type="button" onclick="generatePassword()">Generate a password</button><br><br>
        <sup><span id="password-strength">Password Strength: </span></sup><br>
        <input type="password" id="register-password" placeholder="Password" oninput="updatePasswordStrength()" style="width: 25rem;">
        <button type="button" onclick="togglePasswordVisibility()">Show/Hide</button>
        </p>
            </div><br>

        <div>
        <label> Send user notification : </label>
        
        <input type="checkbox" >the new user an email about the account
        
        </div><br>

        <p class="box"><strong>Select Your Role</strong>
         <select id="register-role">
            <option value="">--Option--</option>
            <option value="Shop_manager" > Shop Manager</option>
            <option value="Customer" >Customer</option> 
            <option value="Subscriber" >subscriber</option>
               
        </select></p><br><br>


        <button type="button" id="register-submit" >Sign in </button>
    </form>
    <div id="register-message"></div>
</div>




<script>
    function generatePassword() {
        const lowercaseLetters = 'abcdefghijklmnopqrstuvwxyz';
        const uppercaseLetters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        const digits = '0123456789';
        const specialCharacters = '!@#$%^&*()_+[]{}|;:,.<>?';

        const allCharacters = lowercaseLetters + uppercaseLetters + digits + specialCharacters;

        let password = '';

        // Ensure at least one uppercase letter
        password += getRandomCharacter(uppercaseLetters);

        // Ensure at least one special character
        password += getRandomCharacter(specialCharacters);

        // Ensure at least one digit
        password += getRandomCharacter(digits);

        // Fill the remaining characters
        for (let i = password.length; i < 12; i++) {
            password += getRandomCharacter(allCharacters);
        }

        // Shuffle the password characters
        password = password.split('').sort(() => Math.random() - 0.5).join('');

        // Set the generated password to the input field
        document.getElementById('register-password').value = password;

        // Calculate and display password strength
        updatePasswordStrength();
    }

    function updatePasswordStrength() {
        const password = document.getElementById('register-password').value;
        const strength = calculatePasswordStrength(password);
        document.getElementById('password-strength').innerText = 'Password Strength: ' + strength;
    }

    function calculatePasswordStrength(password) {
        // A more comprehensive password strength calculation
        const regexLower = /[a-z]/;
        const regexUpper = /[A-Z]/;
        const regexDigit = /\d/;
        const regexSpecial = /[!@#$%^&*()_+[\]{}|;:,.<>?]/;

        const lowerExists = regexLower.test(password);
        const upperExists = regexUpper.test(password);
        const digitExists = regexDigit.test(password);
        const specialExists = regexSpecial.test(password);

        const conditionsMet = [lowerExists, upperExists, digitExists, specialExists].filter(Boolean).length;
        const lengthBonus = Math.min(conditionsMet, 3);

        // Assign strength based on conditions met and length
        if (password.length < 8 || conditionsMet < 3) {
            return 'Weak';
        } else if (lengthBonus === 3) {
            return 'Strong';
        } else {
            return 'Moderate';
        }
    }

    function getRandomCharacter(characterSet) {
        const randomIndex = Math.floor(Math.random() * characterSet.length);
        return characterSet.charAt(randomIndex);
    }

    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('register-password');
        passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
    }

    $.post(ajax_auth_object.ajaxurl, data, function (response) {
    console.log('Response:', response);

    var result = JSON.parse(response);
    console.log('Parsed Result:', result);

    $('#register-message').html(result.message);

    if (result.registered) {
        location.reload();
    }
});

</script>
<?php
get_footer();
?>


//function.php///


// registration with ajax
function enqueue_ajax_auth_scripts() {
    wp_enqueue_script('jquery'); // Include jQuery
    wp_enqueue_script('ajax-auth-script', get_stylesheet_directory_uri() . '/ajax-auth.js', array('jquery'), null, true);
    wp_localize_script('ajax-auth-script', 'ajax_auth_object', array(
        // 'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('ajax-auth-nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_ajax_auth_scripts');




function ajax_register() {
    check_ajax_referer('ajax-auth-nonce', 'security');
    
    // Log received data to debug
    error_log(print_r($_POST, true));

    $username = $_POST['username'];
    $email = $_POST['email'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $user_data = array(
        'user_login' => $username,
        'user_email' => $email,
        'user_pass' => $password,
        'user_fname' => $firstname,
        'user_lname' => $lastname,
        'user_role' => $role,
    );

    $user_id = wp_insert_user($user_data);

    if (is_wp_error($user_id)) {
        echo json_encode(array('registered' => false, 'message' => $user_id->get_error_message()));
    } else {
        echo json_encode(array('registered' => true, 'message' => 'Registration successful.'));
    }

    exit; // Add this exit statement
}


add_action('wp_ajax_nopriv_ajax_register', 'ajax_register');

?>


///ajax-auth.php
jQuery(document).ready(function ($) {
    // Register AJAX
    $('#register-submit').on('click', function (e) {
        e.preventDefault(); // Prevent the default form submission behavior

        var data = {
            action: 'ajax_register',
            security: ajax_auth_object.nonce,
            username: $('#register-username').val(),
            email: $('#register-email').val(),
            firstname: $('#register-fname').val(),
            lastname: $('#register-lname').val(),
            password: $('#register-password').val(),
            role: $('#register-role').val(),
        };

        $.post(ajax_auth_object.ajaxurl, data, function (response) {
            console.log(response);
            var result = JSON.parse(response);
            console.log(result);
            $('#register-message').html(result.message);

            if (result.registered) {
                location.reload();
            }
        });
    });
});





*********JSON error*******
jQuery(document).ready(function ($) {
    // Register AJAX
    $('#register-submit').on('click', function (e) {
        e.preventDefault(); // Prevent the default form submission behavior

        var data = {
            action: 'ajax_register',
            security: ajax_auth_object.nonce,
            username: $('#register-username').val(),
            email: $('#register-email').val(),
            firstname: $('#register-fname').val(),
            lastname: $('#register-lname').val(),
            password: $('#register-password').val(),
            role: $('#register-role').val(),
        };

        $.post(ajax_auth_object.ajaxurl, data, function (response) {
            console.log(response);
            var result = JSON.parse(response);
            console.log(result);
            $('#register-message').html(result.message);

            if (result.registered) {
                location.reload();
            }
        });
    });
});


*******without error*********8
jQuery(document).ready(function ($) {
    // Register AJAX
    $('#register-submit').on('click', function (e) {
        e.preventDefault(); // Prevent the default form submission behavior

        var data = {
            action: 'ajax_register',
            security: ajax_auth_object.nonce,
            username: $('#register-username').val(),
            email: $('#register-email').val(),
            firstname: $('#register-fname').val(),
            lastname: $('#register-lname').val(),
            password: $('#register-password').val(),
            role: $('#register-role').val(),
        };

        $.post(ajax_auth_object.ajaxurl, data, function (response) {
            console.log(response); // Log the raw response

            // Display the message in #register-message
            $('#register-message').html(response.message);

            // Check if registered successfully
            if (response.registered) {
                // Optionally, you can redirect or perform other actions here
                location.reload();
            }
        }).fail(function (xhr, status, error) {
            // Log and display an error message if the request fails
            console.error(error);
            $('#register-message').html('An error occurred while processing your request.');
        });
    });
});
