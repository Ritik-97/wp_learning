<div id="navbar" class="navbar">
    <?php
    global $current_user;
    wp_get_current_user();

    $nav_menu_items = array();

    switch (true) {
        case ( user_can( $current_user, "administrator") ):
            $nav_menu_items = wp_get_nav_menu_items('admin-menu');
            break;
        case ( user_can( $current_user, "customer") ):
            $nav_menu_items = wp_get_nav_menu_items('guest-menu');
            break;
        default:
            $nav_menu_items = wp_get_nav_menu_items('primary-menu');
            break;
    }

    // Output the custom menu items
    if (!empty($nav_menu_items)) {
        echo '<ul>';
        foreach ($nav_menu_items as $item) {
            echo '<li><a href="' . esc_url($item->url) . '">' . esc_html($item->title) . '</a></li>';
        }
        echo '</ul>';
    }
    ?>
</div>

