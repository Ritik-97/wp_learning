<?php
// Add custom JavaScript to the header
// add_action('wp_head', 'show_alert');
// function show_alert() {
//     echo '<script>alert("Hello World");</script>';
// }

// Add custom content to the footer
add_action('wp_footer', 'my_custom_function');
function my_custom_function() {
    echo "This is my custom content in the footer.";
}

// Redirect users from the 'products' page if not logged in
// add_action('template_redirect', 'check_user_logged_in');
// function check_user_logged_in() {
//     if (is_page('products')&& !is_user_logged_in()) {
//         wp_redirect(home_url(), 307);
//         exit;
//     }
// }


// Add custom stylesheet link to the login page
function childtheme_custom_login() {
    echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('stylesheet_directory') .'/style.css" />';
}
add_action('login_head', 'childtheme_custom_login');

// Register a custom post type 'Cakes'



function create_posttype() {
    register_post_type('cakes', array(
        'labels' => array(
            'name' => __('Cakes'),
            'singular_name' => __('Cake'),
        ),
        'public' => true,
        'has_archive' => false,
        // 'taxonomies' => array('category', 'post_tag'),
        'rewrite' => array('slug' => 'cakes'),
        
    ));
}
add_action('init', 'create_posttype');

function cw_post_type_Cakes() {
    
    register_taxonomy( 
        'cake_tag', //taxonomy 
        'cakes', //post-type
        array( 
            'hierarchical'  => false, 
            'label'         => __( 'Cake Tags','taxonomy general name'), 
            'singular_name' => __( 'Cake Tag', 'taxonomy general name' ), 
            'rewrite'       => true, 
            'query_var'     => true 
        ));

       
    //register custom posts type
    register_taxonomy( 
        'cake_category', //taxonomy 
        'cakes', //post-type
        array( 
            'hierarchical'  => true, 
            'label'         => __( 'Cake Categories','taxonomy general name'), 
            'singular_name' => __( 'Cake Category', 'taxonomy general name' ), 
            'rewrite'       => true, 
            'query_var'     => true 
        ));

    
    $supports = array(
        'title', 
        'editor',
        'author', 
        'thumbnail', 
        'excerpt', 
        'custom-fields', 
        'comments', 
        'revisions', 
        'post-formats', 
    );
    $labels = array(
        'name' => _x('Cakes', 'plural'),
        'singular_name' => _x('Cake', 'singular'),
        'menu_name' => _x('Cakes', 'admin menu'),
        'name_admin_bar' => _x('Cakes', 'admin bar'),
        'add_new' => _x('Add New', 'add new'),
        'add_new_item' => __('Add New Cake'),
        'new_item' => __('New Cake'),
        'edit_item' => __('Edit Cake'),
        'view_item' => __('View Cake'),
        'all_items' => __('All Cakes'),
        'search_items' => __('Search Cakes'),
        'not_found' => __('No Cakes found.'),
    );
    $args = array(
        'supports' => $supports,
        'labels' => $labels,
        'public' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'cakes'),
        'has_archive' => true,
        'hierarchical' => false,
    );
    register_post_type('cakes', $args);
}
add_action('init', 'cw_post_type_Cakes');


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




add_action( 'init', 'redirect_wp_admin');

function redirect_wp_admin(){
global $pagenow;
if ($pagenow == "wp-login.php" && $_GET['action']!=="logout"){
    wp_redirect(site_url()."/login");
    exit();
}
}

