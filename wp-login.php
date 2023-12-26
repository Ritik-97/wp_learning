<?php
/* Template Name: Custom Login Page */

$User_ID = get_current_user_id();
$error_messages = array(
    'username' => '',
    'password' => '',
    'general' => '',
);

if (!$User_ID) {

    if (isset($_POST['btn_submit'])) {
        $username = sanitize_user($_POST['username']);
        $password = sanitize_text_field($_POST['password']);


        // Validation for username
        if (empty($username)) {
            $error_messages['username'] = 'Please enter a username/email.';
        }

        // Validation for password
        if (empty($password)) {
            $error_messages['password'] = 'Please enter a password.';
        }

        // If there are no validation errors, proceed with login
        if (empty($error_messages['username']) && empty($error_messages['password'])) {
            $login_array = array();
            $login_array['user_login'] = $username;
            $login_array['user_password'] = $password;

            // Your existing PHP logic remains here
            $verify_user = wp_signon($login_array, false);

            if (!is_wp_error($verify_user)) {
                wp_set_auth_cookie($verify_user->ID, false, is_ssl());
                echo '<script> window.location.href = "https://ritik.devwork.in/user-details/"</script>';
                exit;
            } else {
                $error_messages['general'] = 'Invalid login credentials';
            }
        }
    }

    get_header();
    ?>

    <div class="form-container" style="justify-content: center; margin-top: 0 auto; margin: 5rem auto;">

        <form method="post" id="form" style="width: 100%; background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
            <div><h2 style="text-align: center; margin-bottom: 20px;">Login</h2></div>

            <label style="font-size: 16px; margin-bottom: 8px; color: #333;">Enter Username/Email</label>
            <div style="margin-bottom: 15px;">
                <input type="text" id="username" name="username" placeholder="Enter Username/Email" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" >
                <?php
                if (!empty($error_messages['username'])) {
                    echo '<p class="error-message">' . $error_messages['username'] . '</p>';
                }
                ?>
            </div>

            <label style="font-size: 16px; margin-bottom: 8px; color: #333;">Enter Password</label>
            <div style="margin-bottom: 15px;">
                <input type="password" id="password" name="password" placeholder="Enter Password" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; " >
                <?php
                if (!empty($error_messages['password'])) {
                    echo '<p class="error-message">' . $error_messages['password'] . '</p>';
                }
                ?>
            </div>

   
    <div id="button-container" style="margin-bottom: 15px;">
        <button type="button" id="submit" name="btn_submit" style="width: 100%; padding: 10px; background-color: #4CAF50; color: #fff; border: none; border-radius: 4px; cursor: pointer;">
            Log in
        </button>
        <img id="loader" src="https://ritik.devwork.in/wp-content/uploads/2023/12/loader.gif" alt="Loading..." style="display: none; width: 20px; height: 20px; margin-right: 5px; margin-top: 10px;">

    <?php
    if (!empty($error_messages['general'])) {
        echo '<p class="error-message" style="color: red; text-align: center;">' . $error_messages['general'] . '</p>';
    }
    ?>
</div>




            <h4 style="margin-top: 20px; text-align: center; color: #333;">Don't have an account? <a href="<?php echo home_url() . '/registration-page' ?>" style="color: #4CAF50;">Sign up</a></h4>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

   

    <?php
    get_footer();
} else {
    echo "YOU ARE ALREADY SIGNED IN. PLEASE GO BACK!";
}
?>
