function isValidEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

console.log(!isValidEmail(document.getElementById("email").value));

// Submit form on button click
$('#forget_password_form').submit(function(event) {
    event.preventDefault();
    const email_reset = document.getElementById("email").value;
    if (!isValidEmail(email_reset)) {

        $('#email').removeClass('is-valid').addClass('is-invalid');
    } else {
        // Convert email to hash
        const hashEmailR = CryptoJS.SHA1(email).toString();

        // Modify URL with hash
        const newUrl = window.location.href.split('?')[0] + '?email=' + hashEmailR;
        window.history.pushState(null, null, newUrl);

        // Process forget password logic here
        // alert('Password reset link sent to email.');
    }
});