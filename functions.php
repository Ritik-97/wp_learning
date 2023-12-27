<?php

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




function redirect_wp_admin(){
global $pagenow;
if ($pagenow == "wp-login.php" && $_GET['action']!=="logout"){
    wp_redirect(site_url()."/login");
    exit();
}
}

add_action( 'init', 'redirect_wp_admin');


include_once get_stylesheet_directory() . '/src/js/ajax-custom-functions.php';





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





function enqueue_child_scripts() {

    // this is for generate password and register form validation
    wp_enqueue_script('child-custom-script', get_stylesheet_directory_uri() . '/src/js/script.js', array('jquery'), '1.0', true);
       
       // this is for custom styles
        wp_enqueue_style('custom-style', get_stylesheet_directory_uri() . '/src/css/custom_style.css', array(), '1.0', 'all');
        
        // this is for custom login validation
        wp_enqueue_script('child-custom-script-login', get_stylesheet_directory_uri() . '/src/js/login-script.js', array('jquery'), '1.0', true);


}

add_action('wp_enqueue_scripts', 'enqueue_child_scripts');


?>

