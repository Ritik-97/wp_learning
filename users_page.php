<?php
/*
Template Name: Users Page
*/

get_header();
?>
<head>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
</head>

<?php

if (current_user_can('administrator')) {
    echo '<div class="wrap">';
    echo '<h2 style="display: flex; flex-direction: column; align-items: center; margin: 25px auto;">List of Users with Roles</h2>';

    $args = array(
        'fields' => array('ID', 'user_login', 'user_nicename', 'user_email', 'display_name'),
    );

    $users = get_users($args);

    if ($users) {
        echo '<table id="usersTable" class="wp-list-table widefat fixed striped">';
        echo '<thead><tr><th>ID</th><th>Username</th><th>Nicename</th><th>Email</th><th>Display Name</th><th>User Roles</th></tr></thead>';
        echo '<tbody>';

        foreach ($users as $user) {
            $user_data = get_userdata($user->ID);
            $user_roles = $user_data->roles;
            $user_roles_string = implode(', ', $user_roles);

            echo '<tr>';
            echo '<td>' . $user->ID . '</td>';
            echo '<td>' . $user->user_login . '</td>';
            echo '<td>' . $user->user_nicename . '</td>';
            echo '<td>' . $user->user_email . '</td>';
            echo '<td>' . $user->display_name . '</td>';
            echo '<td>' . $user_roles_string . '</td>';
            echo '</tr>';
        }

        echo '</tbody></table>';

        // Initialize DataTable
        echo '<script>
            jQuery(document).ready(function() {
                jQuery("#usersTable").DataTable();
            });
        </script>';
    } else {
        echo '<p>No data found.</p>';
    }

    echo '</div>';
} else {
    // Display a message if the user doesn't have the required permissions
    echo '<p>You do not have permission to view this content.</p>';
}

get_footer();
?>
