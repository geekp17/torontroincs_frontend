<nav class="navbar navbar-expand-lg bg-body-tertiary border-bottom">
  <div class="container-fluid">
    <ul id="navBar" class="navbar-nav me-auto mb-2 mb-lg-0">
      <li class="nav-item">
        <a class="nav-link" href="/">Home Page</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/machine/machine_list.php">Machines</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/docking_rack/docking_rack_list.php">Docking Racks</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/customer_part_number/customer_part_number_list.php">Customer Part Numbers</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/part_number/part_number_list.php">Part Numbers</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/project/project_list.php">Projects</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/work_order/work_order_list.php">Work Orders</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/feeder/feeder_list.php">Feeders</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/feeder_assignment/feeder_assignment_list.php">Feeder Assignments</a>
      </li>
    </ul>
    <div class="ms-auto d-flex gap-2">
      <span>
        <a id="loginStatus" class="nav-link" href=""></a>
      </span>
    </div>
  </div>
</nav>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Set API configuration
    localStorage.setItem('API_BASE', 'http://localhost:8000/app');
    localStorage.setItem('API_BASE_AUTH', 'http://localhost:8000/auth');

    const loginStatus = document.getElementById('loginStatus')

    const API_TOKEN = localStorage.getItem('API_TOKEN')

    if (API_TOKEN == '') {
      loginStatus.href = '/user/user_login.php'
      loginStatus.textContent = 'Login'
    } else {
      loginStatus.textContent = 'Logout'
      loginStatus.addEventListener('click', async (e) => {
        e.preventDefault();
        localStorage.setItem('API_TOKEN', '')
        window.location.replace('/');
       });
    }

    // Handle active navigation state
    const navBar = document.getElementById('navBar');
    const navItems = Array.from(navBar.children);
    const currentPath = window.location.pathname;

    navItems.forEach((item) => {
      const link = item.children[0]
      if (link.getAttribute('href') === currentPath) {
        link.classList.add('active');
        link.setAttribute('aria-current', 'page'); // For accessibility
      } else {
        link.classList.remove('active');
        link.removeAttribute('aria-current');
      }
    });
  });

  // Utility functions for API calls
  function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
  }

  function authHeaders(extra = {}) {
    const token = localStorage.getItem('API_TOKEN') || '';
    const headers = Object.assign({ 'Content-Type': 'application/json' }, extra);
    if (token) headers['Authorization'] = `Token ${token}`;
    const csrftoken = getCookie('csrftoken');
    if (csrftoken) headers['X-CSRFToken'] = csrftoken;
    return headers;
  }
</script>