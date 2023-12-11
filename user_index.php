<?php
// Template Name: User Details Page

// Add other necessary includes or functions here

get_header();

// Display user details
if (is_user_logged_in()) {
    $user = wp_get_current_user();
    ?>

    <style>
        /* Add some custom styles for the table */
        .user-details {
            text-align: center;
            background-color: white;
            padding: 3rem 8rem ;
            margin: 5rem auto;
            max-width: 600px; 
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .user-details-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .user-details-table td, .user-details-table th {
            border: 1px solid #ddd;
            padding: 20px;
        }

        .user-details-table th {
            background-color: #f2f2f2;
        }
    </style>

    <div class="user-details">
        <h2>User Details</h2>
        <br>
        <table class="user-details-table">
            <tr>
                <th>ID</th>
                <td><?php echo $user->ID; ?></td>
            </tr>
            <tr>
                <th>Username</th>
                <td><?php echo $user->user_login; ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?php echo $user->user_email; ?></td>
            </tr>
            <tr>
                <th>Role</th>
                <td><?php echo $user->roles[0]; ?></td>
            </tr>
        </table>
    </div>

    <?php
} else {
    echo '<p>Please log in to view your user details.</p>';
}

get_footer();
?>
