<?php
// Enqueue jQuery and your script register and generate password callback
function enqueue_ajax_auth_scripts() {
    wp_enqueue_script('jquery');
    wp_enqueue_script('ajax-auth-script', get_stylesheet_directory_uri() . '/src/js/ajax-auth.js', array('jquery'), null, true);
    wp_localize_script('ajax-auth-script', 'ajax_auth_object', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('ajax-auth-nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_ajax_auth_scripts');

// Handle user registration and login
function ajax_register() {
    check_ajax_referer('ajax-auth-nonce', 'security');

    $username = ($_POST['username']);
    $email = ($_POST['email']);
    $firstname = ($_POST['first_name']);
    $lastname = ($_POST['last_name']);
    $password = ($_POST['password']); // Sanitize password
    $selected_role = ($_POST['role']); // Use 'user_role' instead of 'role'

    // Validate and sanitize the selected role
    $allowed_roles = array('moderator', 'customer', 'subscriber', 'administrator');
    $user_role = in_array($selected_role, $allowed_roles) ? $selected_role : 'moderator';

    // Get the capabilities associated with the selected role
    $role_capabilities = get_role($user_role)->capabilities;

   $user_data = array(
    'user_login' => $username,
    'user_email' => $email,
    'user_pass' => $password,
    'first_name' => $firstname,
    'last_name' => $lastname,
    'role' => $user_role,
);

// Insert the user
$user_id = wp_insert_user($user_data);

if (is_wp_error($user_id)) {
    echo json_encode(array('registered' => false, 'message' => $user_id->get_error_message()));
} else {
    // Update user meta
    update_user_meta($user_id, 'first_name', $firstname);
    update_user_meta($user_id, 'last_name', $lastname);

    // Sign the user in after registration
    $creds = array(
        'user_login'    => $username,
        'user_password' => $password,
        'remember'      => true,
    );

    $user = wp_signon($creds, false);

    if (is_wp_error($user)) {
        echo json_encode(array('registered' => true, 'message' => 'Registration successful, but login failed.'));
    } else {
        echo json_encode(array('registered' => true, 'message' => 'Registration and login successful.'));
    }
}

    header('Content-Type: application/json');
    exit;
}

add_action('wp_ajax_nopriv_ajax_register', 'ajax_register');
add_action('wp_ajax_ajax_register', 'ajax_register');

// Callback function to generate a password
function generate_password_callback() {
    $generated_password = wp_generate_password();

    wp_send_json_success($generated_password);
    
    wp_die();
}
add_action('wp_ajax_generate_password', 'generate_password_callback');
add_action('wp_ajax_nopriv_generate_password', 'generate_password_callback');




// update user function

function enqueue_jquery() {
    wp_enqueue_script('jquery');
}
add_action('wp_enqueue_scripts', 'enqueue_jquery');



// This is updating user_nicename and email not login_user but remains logged in 

add_action('wp_ajax_update_user_details', 'update_user_details');
add_action('wp_ajax_nopriv_update_user_details', 'update_user_details');

function update_user_details() {
    // Verify nonce
    $nonce = $_POST['nonce'];
    if (!wp_verify_nonce($nonce, 'update_user_details_nonce')) {
        echo json_encode(array('status' => 'error', 'message' => 'Nonce verification failed.'));
        wp_die();
    }

    // Check if user is logged in
    if (!is_user_logged_in()) {
        echo json_encode(array('status' => 'error', 'message' => 'User not logged in.'));
        wp_die();
    }

    // Get current user ID
    $user_id = get_current_user_id();

    // Sanitize and get form data
    $email = sanitize_email($_POST['editUserEmail']); // Sanitize email
    $user_nicename = sanitize_user($_POST['editNiceName']); // Sanitize username
    $password = sanitize_text_field($_POST['editUserPassword']); // Sanitize password

    // Get the user data
    $user_data = get_userdata($user_id);

    // Update user_email and password using wp_update_user
    $updated_user_data = array(
        'ID'         => $user_id,
        'user_email' => $email,
        'user_nicename' => $user_nicename,
    );

    if (!empty($password)) {
        $updated_user_data['user_pass'] = $password;
    }

    wp_update_user($updated_user_data);

    

   
    // Get updated user data
    $updated_user = get_user_by('ID', $user_id);

    echo json_encode(array('status' => 'success', 'message' => 'User details updated successfully.', 'user' => $updated_user));
    wp_die();
}



// custom-functions



// Add custom content to the footer
add_action('wp_footer', 'my_custom_function');
function my_custom_function() {
    echo "This is my custom content in the footer.";
}


// Add custom stylesheet link to the login page
function childtheme_custom_login() {
    echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('stylesheet_directory') .'/style.css" />';
}
add_action('login_head', 'childtheme_custom_login');



function wpb_login_logo() { ?>
    <style type="text/css">
    #login h1 a, .login h1 a {
    background-image: url(https://cdn.logo.com/hotlink-ok/logo-social.png);
    /* height:400px; */
    /* width:400px; */
    background-size: 200px 50px;
    background-repeat: no-repeat;
    padding-bottom: 20px;
    }
    </style>
    <?php }
add_action( 'login_enqueue_scripts', 'wpb_login_logo' );
       
function my_custom_form () {
    ?>
    <form method="post">
    <label for="Title">Title :</label><br>
    <input type="text" id="Title" name="title"><br>
    <label for="content">Content:</label><br>
    <textarea id="content" name="content" rows="4" cols="50"></textarea>  <br>
      <input type="submit" style="margin :2rem" name="submitform"  value="Submit"> 

  </form>
<?php


}
add_shortcode('custom_form', 'my_custom_form');



function mycustom_wp_footer() {
    ?>
<script type="text/javascript">
    document.addEventListener( 'wpcf7mailsent', function( event ) {
        ga( 'send', 'event', 'Contact Form', 'submit' );
    }, false );
</script>
<?php
}
add_action( 'wp_footer', 'mycustom_wp_footer' );


function redirect_to_custom_login() {
wp_redirect(site_url() ."/login");
exit();
}
add_action( 'wp_logout', 'redirect_to_custom_login');



// function to add roles
    add_role('moderator', 'Moderator', array(
        'read' => true,
        'create_posts' => true,
        'edit_posts' => true,
        'edit_others_posts' => true,
        'publish_posts' => true,
        'manage_categories' => true,
        ));

    add_role('customer', 'Customer', array(
        'read' => true,
        'create_posts' => false,
        'edit_posts' => false,
        'edit_others_posts' => false,
        'publish_posts' => false,
        'manage_categories' => false,
        ));
    
    
    add_role('subscriber', 'Subscriber', array(
        'read' => true,
        'create_posts' => true,
        'edit_posts' => true,
        'edit_others_posts' => false,
        'publish_posts' => true,
        'manage_categories' => false,
        ));
   


     // delete user roles

    remove_role('custom_administrator');
    remove_role('author');
    remove_role('contributor');
    remove_role('author');
    remove_role('editor');
    remove_role('shop_manager');
    remove_role('admin');
    
// end delete user roles





?>