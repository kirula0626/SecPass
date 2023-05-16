<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Master Password</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
  <style>
    .password-feedback {
      display: none;
      margin-top: 5px;
      font-size: 12px;
      color: red;
    }
  </style>
</head>

<body>
  <div class="container mt-5">
    <h2 class="text-center mb-4">Master Password</h2>
    <form id="masterPasswordForm">
      <div class="row justify-content-center">
        <div class="col-8">
          <div class="mb-3 d-flex justify-content-end">
            <label for="passwordInput" class="form-label me-2">Password:</label>
            <input type="password" class="form-control" id="passwordInput" required>
          </div>
          <div class="mb-3 d-flex justify-content-end">
            <label for="confirmPasswordInput" class="form-label me-2">Confirm Password:</label>
            <input type="password" class="form-control" id="confirmPasswordInput" required>
          </div>
        </div>
      </div>
      <div class="row justify-content-end">
        <div class="col-8 d-flex justify-content-end">
            <button type="submit" id="confirmButton" class="btn btn-danger" disabled>Confirm</button>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-8">
          <div class="password-feedback mt-2" id="passwordFeedback"></div>
        </div>
      </div>
    </form>
  </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js "></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js "></script>
    <script src="js/masterpass.js "></script>
</body>

</html>
