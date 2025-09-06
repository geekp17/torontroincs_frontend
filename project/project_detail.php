<!doctype html>
<html lang="en">
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/head.php'; ?>
  <body class="bg-light">
<?php include $_SERVER['DOCUMENT_ROOT'] . '/nav.php'; ?>
<div class="container my-4">
<div class="d-flex justify-content-between align-items-center mb-3">
  <h1 class="h3">Project Detail</h1>
  <div class="d-flex gap-2">
    <a class="btn btn-outline-primary" href="./project_list.php">Back</a>
    <button class="btn btn-secondary" id="editBtn">Edit</button>
  </div>
</div>

<div class="card shadow-sm">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table">
        <tbody>
          <tr><th>Name</th><td id='f_name'></td></tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', async () => {
  const params = new URLSearchParams(location.search);
  const id = params.get('id');
  const API_BASE = localStorage.getItem('API_BASE') || '/api';
  if (!id) { alert('Missing id'); return; }

  try {
    const res = await fetch(`${API_BASE}/projects/${id}/`, { headers: authHeaders() });
    if (!res.ok) throw new Error('HTTP ' + res.status);
    const data = await res.json();
    document.getElementById('f_name').textContent = (data['name']);
  } catch (e) {
    alert(e.message);
  }

  document.getElementById('editBtn').addEventListener('click', () => {
    location.href = './project_form.php?id=' + id;
  });
});
</script>


</div>

</body>
</html>
