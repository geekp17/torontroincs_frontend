<!doctype html>
<html lang="en">
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/head.php'; ?>
  <body class="bg-light">
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/nav.php'; ?>
    <div class="container my-4">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3">Docking Rack List</h1>
        <a class="btn btn-success" href="./docking_rack_form.php">New Docking Rack</a>
      </div>

<div class="alert alert-danger d-none" id="error"></div>

<div class="card shadow-sm mb-4">
  <div class="card-header">Quick Create</div>
  <div class="card-body">
    <form id="createForm" class="row g-3">

      <div class="col-md-6">
        <label class="form-label">Bardcode</label>
        <input class="form-control" id="create_bardcode" placeholder="bardcode">
      </div>

      <div class="col-md-6">
        <label class="form-label">Machine</label>
        <input class="form-control" id="create_machine" placeholder="machine">
      </div>

      <div class="col-md-6">
        <label class="form-label">Location</label>
        <input class="form-control" id="create_location" placeholder="location">
      </div>
      <div class="col-12">
        <button class="btn btn-primary" type="submit">Create</button>
      </div>
    </form>
  </div>
</div>

<div class="card shadow-sm">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-striped table-hover mb-0" id="table">
        <thead class="table-light">
          <tr>
            <th>Bardcode</th><th>Machine</th><th>Location</th>
            <th class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody id="rows"></tbody>
      </table>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const API_BASE = localStorage.getItem('API_BASE') || '/api';
  const RESOURCE = 'dockingracks';
  const listEl = document.getElementById('rows');
  const errEl = document.getElementById('error');
  const createForm = document.getElementById('createForm');

  async function loadList() {
    if (errEl) errEl.textContent = '';
    listEl.innerHTML = '<tr><td colspan="4" class="text-center p-4">Loading…</td></tr>';
    try {
      const res = await fetch(`${API_BASE}/${RESOURCE}/`, { headers: authHeaders() });
      if (!res.ok) throw new Error('HTTP ' + res.status);
      const data = await res.json();
      const items = Array.isArray(data) ? data : (data.results || []);
      if (!items.length) {
        listEl.innerHTML = '<tr><td colspan="4" class="text-center text-muted p-4">No records.</td></tr>';
        return;
      }
      listEl.innerHTML = items.map(row => (
        `<tr>`+`<td>${row['barcode']}</td>`+`<td>${row['machine'].name}</td>`+`<td>${row['location']}</td>`+
        `<td class="text-end">
           <div class="btn-group btn-group-sm">
             <a class="btn btn-outline-primary" href="./docking_rack_detail.php?id=${row.id || row.pk}">View</a>
             <button class="btn btn-outline-secondary" data-id="${row.id || row.pk}" data-action="edit">Edit</button>
             <button class="btn btn-outline-danger" data-id="${row.id || row.pk}" data-action="delete">Delete</button>
           </div>
         </td></tr>`
      )).join('');
    } catch (e) {
      if (errEl) errEl.textContent = e.message;
    }
  }

  document.getElementById('table').addEventListener('click', async (e) => {
    const btn = e.target.closest('button');
    if (!btn) return;
    const id = btn.getAttribute('data-id');
    const action = btn.getAttribute('data-action');
    if (action === 'delete' && confirm('Delete this item?')) {
      const res = await fetch(`${API_BASE}/dockingracks/${id}/`, {
        method: 'DELETE',
        headers: authHeaders()
      });
      if (res.ok || res.status === 204) loadList();
      else alert('Delete failed: ' + res.status);
    }
    if (action === 'edit') {
      location.href = './docking_rack_form.php?id=' + id;
    }
  });

  createForm?.addEventListener('submit', async (e) => {
    e.preventDefault();
    const payload = {};
    payload['bardcode'] = document.getElementById('create_bardcode').value;
    payload['machine'] = document.getElementById('create_machine').value;
    payload['location'] = document.getElementById('create_location').value;
    const res = await fetch(`${API_BASE}/dockingracks/`, {
      method: 'POST',
      headers: authHeaders(),
      body: JSON.stringify(payload)
    });
    if (res.ok) {
      e.target.reset();
      loadList();
    } else {
      const body = await res.text();
      alert('Create failed: ' + res.status + '\n' + body);
    }
  });

  loadList();
});
</script>


</div>

</body>
</html>
