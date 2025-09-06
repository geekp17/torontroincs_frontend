<!doctype html>
<html lang="en">
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/head.php'; ?>
  <body class="bg-light">
<?php include $_SERVER['DOCUMENT_ROOT'] . '/nav.php'; ?>
<div class="container my-4">
<div class="d-flex justify-content-between align-items-center mb-3">
  <h1 class="h3">Docking Rack Detail</h1>
  <div class="d-flex gap-2">
    <a class="btn btn-outline-primary" href="./docking_rack_list.php">Back</a>
    <button class="btn btn-secondary" id="editBtn">Edit</button>
  </div>
</div>

<div class="card shadow-sm">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table">
        <tbody>
          <tr><th>Bardcode</th><td id='f_bardcode'></td></tr><tr><th>Machine</th><td id='f_machine'></td></tr><tr><th>Location</th><td id='f_location'></td></tr>
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
    const res = await fetch(`${API_BASE}/dockingracks/${id}/`, { headers: authHeaders() });
    if (!res.ok) throw new Error('HTTP ' + res.status);
    const data = await res.json();
    document.getElementById('f_bardcode').textContent = (data['bardcode']);
    document.getElementById('f_machine').textContent = (data['machine']);
    document.getElementById('f_location').textContent = (data['location']);
  } catch (e) {
    alert(e.message);
  }

  document.getElementById('editBtn').addEventListener('click', () => {
    location.href = './docking_rack_form.php?id=' + id;
  });
});
</script>


</div>

</body>
</html>
