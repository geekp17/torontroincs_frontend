<!doctype html>
<html lang="en">
<?php include $_SERVER['DOCUMENT_ROOT'] . '/head.php'; ?>

<body class="bg-light">
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/nav.php'; ?>
  <main class="container py-4">

    <div class="alert alert-danger d-none" id="error"></div>

    <div id="alertHost"></div>
    <div class="row g-4">
      <div class="col-12 col-lg-8">
        <div class="card shadow-sm">
          <div class="card-body">
            <h1 class="h4 mb-2">Welcome</h1>
            <p class="text-secondary mb-3">Please make sure to log in and select the work order to start your shift.
              Complete the
              feeder check and run AOI on the first board, then fill out the production tracking and verification form.
            </p>
            <div class="d-flex flex-wrap gap-2">
              <select id="wordOrderSelect" class="form-select w-auto">
              </select>

              <a id="starShift" class="btn btn-outline-secondary">Start Shift</a>
            </div>

          </div>
        </div>
      </div>
    </div>
  </main>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      API_BASE = localStorage.getItem('API_BASE')
      RESOURCE = 'work-orders'
      errEl = document.getElementById('error')
      selectEl = document.getElementById('wordOrderSelect')
      startBtn = document.getElementById('starShift')

      async function loadList() {
        if (errEl) errEl.textContent = '';
        try {
          const res = await fetch(`${API_BASE}/${RESOURCE}/`, { headers: authHeaders() });
          if (!res.ok) throw new Error('HTTP ' + res.status);
          const data = await res.json();
          const items = Array.isArray(data) ? data : (data.results || []);
          if (!items.length) {
            selectEl.innerHTML = '<option>No records</option>';
            return;
          }
          selectEl.innerHTML = items.map(row => (
            `<option value=${row.id || row.pk}>` + `${row.name} </option>`
          )).join('');
        } catch (e) {
          if (errEl) errEl.textContent = e.message;
        }
      }

      loadList();

      startBtn?.addEventListener('click', (e) => {
        e.preventDefault();
        const selectedIndex = selectEl.selectedIndex;
        const selectedOption = selectEl.options[selectedIndex];
        window.location.replace(`/feeder_verification.php?work_order_id=${selectedOption.value}&work_order_name=${selectedOption.textContent}`);
      })
    })
  </script>
</body>

</html>