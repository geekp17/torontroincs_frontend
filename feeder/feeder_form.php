<!doctype html>
<html lang="en">
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/head.php'; ?>
  <body class="bg-light">
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/nav.php'; ?>
    
    <div class="container my-4">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3" id="pageTitle">Feeder Form</h1>
        <a class="btn btn-outline-primary" href="./feeder_list.php">Back</a>
      </div>

      <div class="card shadow-sm">
        <div class="card-body">
          <form id="form" class="row g-3">
            <div class="col-md-6">
        <label class="form-label">Barcode</label>
        <input class="form-control" id="f_barcode" placeholder="barcode">
      </div>

      <div class="col-md-6">
        <label class="form-label">Type</label>
        <input class="form-control" id="f_type" placeholder="type">
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
    title.textContent = 'Edit Feeder';
    const res = await fetch(`${API_BASE}/feeders/${id}/`, { headers: authHeaders() });
    if (res.ok) {
      const data = await res.json();
      var el_barcode = document.getElementById('f_barcode'); if (el_barcode) el_barcode.value = (data['barcode'] ?? '');
      var el_type = document.getElementById('f_type'); if (el_type) el_type.value = (data['type'] ?? '');
    }
  } else {
    title.textContent = 'Create Feeder';
  }

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const payload = {
      'barcode': (document.getElementById('f_barcode')?.value ?? ''),
      'type': (document.getElementById('f_type')?.value ?? '')
    };
    const url = id ? `${API_BASE}/feeders/${id}/` : `${API_BASE}/feeders/`;
    const method = id ? 'PATCH' : 'POST';
    const res = await fetch(url, { method, headers: authHeaders(), body: JSON.stringify(payload) });
    if (res.ok) {
      location.href = './feeder_list.php';
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
