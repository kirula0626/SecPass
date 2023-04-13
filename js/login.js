// Get the login form
const loginForm = document.getElementById("loginForm");

// Add event listener for form submission
loginForm.addEventListener("submit", (event) => {
    // Prevent the form from submitting normally
    event.preventDefault();

    // Get the username and password inputs
    const usernameInput = document.getElementById("usernameInput");
    const passwordInput = document.getElementById("passwordInput");

    // Get the validation message element
    const validationMessage = passwordInput.nextElementSibling;

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