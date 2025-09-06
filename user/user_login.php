<!doctype html>
<html lang="en">
<?php include $_SERVER['DOCUMENT_ROOT'] . '/head.php'; ?>
<body class="bg-light">
<?php include $_SERVER['DOCUMENT_ROOT'] . '/nav.php'; ?>
<div class="container my-4">


    <div class="card login-card">
      <div class="card-body p-4">
        <h1 class="h4 mb-3">Sign in to your account</h1>

        <!-- Error placeholder -->
         <div class="alert alert-danger d-none" id="error"></div>

        <form id="loginForm">
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" id="username" class="form-control" autocomplete="username" required />
            <div class="invalid-feedback">Please enter your username.</div>
          </div>

          <div class="mb-3">
            <label for="password" class="form-label d-flex justify-content-between">
              <span>Password</span>
              <button type="button" id="togglePw" class="btn btn-link btn-sm p-0">Show</button>
            </label>
            <input type="password" id="password" class="form-control" autocomplete="current-password" required />
            <div class="invalid-feedback">Please enter your password.</div>
          </div>

          <div class="d-flex align-items-center justify-content-between mb-3">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="remember" />
              <label class="form-check-label" for="remember">Remember me</label>
            </div>
          </div>

          <button class="btn btn-primary w-100" id="submitBtn" type="submit">
            <span class="spinner-border spinner-border-sm me-2 d-none" id="spinner" role="status" aria-hidden="true"></span>
            Sign in
          </button>
        </form>
      </div>
    </div>

    <p class="text-center text-muted mt-4">
      Don’t have an account?
      <a href="/user/user_create.php" class="link-primary">Create one</a>
    </p>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const API_BASE_AUTH = localStorage.getItem('API_BASE_AUTH');
        const errEl = document.getElementById('error');
        const loginForm = document.getElementById('loginForm');

        loginForm?.addEventListener('submit', async (e) => {
            e.preventDefault();
            const payload = {};
            payload['username'] = document.getElementById('username').value
            payload['password'] = document.getElementById('password').value

            const res = await fetch(`${API_BASE_AUTH}/token/login`, {
              method: 'POST',
              headers: authHeaders(),
              body: JSON.stringify(payload)
            })

            if (res.ok) {
              const data = await res.json()
              localStorage.setItem('API_TOKEN', data.auth_token);
              window.location.replace('/');
            } else {
                const body = await res.text();
                errEl.textContent = `Create failed: ${res.status} ${body}`;
                errEl .classList.remove('d-none'); 
              }
          });
        });
    
</script>
</body>
</html>