// Enqueue jQuery and your script
function enqueue_ajax_auth_scripts() {
    wp_enqueue_script('jquery');
    wp_enqueue_script('ajax-auth-script', get_stylesheet_directory_uri() . '/ajax-auth.js', array('jquery'), null, true);
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
        // echo json_encode (['role'=>$selected_role, 'password'=>$password ,'username'=>$username]);

        // die();

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


    
    // user roles page 

    function custom_page_content_with_roles() {
        // global $wpdb;
    
        // echo '<div class="wrap">';
        // echo '<h2 style="display: flex; flex-direction: column; align-items: center; margin: 25px auto;">List of Users with Roles</h2>';
    
        // $results = $wpdb->get_results("
        //     SELECT u.ID, u.user_login, u.user_nicename, u.user_email, u.display_name, GROUP_CONCAT(um.meta_value) as user_roles
        //     FROM {$wpdb->prefix}users u
        //     LEFT JOIN {$wpdb->prefix}usermeta um ON u.ID = um.user_id AND um.meta_key = '{$wpdb->prefix}capabilities'
        //     GROUP BY u.ID
        // ");
    
        // if ($results) {
        //     echo '<table class="wp-list-table widefat fixed striped">';
        //     echo '<thead><tr><th>ID</th><th>Login</th><th>Nicename</th><th>Email</th><th>Display Name</th><th>User Roles</th></tr></thead>';
        //     echo '<tbody>';
    
        //     foreach ($results as $result) {
        //         echo '<tr>';
        //         echo '<td>' . $result->ID . '</td>';
        //         echo '<td>' . $result->user_login . '</td>';
        //         echo '<td>' . $result->user_nicename . '</td>';
        //         echo '<td>' . $result->user_email . '</td>';
        //         echo '<td>' . $result->display_name . '</td>';
        //         echo '<td>' . get_user_role_value($result->user_roles) . '</td>';
        //         echo '</tr>';
        //     }
    
        //     echo '</tbody></table>';
        // } else {
        //     echo '<p>No data found.</p>';
        // }
    
        // echo '</div>';
    }
    
    function get_user_role_value($user_roles) {
        if (strpos($user_roles, 'administrator') !== false) {
            return "Administrator";
        } elseif (strpos($user_roles, 'subscriber') !== false) {
            return "Subscriber";
        } elseif (strpos($user_roles, 'moderator') !== false) {
            return "Moderator";
        }elseif (strpos($user_roles, 'customer') !== false) {
            return "Customer";
        }
    
        return -1; // Or any other default value.
    }
        




//  function for custom  menu acc to user roles  //

    function customize_menu_items($items, $args) {
    global $current_user;
    wp_get_current_user();

    $new_items = array();

    switch (true) {
        case (user_can($current_user, "administrator")):
            $new_items = wp_get_nav_menu_items('admin-menu');
            break;
        case (user_can($current_user, "customer")):
            $new_items = wp_get_nav_menu_items('guest-menu');
            break;
        case (user_can($current_user, "subscriber")):
            $new_items = wp_get_nav_menu_items('guest-menu');
            break;
        case (user_can($current_user, "moderator")):
            $new_items = wp_get_nav_menu_items('guest-menu');
            break;
        default:
            $new_items = wp_get_nav_menu_items('primary-menu');
            break;
    }

    // Clear existing menu items
    $items = array();

    // Merge the new items with the cleared items
    $items = array_merge($items, $new_items);

    return $items;
}

add_filter('wp_nav_menu_objects', 'customize_menu_items', 10, 2);



// function enqueue_jquery() {
//     wp_enqueue_script('jquery');
// }
// add_action('wp_enqueue_scripts', 'enqueue_jquery');


// // //script to update user details
// // // Add this code to your theme's functions.php file or in a custom plugin
// add_action('wp_ajax_update_user_details', 'update_user_details');
// add_action('wp_ajax_nopriv_update_user_details', 'update_user_details');

// function update_user_details() {
//     // Verify nonce
//     $nonce = $_POST['nonce'];
//     if (!wp_verify_nonce($nonce, 'update_user_details_nonce')) {
//         echo json_encode(array('status' => 'error', 'message' => 'Nonce verification failed.'));
//         wp_die();
//     }

//     // Check if user is logged in
//     if (!is_user_logged_in()) {
//         echo json_encode(array('status' => 'error', 'message' => 'User not logged in.'));
//         wp_die();
//     }

//     // Get current user ID
//     $user_id = get_current_user_id();

//     // Sanitize and get form data
//     $email = sanitize_email($_POST['editUserEmail']);
//     $user_login = sanitize_text_field($_POST['editUserName']);
//     $password = sanitize_text_field($_POST['editUserPassword']);

//     // Update email and display name
//     $update_data = array(
//         'ID'           => $user_id,
//         'user_email'   => $email,
//         'user_login'   => $user_login,
//     );

//     $dataupdate = wp_update_user($update_data);

//     // Update password if provided
//     if (!empty($password)) {
//         wp_set_password($password, $user_id);
//     }

//     if (is_wp_error($dataupdate)) {
//         echo json_encode(array('status' => 'error', 'message' => $dataupdate->get_error_message()));
//         wp_die();
//     } else {
//         // Get updated user data
//         $updated_user = get_user_by('ID', $user_id);

//         echo json_encode(array('status' => 'success', 'message' => 'User details updated successfully.', 'user' => $updated_user));
//         wp_die();
//     }
// }



?>
