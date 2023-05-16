const passwordInput = document.getElementById('passwordInput');
const confirmPasswordInput = document.getElementById('confirmPasswordInput');
const confirmButton = document.getElementById('confirmButton');
const passwordFeedbackList = document.getElementById('passwordFeedbackList');
const passwordStrengthMeter = document.getElementById('passwordStrengthMeter');

function checkPasswordStrength(password) {
    const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/;
    return regex.test(password);
}

function livePasswordFeedback(password) {
    passwordFeedbackList.innerHTML = ''; // Clear the previous feedback

    const feedbackItems = {
        'Lowercase letter': /[a-z]/.test(password),
        'Uppercase letter': /[A-Z]/.test(password),
        'Digit': /\d/.test(password),
        'Special character': /[!@#$%^&*]/.test(password),
        'At least 8 characters long': password.length >= 8
    };

    let metRequirements = 0;

    for (const [requirement, isMet] of Object.entries(feedbackItems)) {
        const listItem = document.createElement('li');
        listItem.textContent = requirement;
        listItem.style.color = isMet ? 'green' : 'red';
        if (isMet) metRequirements += 1;
        passwordFeedbackList.appendChild(listItem);
    }

    passwordStrengthMeter.textContent = `Strength: ${metRequirements}/5`;
}

function validatePasswords() {
    const password = passwordInput.value;
    const confirmPassword = confirmPasswordInput.value;

    if (password !== confirmPassword) {
        confirmButton.disabled = true;
        passwordStrengthMeter.innerText = 'Passwords do not match.';
        passwordStrengthMeter.style.display = 'block';
        return;
    }

    if (checkPasswordStrength(password)) {
        confirmButton.disabled = false;
        passwordStrengthMeter.style.display = 'none';
    } else {
        confirmButton.disabled = true;
        passwordStrengthMeter.innerText = 'Password must be at least 8 characters long and contain at least one lowercase letter, one uppercase letter, one digit, and one special character.';
        passwordStrengthMeter.style.display = 'block';
    }

    livePasswordFeedback(password); // Add live feedback for the password
}

passwordInput.addEventListener('input', validatePasswords);
confirmPasswordInput.addEventListener('input', validatePasswords);