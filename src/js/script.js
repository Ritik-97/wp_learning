
function generatePassword() {
    let genpassButton = document.getElementById("genpass");
    let loader = document.getElementById("loader");

    genpassButton.disabled = true;
    genpassButton.innerText = 'Generating Password...';
    loader.style.display = 'inline-block';

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
        // Set the generated password to the input field
        document.getElementById('register-password').value = data.data;

        // Calculate and display password strength
        updatePasswordStrength();
    })
    .catch(error => console.error('Error:', error))
    .finally(() => {
        // Re-enable the button and hide the loader
        genpassButton.disabled = false;
        genpassButton.innerText = 'Generate a password';
        loader.style.display = 'none';
    });
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



// sign up form validations

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
        var errorMessages = document.querySelectorAll('.error-message');
        var hasErrors = Array.from(errorMessages).some(function (element) {
            return element.textContent.trim() !== '';
        });

        
    }


