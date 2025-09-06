<!doctype html>
<html lang="en">
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/head.php'; ?>
  <body class="bg-light">
<?php include $_SERVER['DOCUMENT_ROOT'] . '/nav.php'; ?>
<div class="container my-4">
<div class="d-flex justify-content-between align-items-center mb-3">
  <h1 class="h3" id="pageTitle">Feeder Assignment Form</h1>
  <a class="btn btn-outline-primary" href="./feeder_assignment_list.php">Back</a>
</div>

<div class="card shadow-sm">
  <div class="card-body">
    <form id="form" class="row g-3">

      <div class="col-md-6">
        <label class="form-label">Feeder</label>
        <input class="form-control" id="f_feeder" placeholder="feeder">
      </div>

      <div class="col-md-6">
        <label class="form-label">Customer Part Number</label>
        <input class="form-control" id="f_customer_part_number" placeholder="customer_part_number">
      </div>

      <div class="col-md-6">
        <label class="form-label">Work Order</label>
        <input class="form-control" id="f_work_order" placeholder="work_order">
      </div>

      <div class="col-md-6">
        <label class="form-label">Docking Rack</label>
        <input class="form-control" id="f_docking_rack" placeholder="docking_rack">
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
    title.textContent = 'Edit Feeder Assignment';
    const res = await fetch(`${API_BASE}/feeder-assignments/${id}/`, { headers: authHeaders() });
    if (res.ok) {
      const data = await res.json();
      var el_feeder = document.getElementById('f_feeder'); if (el_feeder) el_feeder.value = (data['feeder'] ?? '');
      var el_customer_part_number = document.getElementById('f_customer_part_number'); if (el_customer_part_number) el_customer_part_number.value = (data['customer_part_number'] ?? '');
      var el_work_order = document.getElementById('f_work_order'); if (el_work_order) el_work_order.value = (data['work_order'] ?? '');
      var el_docking_rack = document.getElementById('f_docking_rack'); if (el_docking_rack) el_docking_rack.value = (data['docking_rack'] ?? '');
      var el_location = document.getElementById('f_location'); if (el_location) el_location.value = (data['location'] ?? '');
    }
  } else {
    title.textContent = 'Create Feeder Assignment';
  }

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const payload = {
      'feeder': (document.getElementById('f_feeder')?.value ?? ''),
      'customer_part_number': (document.getElementById('f_customer_part_number')?.value ?? ''),
      'work_order': (document.getElementById('f_work_order')?.value ?? ''),
      'docking_rack': (document.getElementById('f_docking_rack')?.value ?? ''),
      'location': (document.getElementById('f_location')?.value ?? '')
    };
    const url = id ? `${API_BASE}/feeder-assignments/${id}/` : `${API_BASE}/feeder-assignments/`;
    const method = id ? 'PATCH' : 'POST';
    const res = await fetch(url, { method, headers: authHeaders(), body: JSON.stringify(payload) });
    if (res.ok) {
      location.href = './feeder_assignment_list.php';
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
