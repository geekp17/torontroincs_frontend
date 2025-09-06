<!doctype html>
<html lang="en">
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/head.php'; ?>
  <body class="bg-light">
<?php include $_SERVER['DOCUMENT_ROOT'] . '/nav.php'; ?>
<div class="container my-4">
<div class="d-flex justify-content-between align-items-center mb-3">
  <h1 class="h3">Work Order Detail</h1>
  <div class="d-flex gap-2">
    <a class="btn btn-outline-primary" href="./work_order_list.php">Back</a>
    <button class="btn btn-secondary" id="editBtn">Edit</button>
  </div>
</div>

<div class="card shadow-sm">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table">
        <tbody>
          <tr><th>Name</th><td id='f_name'></td></tr><tr><th>Project</th><td id='f_project'></td></tr>
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
    const res = await fetch(`${API_BASE}/work-orders/${id}/`, { headers: authHeaders() });
    if (!res.ok) throw new Error('HTTP ' + res.status);
    const data = await res.json();
    document.getElementById('f_name').textContent = (data['name']);
    document.getElementById('f_project').textContent = (data['project']);
  } catch (e) {
    alert(e.message);
  }

  document.getElementById('editBtn').addEventListener('click', () => {
    location.href = './work_order_form.php?id=' + id;
  });
});
</script>


</div>

</body>
</html>
