<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Form</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">

  <style>
    #logoImg {
      border-radius: 50%;
    }
    .hidden {
      display: none;
    }
  </style>

</head>

<body>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-6 text-center">
        <img src="" id="logoImg" alt="Logo" class="mb-4">
        <h3>Website Login</h3>
      </div>
    </div>
    <form id="loginForm" onsubmit="inputUEP.php">
      <div class="row justify-content-center">
        <div class="col-6">
          <div class="mb-3">
            <label for="websiteUrlInput" class="form-label">Website URL:</label>
            <input type="text" class="form-control" id="websiteUrlInput" required>
          </div>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-6">
          <div class="mb-3">
            <label for="emailInput" class="form-label">Username or Email:</label>
            <input type="email" class="form-control" id="emailInput" required>
          </div>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-6">
          <div class="mb-3">
            <label for="passwordInput" class="form-label">Password:</label>
            <input type="password" class="form-control" id="passwordInput" required>
          </div>
        </div>
      </div>
      <div class="row justify-content-center hidden" id="masterPasswordRow">
      <div class="col-6">
        <div class="mb-3">
          <label for="masterPasswordInput" class="form-label">Master Password:</label>
          <input type="password" class="form-control" id="masterPasswordInput" required>
        </div>
      </div>
    </div>
      <div class="row justify-content-center">
        <div class="col-6">
          <button type="submit" class="btn btn-primary" id="submitButton">Submit</button>
        </div>
      </div>
    </form>
  </div>

  <script>
    var form = document.getElementById('loginForm');
    var masterPasswordRow = document.getElementById('masterPasswordRow');
    var submitButton = document.getElementById('submitButton');

    form.addEventListener('submit', function(event) {
      event.preventDefault();

      // Lock form fields
      document.getElementById('websiteUrlInput').setAttribute('readonly', 'true');
      document.getElementById('emailInput').setAttribute('readonly', 'true');
      document.getElementById('passwordInput').setAttribute('readonly', 'true');

      // Show master password input
      masterPasswordRow.classList.remove('hidden');
      submitButton.innerText = 'Confirm';
    });

    document.getElementById('websiteUrlInput').addEventListener('input', function() {
      var url = this.value;
      var apiUrl = 'https://logo.clearbit.com/' + url;
      document.getElementById('logoImg').src = apiUrl;
    });
</script>

</body>
</html>
