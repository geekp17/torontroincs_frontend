<!doctype html>
<html lang="en">
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/head.php'; ?>
  <body class="bg-light">
<?php include $_SERVER['DOCUMENT_ROOT'] . '/nav.php'; ?>
<div class="container my-4">
<div class="d-flex justify-content-between align-items-center mb-3">
  <h1 class="h3">Feeder Assignment Detail</h1>
  <div class="d-flex gap-2">
    <a class="btn btn-outline-primary" href="./feeder_assignment_list.php">Back</a>
    <button class="btn btn-secondary" id="editBtn">Edit</button>
  </div>
</div>

<div class="card shadow-sm">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table">
        <tbody>
          <tr><th>Feeder</th><td id='f_feeder'></td></tr><tr><th>Customer Part Number</th><td id='f_customer_part_number'></td></tr><tr><th>Work Order</th><td id='f_work_order'></td></tr><tr><th>Docking Rack</th><td id='f_docking_rack'></td></tr><tr><th>Location</th><td id='f_location'></td></tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', async () => {
  localStorage.setItem('API_BASE', 'http://localhost:8000/app');
  const params = new URLSearchParams(location.search);
  const id = params.get('id');
  const API_BASE = localStorage.getItem('API_BASE') || '/api';
  if (!id) { alert('Missing id'); return; }

  try {
    const res = await fetch(`${API_BASE}/feeder-assignments/${id}/`, { headers: authHeaders() });
    if (!res.ok) throw new Error('HTTP ' + res.status);
    const data = await res.json();
    document.getElementById('f_feeder').textContent = (data['feeder']);
    document.getElementById('f_customer_part_number').textContent = (data['customer_part_number']);
    document.getElementById('f_work_order').textContent = (data['work_order']);
    document.getElementById('f_docking_rack').textContent = (data['docking_rack']);
    document.getElementById('f_location').textContent = (data['location']);
  } catch (e) {
    alert(e.message);
  }

  document.getElementById('editBtn').addEventListener('click', () => {
    location.href = './feeder_assignment_form.php?id=' + id;
  });
});
</script>


</div>

</body>
</html>
