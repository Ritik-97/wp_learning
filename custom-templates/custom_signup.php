<?php
/* Template Name: Custom Registration Page */
get_header();
?>
<body>

<div id="ajax-register-form">
    <form id="register-form" style="margin: 10px; padding: 10px;">
        <div class="box" style="align-items:center!important; margin-bottom: 2rem;">
                <h2 >Signup-Form</h2>
            
        </div>

        <div class="box">
            <label><strong>Username <span style="color:red;"> *</span></strong></label>
            <input type="text" id="register-username" placeholder="Username" >
        </div>
            <div class="error-message" id="error-username"></div>

        <br>

        <div class="box">
            <label><strong>Enter Your Email<span style="color:red;"> *</span></strong></label>
            <input type="email" id="register-email" placeholder="Email">
            <div class="error-message" id="error-email"></div>
        </div><br>

        <div class="box">
            <label><strong>Enter Your first name<span style="color:red;"> *</span></strong></label>
            <input type="text" id="first_name" name="first_name" placeholder="Firstname">
            <div class="error-message" id="error-firstname"></div>
        </div><br>

        <div class="box">
            <label><strong>Enter Your Last name<span style="color:red;"> *</span></strong></label>
            <input type="text" id="last_name" name="last_name" placeholder="lastname">
            <div class="error-message" id="error-lastname"></div>
        </div><br>

        <div class="box">
            <label><strong>Enter your password<span style="color:red;"> *</span></strong></label>
                <!-- <button id="genpass" type="button" onclick="generatePassword()">Generate a password</button><br><br> -->
        <button id="genpass" type="button" onclick="generatePassword()">
            Generate a password
            <img id="loader" src="https://ritik.devwork.in/wp-content/uploads/2023/12/loader.gif" alt="Loading..." style="display: none; width: 20px; height: 20px; margin-left: 5px;">
        </button><br>


                <sup><span id="password-strength">Password Strength: </span></sup><br>
                <input type="text" id="register-password" placeholder="Password" oninput="updatePasswordStrength()">
                <button type="button" onclick="togglePasswordVisibility()">Show/Hide</button>
                <div class="error-message" id="error-password"></div>
        </div><br>

        <p class="box"><strong>Select Your Role<span style="color:red;"> *</span></strong>
            <select id="user_role" name="user_role">
                <option value="">--Option--</option>
                <option value="moderator">Moderator</option>
                <option value="customer">Customer</option>
                <option value="subscriber">Subscriber</option>
                <option value="administrator">Admin</option>
            </select>
            <div class="error-message" id="error-user-role"></div>
        </p>

      <div style="text-align: center;">
    <button type="button" id="register-submit" onclick="validateForm()">
        Sign in
    </button>
    <div id="loadergif" style="display: inline-block; vertical-align: middle;">
        <img src="" id="loader" style="width: 50px; height: auto;">
    </div>
    </div>
    <div id="register-message"></div><br>
    </form>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

</div>


<?php
get_footer();
?>