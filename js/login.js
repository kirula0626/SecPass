// Get the login form
const loginForm = document.getElementById("loginForm");

// Get the username and password inputs
const usernameInput = document.getElementById("usernameInput");
const passwordInput = document.getElementById("passwordInput");

// Get the validation message element
const validationMessage = passwordInput.nextElementSibling;

// Add event listener to password input field to check its length in real-time
passwordInput.addEventListener("input", (event) => {
    if (passwordInput.value.length < 8) {
        loginForm.querySelector('button[type="submit"]').disabled = true;
    } else {
        loginForm.querySelector('button[type="submit"]').disabled = false;
    }
});

// Add event listener for form submission
loginForm.addEventListener("submit", (event) => {
    // Prevent the form from submitting normally
    event.preventDefault();

    // Check if the password is at least 8 characters long
    if (passwordInput.value.length < 8) {
        passwordInput.classList.add("is-invalid");
        validationMessage.style.display = "block";
        return;
    }

    // If password is valid, remove validation classes and submit form
    passwordInput.classList.remove("is-invalid");
    validationMessage.style.display = "none";
    loginForm.submit();
});

const password = document.getElementById("passwordInput").value;
const hashedPassword = CryptoJS.MD5(password).toString();
console.log(hashedPassword); // Password is hashed.