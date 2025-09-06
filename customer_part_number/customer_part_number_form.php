<!doctype html>
<html lang="en">
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/head.php'; ?>
  <body class="bg-light">
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/nav.php'; ?>
    <div class="container my-4">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3" id="pageTitle">Customer Part Number Form</h1>
        <a class="btn btn-outline-primary" href="./customer_part_number_list.php">Back</a>
      </div>

<div class="card shadow-sm">
  <div class="card-body">
    <form id="form" class="row g-3">

      <div class="col-md-6">
        <label class="form-label">Name</label>
        <input class="form-control" id="f_name" placeholder="name">
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
    title.textContent = 'Edit Customer Part Number';
    const res = await fetch(`${API_BASE}/customer-part-numbers/${id}/`, { headers: authHeaders() });
    if (res.ok) {
      const data = await res.json();
      var el_name = document.getElementById('f_name'); if (el_name) el_name.value = (data['name'] ?? '');
    }
  } else {
    title.textContent = 'Create Customer Part Number';
  }

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const payload = {
      'name': (document.getElementById('f_name')?.value ?? '')
    };
    const url = id ? `${API_BASE}/customer-part-numbers/${id}/` : `${API_BASE}/customer-part-numbers/`;
    const method = id ? 'PATCH' : 'POST';
    const res = await fetch(url, { method, headers: authHeaders(), body: JSON.stringify(payload) });
    if (res.ok) {
      location.href = './customer_part_number_list.php';
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
