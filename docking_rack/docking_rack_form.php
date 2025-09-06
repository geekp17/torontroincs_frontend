<!doctype html>
<html lang="en">
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/head.php'; ?>
  <body class="bg-light">
<?php include $_SERVER['DOCUMENT_ROOT'] . '/nav.php'; ?>
<div class="container my-4">
<div class="d-flex justify-content-between align-items-center mb-3">
  <h1 class="h3" id="pageTitle">Docking Rack Form</h1>
  <a class="btn btn-outline-primary" href="./docking_rack_list.php">Back</a>
</div>

<div class="card shadow-sm">
  <div class="card-body">
    <form id="form" class="row g-3">

      <div class="col-md-6">
        <label class="form-label">Bardcode</label>
        <input class="form-control" id="f_bardcode" placeholder="bardcode">
      </div>

      <div class="col-md-6">
        <label class="form-label">Machine</label>
        <input class="form-control" id="f_machine" placeholder="machine">
      </div>

      <div class="col-md-6">
        <label class="form-label">Location</label>
        <input class="form-control" id="f_location" placeholder="location">
      </div>
      <div class="col-12">
        <button class="btn btn-primary" type="submit">Save</button>
      </div>
    </form>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', async () => {
  const params = new URLSearchParams(location.search);
  const id = params.get('id');
  const title = document.getElementById('pageTitle');
  const form = document.getElementById('form');
  const API_BASE = localStorage.getItem('API_BASE') || '/api';

  if (id) {
    title.textContent = 'Edit Docking Rack';
    const res = await fetch(`${API_BASE}/dockingracks/${id}/`, { headers: authHeaders() });
    if (res.ok) {
      const data = await res.json();
      var el_bardcode = document.getElementById('f_bardcode'); if (el_bardcode) el_bardcode.value = (data['bardcode'] ?? '');
      var el_machine = document.getElementById('f_machine'); if (el_machine) el_machine.value = (data['machine'] ?? '');
      var el_location = document.getElementById('f_location'); if (el_location) el_location.value = (data['location'] ?? '');
    }
  } else {
    title.textContent = 'Create Docking Rack';
  }

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const payload = {
      'bardcode': (document.getElementById('f_bardcode')?.value ?? ''),
      'machine': (document.getElementById('f_machine')?.value ?? ''),
      'location': (document.getElementById('f_location')?.value ?? '')
    };
    const url = id ? `${API_BASE}/dockingracks/${id}/` : `${API_BASE}/dockingracks/`;
    const method = id ? 'PATCH' : 'POST';
    const res = await fetch(url, { method, headers: authHeaders(), body: JSON.stringify(payload) });
    if (res.ok) {
      location.href = './docking_rack_list.php';
    } else {
      const body = await res.text();
      alert('Save failed: ' + res.status + '\n' + body);
    }
  });
});
</script>


</div>

</body>
</html>
