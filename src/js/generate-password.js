
 // function generatePassword() {
 //    let genpass = document.getElementById("genpass");
 //    genpass.disabled = true;
 //        // Make an AJAX request to generate a password
 //        fetch('/wp-admin/admin-ajax.php', {
 //            method: 'POST',
 //            headers: {
 //                'Content-Type': 'application/x-www-form-urlencoded',
 //            },
 //            body: 'action=generate_password',
 //        })
 //        .then(response => response.json())
 //        .then(data => {
 //            genpass.disabled = false;
 //            // Set the generated password to the input field
 //            document.getElementById('register-password').value = data.data;

 //            // Calculate and display password strength
 //            updatePasswordStrength();
 //        })
 //        .catch(error => console.error('Error:', error));
 //    }

 //    function updatePasswordStrength() {
 //        const password = document.getElementById('register-password').value;
 //        const strength = calculatePasswordStrength(password);
        
 //        document.getElementById('password-strength').innerText = 'Password Strength: ' + strength;
 //    }

 //    function calculatePasswordStrength(password) {
 //        // A more comprehensive password strength calculation
 //        const regexLower = /[a-z]/;
 //        const regexUpper = /[A-Z]/;
 //        const regexDigit = /\d/;
 //        const regexSpecial = /[!@#$%^&*()_+[\]{}|;:,.<>?]/;

 //        const lowerExists = regexLower.test(password);
 //        const upperExists = regexUpper.test(password);
 //        const digitExists = regexDigit.test(password);
 //        const specialExists = regexSpecial.test(password);

 //        const conditionsMet = [lowerExists, upperExists, digitExists, specialExists].filter(Boolean).length;
 //        const lengthBonus = Math.min(conditionsMet, 3);

 //        // Assign strength based on conditions met and length
 //        if (password.length < 8 || conditionsMet < 3) {
 //            return 'Weak';
 //        } else if (lengthBonus === 3) {
 //            return 'Strong';
 //        } else {
 //            return 'Moderate';
 //        }
 //    }

 //    function togglePasswordVisibility() {
 //        const passwordInput = document.getElementById('register-password');
 //        passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
 //    }


 //    // function submitForm(event) {
 //    //     event.preventDefault(); // Prevent the default form submission

 //    //     // Collect form data
 //    //     const formData = {
 //    //         username: document.getElementById('register-username').value,
 //    //         email: document.getElementById('register-email').value,
 //    //         // Add other form fields as needed
 //    //     };

 //    //     // Convert formData to JSON before sending
 //    //     xhr.send(JSON.stringify(formData));
 //    // }

