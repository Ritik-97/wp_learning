<?php
/* Template Name: Custom Registration Page */
get_header();
?>

<style>
    #ajax-register-form {
        display: flex;
        justify-content: center;
        width: 100%;
        padding: 40px;
        border: 1px solid #ccc;
        border-radius: 8px;
        background-color: #f5f5f5;
        max-width: 80%;
        margin: 10px auto;
    }

    .box {
           display: flex;
    justify-content: center;
    flex-direction: column;
    align-items: flex-start;
    }

    h3 {
        text-align: center;
        color: #333;
        margin-bottom: 20px;
    }

    form {
        display: flex;
        flex-direction: column;
        width: 100%;
    }

    label {
        margin-bottom: 8px;
        color: #333;
        font-weight: bold;
        margin-right: 10px;
    }

    input,
    select {
        padding: 10px;
        margin-bottom: 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        width: 100%;
        border-radius: 5px;

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
        margin-top: 20px;
        text-align: center;
        color: #333;
    }

    .notifi {
        margin-bottom: 15px;
        display: flow;
        flex-direction: column;
    }

    .notifi input {
        margin-right: 8px;
    }
        .box {
/*            margin-bottom: 15px;*/
        }

        .error-message {
            color: red;
            font-size: 14px;
/*            margin-top: 1px;*/
        }
    </style>
</head>
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
                <button id="genpass" type="button" onclick="generatePassword()">Generate a password</button><br><br>
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

        <button type="button" id="register-submit" onclick="validateForm()">Sign in</button>
        <div id="loadergif" style="width: 50px; height: auto; margin-inline: auto; margin-top: 25px;">
            <img src="" id="loader">
        </div>
        <div id="register-message"></div><br>
    </form>

    <script>
    function validateForm() {
        // Reset error messages
        document.querySelectorAll('.error-message').forEach(function (element) {
            element.textContent = '';
        });

        // Validate each field
        var username = document.getElementById('register-username').value;
        if (username.trim() === '') {
            document.getElementById('error-username').textContent = 'Username is required';
        }

        var email = document.getElementById('register-email').value;
        if (email.trim() === '') {
            document.getElementById('error-email').textContent = 'Email is required';
        }

        var firstname = document.getElementById('first_name').value;
        if (firstname.trim() === '') {
            document.getElementById('error-firstname').textContent = 'First name is required';
        }

        var lastname = document.getElementById('last_name').value;
        if (lastname.trim() === '') {
            document.getElementById('error-lastname').textContent = 'Last name is required';
        }

        var password = document.getElementById('register-password').value;
        if (password.trim() === '') {
            document.getElementById('error-password').textContent = 'Password is required';
        }

        var userRole = document.getElementById('user_role').value;
        if (userRole.trim() === '') {
            document.getElementById('error-user-role').textContent = 'User role is required';
        }

        // Check if any error messages are present
        // var errorMessages = document.querySelectorAll('.error-message');
        // console.log(errorMessages);
     
    }
</script>
</div>

<script> 
 function generatePassword() {
    let genpass = document.getElementById("genpass");
    genpass.disabled = true;
        // Make an AJAX request to generate a password
        fetch('/wp-admin/admin-ajax.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'action=generate_password',
        })
        .then(response => response.json())
        .then(data => {
            genpass.disabled = false;
            // Set the generated password to the input field
            document.getElementById('register-password').value = data.data;

            // Calculate and display password strength
            updatePasswordStrength();
        })
        .catch(error => console.error('Error:', error));
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

    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('register-password');
        passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
    }

    function submitForm(event) {
        event.preventDefault(); // Prevent the default form submission

        // Collect form data
        const formData = {
            username: document.getElementById('register-username').value,
            email: document.getElementById('register-email').value,
            // Add other form fields as needed
        };

        xhr.send(JSON.stringify(formData));
    }

</script>
<?php
get_footer();
?>