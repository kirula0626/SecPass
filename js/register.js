const form = document.getElementById('user-registration-form');
const emailInput = document.getElementById('email');

form.addEventListener('submit', (event) => {
    if (!isValidEmail(emailInput.value)) {
        event.preventDefault(); // Prevent the form from submitting
        alert('Please enter a valid email address');
    }
});

function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Regex for validating email format
    return emailRegex.test(email);
}

const passwordInput = document.getElementById('password');
const passwordFeedback = document.getElementById('password-feedback');

passwordInput.addEventListener('input', () => {
    const password = passwordInput.value;
    const hasCapitalLetter = /[A-Z]/.test(password);
    const hasNumber = /[0-9]/.test(password);
    const hasSpecialChar = /[^A-Za-z0-9]/.test(password);
    const isLongEnough = password.length >= 8;

    let feedbackText = '';
    if (!isLongEnough) {
        feedbackText = 'Password must be at least 8 characters long';
    } else {
        feedbackText += hasCapitalLetter ? '✔️ Has a capital letter' : '❌ Needs a capital letter';
        feedbackText += '<br>';
        feedbackText += hasNumber ? '✔️ Has a number' : '❌ Needs a number';
        feedbackText += '<br>';
        feedbackText += hasSpecialChar ? '✔️ Has a special character' : '❌ Needs a special character';
    }

    passwordFeedback.innerHTML = feedbackText;
});


const confirmPasswordInput = document.getElementById("confirm-password");
const confirmPasswordError = document.getElementById("confirm-password-error");

function checkPasswordMatch() {
    if (passwordInput.value !== confirmPasswordInput.value) {
        confirmPasswordError.innerText = "Passwords do not match";
    } else {
        confirmPasswordError.innerText = "";
    }
}

passwordInput.addEventListener("input", checkPasswordMatch);
confirmPasswordInput.addEventListener("input", checkPasswordMatch);

const form1 = document.querySelector('#user-registration-form');
const requiredFields = document.querySelectorAll('[required]');

form.addEventListener('submit', (event) => {
    // Prevent the form from submitting by default
    event.preventDefault();

    // Check if all required fields are filled
    let allFilled = true;
    requiredFields.forEach((field) => {
        if (!field.value) {
            allFilled = false;
            field.classList.add('is-invalid');
        } else {
            field.classList.remove('is-invalid');
        }
    });

    // If any required field is not filled, display error message and return
    if (!allFilled) {
        const errorMessage = document.createElement('div');
        errorMessage.classList.add('alert', 'alert-danger');
        errorMessage.innerHTML = 'Please fill in all required fields.';
        form1.prepend(errorMessage);
        return;
    }

    // If all required fields are filled, submit the form
    form1.submit();
});