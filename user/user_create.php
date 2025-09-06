<!doctype html>
<html lang="en">
<?php include $_SERVER['DOCUMENT_ROOT'] . '/head.php'; ?>
<body class="bg-light">
<?php include $_SERVER['DOCUMENT_ROOT'] . '/nav.php'; ?>
<div class="container my-4">


     <div class="card card-wrap">
      <div class="card-body p-4">
        <h1 class="h4 mb-3">Create your account</h1>

        <!-- Error placeholder -->
        <div class="alert alert-danger d-none" id="error" role="alert"></div>

        <form id="signupForm" novalidate>
          <div class="row g-3">
            <div class="col-sm-6">
              <label for="first_name" class="form-label">First name</label>
              <input type="text" id="first_name" class="form-control" required />
              <div class="invalid-feedback">Please enter your first name.</div>
            </div>
            <div class="col-sm-6">
              <label for="last_name" class="form-label">Last name</label>
              <input type="text" id="last_name" class="form-control" required />
              <div class="invalid-feedback">Please enter your last name.</div>
            </div>
            <div class="col-12">
              <label for="username" class="form-label">Username</label>
              <input type="text" id="username" class="form-control" autocomplete="username" required />
              <div class="invalid-feedback">Please choose a username.</div>
            </div>
            <div class="col-12">
              <label for="email" class="form-label">Email</label>
              <input type="email" id="email" class="form-control" autocomplete="email" required />
              <div class="invalid-feedback">Please enter a valid email address.</div>
            </div>
            <div class="col-12">
              <label class="form-label d-flex justify-content-between" for="password">
                <span>Password</span>
                <button type="button" id="togglePw" class="btn btn-link btn-sm p-0">Show</button>
              </label>
              <input type="password" id="password" class="form-control" autocomplete="new-password" required />
              <div class="form-text">
                8+ characters recommended. Your API may enforce extra rules.
              </div>
              <div class="invalid-feedback">Please enter a password.</div>
            </div>
            <div class="col-12">
              <label class="form-label d-flex justify-content-between" for="password2">
                <span>Confirm password</span>
                <button type="button" id="togglePw2" class="btn btn-link btn-sm p-0">Show</button>
              </label>
              <input type="password" id="password2" class="form-control" autocomplete="new-password" required />
              <div class="invalid-feedback">Passwords must match.</div>
            </div>
          </div>

          <button class="btn btn-primary w-100 mt-4" id="submitBtn" type="submit">
            <span class="spinner-border spinner-border-sm me-2 d-none" id="spinner" role="status" aria-hidden="true"></span>
            Create account
          </button>
        </form>
      </div>
    </div>

    <p class="text-center text-muted mt-4">
      Already have an account?
      <a href="/user_login.php" class="link-primary">Sign in</a>
    </p>


</body>
</html>