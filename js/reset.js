function isValidEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("forget-password-form");
    const emailInput = document.getElementById("email");

    form.addEventListener("submit", function(event) {
        event.preventDefault();
        const email = emailInput.value;
        if (!isValidEmail(email)) {
            emailInput.classList.remove("is-valid");
            emailInput.classList.add("is-invalid");
        } else {
            // Process forget password logic here
            alert("Password reset link sent to email.");
            form.submit();
        }
    });

    emailInput.addEventListener("input", function() {
        if (emailInput.classList.contains("is-invalid")) {
            emailInput.classList.remove("is-invalid");
        }
    });
});