<!doctype html>
<html lang="en">
<?php include $_SERVER['DOCUMENT_ROOT'] . '/head.php'; ?>

<body class="bg-light">
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/nav.php'; ?>
  <main class="container py-4">

    <div class="alert d-none" id="status"></div>

    <div id="alertHost"></div>
    <h1 class="h4 mb-3">Feeder Verification</h1>
    <div class="card shadow-sm">
      <div class="card-body vstack gap-3">
        <div class="row g-2">
          <div class="col-12 col-md-4">
            <label class="form-label">Work Order</label>
            <input class="form-control" id="workOrderInput" placeholder="Work order name or ID" readonly>
          </div>
          <div class="col-12 col-md-4">
            <label class="form-label">Scan Feeder</label>
            <input class="form-control" id="feederInput" placeholder="Scan feeder barcode">
          </div>
        <div id="verifyResults" class="alert d-none" role="alert"></div>
        <div class="row g-2">
          <div class="col-12 col-md-6">
            <label class="form-label">Scan Part Number</label>
            <input class="form-control" id="partInput" placeholder="Scan expected part number">
          </div>
          <div class="col-12 col-md-6 d-flex align-items-end gap-2">
            <button class="btn btn-success w-100" id="validateBtn">Validate</button>
            <button class="btn btn-warning w-100" id="overrideBtn">Override</button>
          </div>
        </div>
      </div>
    </div>

  </main>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const API_BASE = localStorage.getItem('API_BASE')
      const RESOURCE = 'feeder-assignments'

      const statusEl = document.getElementById('status')
      const queryString = window.location.search;
      const urlParams = new URLSearchParams(queryString);
      const work_order_id = urlParams.get('work_order_id');
      const work_order_name = urlParams.get('work_order_name');
      const validateBtn = document.getElementById('validateBtn');
      const overrideBtn = document.getElementById('overrideBtn');

      document.getElementById('workOrderInput').value = work_order_name;

      validateBtn?.addEventListener('click', async (e) => {
        e.preventDefault();
        payload = {}
        payload['work_order_id'] = work_order_id
        payload['feeder_barcode'] = document.getElementById('feederInput').value
        payload['partInput'] = document.getElementById('partInput').value;
        console.log(payload)
        const res = await fetch(`${API_BASE}/${RESOURCE}/validate/`, {
          method: 'post',
          headers: authHeaders(),
          body: JSON.stringify(payload)
        })
        if (res.ok) {
          statusEl.textContent = "Validation Successfull"
          statusEl.classList.remove('alert-danger')
          statusEl.classList.add('alert-success')
          statusEl.classList.remove('d-none'); 
        }
        else {
          const body = await res.text();
          statusEl.textContent = "Validation Failed";
          statusEl.classList.remove('alert-success')
          statusEl.classList.add('alert-danger')
          statusEl.classList.remove('d-none'); 
        }
      })

      overrideBtn?.addEventListener('click', async (e) => {
        e.preventDefault();
        payload = {}
        payload['work_order_id'] = work_order_id
        payload['feeder_barcode'] = document.getElementById('feederInput').value
        console.log(payload)
        const res = await fetch(`${API_BASE}/${RESOURCE}/overide/`, {
          method: 'post',
          headers: authHeaders(),
          body: JSON.stringify(payload)
        })
        if (res.ok) {
          statusEl.textContent = "Overide Successfull"
          statusEl.classList.remove('alert-danger')
          statusEl.classList.add('alert-success')
          statusEl.classList.remove('d-none'); 
        }
        else {
          const body = await res.text();
          statusEl.textContent = "Overide Failed";
          statusEl.classList.remove('alert-success')
          statusEl.classList.add('alert-danger')
          statusEl.classList.remove('d-none'); 
        }
      })
    })
  </script>
</body>

</html>