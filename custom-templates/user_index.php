<?php
// Template Name: User Details Page


get_header();

    // $user = wp_get_current_user();
    // print_r($user);

// Display user details
if (is_user_logged_in()) {
    $user = wp_get_current_user();
        $nonce = wp_create_nonce('update_user_details_nonce');

    ?>


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
                <th>Nicename</th>
                <td><?php echo $user->user_nicename; ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?php echo $user->user_email; ?></td>
            </tr>
            <tr>
                <th>Role</th>
                <td><?php echo $user->roles[0]; ?></td>
            </tr>        </table>

        <button class="edit-user-btn" onclick="openEditUserModal()">Edit User Details</button>
    </div>

    <!-- Modal -->
    <div id="editUserModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditUserModal()">&times;</span>
            <h2>Edit User Details</h2>
            <form id="editUserForm">
                <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('update_user_details_nonce'); ?>">

                <label for="editUserEmail">Email:</label>
                <input type="email" id="editUserEmail" name="editUserEmail" value="<?php echo $user->user_email; ?>">

             <!--<label for="editUserName">User Name:</label>
                <input type="text" id="editUserName" name="editUserName" value="<?php echo $user->user_login; ?>"> -->
            
                <label for="editNiceName">Nicename:</label>
                <input type="text" id="editNiceName" name="editNiceName" value="<?php echo $user->user_nicename; ?>">


                <label for="editUserPassword">New Password:</label>
                <input type="password" id="editUserPassword" name="editUserPassword">

                <input type="submit" value="Update" id="updateUserBtn">
            </form>
        </div>
    </div>
<script>
        // Modal functions
        function openEditUserModal() {
            document.getElementById('editUserModal').style.display = 'block';
        }

        function closeEditUserModal() {
            document.getElementById('editUserModal').style.display = 'none';
        }

        // AJAX for form submission
document.getElementById('editUserForm').addEventListener('submit', function (event) {
    var updateBtn = document.getElementById('updateUserBtn');
    updateBtn.disabled=true;
    console.log(updateBtn);
    event.preventDefault();
    var formData = new FormData(this);

    // Add any additional data you want to send
    formData.append('action', 'update_user_details');
    formData.append('userId', <?php echo $user->ID; ?>);
    formData.append('nonce', '<?php echo $nonce; ?>');

    // AJAX request
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '<?php echo admin_url('admin-ajax.php'); ?>', true);

    xhr.onload = function () {
        if (xhr.status === 200) {
             updateBtn.disabled=false;
                console.log(updateBtn);
            var response = JSON.parse(xhr.responseText);

            if (response.status === 'success') {
                // Update page content with new user details

                document.getElementById('editUserEmail').value = response.user.user_email;
                document.getElementById('editNiceName').value = response.user.user_nicename;

                // Optionally, you can display a success message
                alert('User details updated successfully.');

                // Close the modal
                closeEditUserModal();

                // Reload the page to reflect the updated login status
                location.reload();

            } else {
                // Handle error
                alert('Error: ' + response.message);
            }
        } else {
            // Handle error
            alert('Error: ' + xhr.statusText);
        }
    };
    xhr.send(formData);
});


    </script>

    <?php
}
    else {
    echo '<h3 style="display: flex;flex-direction: column;text-align: center;justify-content: center;align-items: center;margin:60px  auto;"  >Please login with new user details.</h3>';
}

get_footer();
?>