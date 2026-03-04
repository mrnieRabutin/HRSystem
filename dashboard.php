<?php
include "auth/check.php";
include "config/db.php";

$search = "";
if (isset($_GET['search'])) {
  $search = $conn->real_escape_string($_GET['search']);
}

$sql = "SELECT * FROM appointments";
if ($search != "") {
  $sql .= " WHERE fullname LIKE '%$search%'";
}
$sql .= " ORDER BY id DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
  <title>DepEd Appointment Dashboard</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">


  <style>
    body {
      background: linear-gradient(135deg, #f1f5ff, #eef2f7);
      font-family: 'Poppins', sans-serif;
    }

    /* NAVBAR */
    .navbar {
      background: linear-gradient(135deg, #0038A8, #0056d6);
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .navbar-brand {
      font-weight: 600;
      font-size: 18px;
    }

    /* CARDS */
    .card {
      border: none;
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
      transition: 0.3s ease;
    }

    .card:hover {
      transform: translateY(-4px);
    }

    /* SEARCH */
    .search-box {
      position: relative;
    }

    .search-box i {
      position: absolute;
      top: 50%;
      left: 12px;
      transform: translateY(-50%);
      color: #6c757d;
    }

    .search-box input {
      padding-left: 38px;
      border-radius: 10px;
    }

    /* TABLE */
    .table thead {
      background: linear-gradient(135deg, #0038A8, #0056d6);
      color: white;
    }

    .table tbody tr:hover {
      background: #eef3ff;
    }

    .badge-office {
      background: #0d6efd;
      padding: 6px 12px;
      border-radius: 20px;
      font-size: 12px;
    }

    .btn {
      border-radius: 10px;
    }

    .modal-header {
      background: linear-gradient(135deg, #0038A8, #0056d6);
    }

    /* DARK MODE */
    body.dark-mode {
      background: #121212;
      color: #e4e4e4;
    }

    body.dark-mode .card {
      background: #1e1e1e;
      color: #e4e4e4;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
    }

    body.dark-mode .table {
      color: #e4e4e4;
    }

    body.dark-mode .table thead {
      background: #002b80;
    }

    body.dark-mode .navbar {
      background: linear-gradient(135deg, #001f5c, #0038A8);
    }

    body.dark-mode .modal-content {
      background: #1e1e1e;
      color: white;
    }

    body.dark-mode .form-control {
      background: #2c2c2c;
      border: 1px solid #444;
      color: white;
    }

    body.dark-mode .form-control::placeholder {
      color: #bbb;
    }

    .toggle-btn {
      cursor: pointer;
      font-size: 18px;
      color: white;
      margin-right: 15px;
    }

    .custom-header {
      background: #ffffff;
      border-bottom: 1px solid #dee2e6;
    }

    /* Dark mode header */
    body.dark-mode .custom-header {
      background: #1f1f1f;
      border-bottom: 1px solid #333;
    }

    body.dark-mode .custom-header h5 {
      color: #ffffff;
    }
  </style>
</head>

<body>

  <!-- ================= NAVBAR ================= -->
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid d-flex justify-content-between align-items-center">

      <div class="d-flex align-items-center">
        <img src="depedlogo2.jpg" style="width:55px; margin-right:12px;">
        <div class="text-white">
          <div class="navbar-brand mb-0 p-0">
            DepEd Appointment System
          </div>
          <div style="font-size:13px; font-weight:600; letter-spacing:1px;">
            DIVISION OF SOUTHERN LEYTE
          </div>
        </div>
      </div>

      <div class="d-flex align-items-center">

        <!-- DARK MODE TOGGLE -->
        <i class="bi bi-moon-stars toggle-btn" id="darkToggle"></i>

        <button class="btn btn-light btn-sm me-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#appointmentModal">
          <i class="bi bi-plus-circle"></i> New Appointment
        </button>

        <a href="logout.php" class="btn btn-danger btn-sm shadow-sm">
          <i class="bi bi-box-arrow-right"></i> Logout
        </a>
      </div>

    </div>
  </nav>

  <div class="container mt-4">

    <!-- ================= SEARCH ================= -->
    <div class="card mb-4">
      <div class="card-body">
        <form class="row g-3 align-items-center" method="GET">
          <div class="col-md-4 search-box">
            <i class="bi bi-search"></i>
            <input type="text" name="search" class="form-control" placeholder="Search Teacher / Appointee..."
              value="<?php echo htmlspecialchars($search); ?>">
          </div>
          <div class="col-md-auto">
            <button class="btn btn-primary shadow-sm">
              <i class="bi bi-search"></i> Search
            </button>
            <a href="dashboard.php" class="btn btn-secondary shadow-sm">
              Reset
            </a>
          </div>
        </form>
      </div>
    </div>

    <!-- ================= TABLE ================= -->
    <div class="card">
      <div class="card-header custom-header">
        <h5 class="mb-0 fw-semibold">Appointment Records</h5>
      </div>

      <div class="card-body table-responsive">

        <table class="table align-middle">
          <thead>
            <tr>
              <th>#</th>
              <th>Teacher / Appointee</th>
              <th>Address</th>
              <th>Position</th>
              <th>Office</th>
              <th>Date Created</th>
              <th width="240">Actions</th>
            </tr>
          </thead>

          <tbody>

            <?php if ($result->num_rows > 0) { ?>
              <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                  <td><?= $row['id']; ?></td>
                  <td class="fw-semibold text-primary">
                    <?= strtoupper($row['fullname']); ?>
                  </td>
                  <td><?= $row['address']; ?></td>
                  <td><?= $row['position']; ?></td>
                  <td><span class="badge-office"><?= $row['office']; ?></span></td>
                  <td style="color: #868e96;">
                    <?= date("M d, Y", strtotime($row['created_at'])); ?>
                  </td>
                  <td>
                    <a href="generate_pdf.php?id=<?= $row['id']; ?>" target="_blank" class="btn btn-success btn-sm me-1">
                      <i class="bi bi-printer"></i>
                    </a>

                    <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm me-1">
                      <i class="bi bi-pencil"></i>
                    </a>

                    <a href="delete.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm"
                      onclick="return confirm('Delete this record?');">
                      <i class="bi bi-trash"></i>
                    </a>
                  </td>
                </tr>
              <?php } ?>
            <?php } else { ?>
              <tr>
                <td colspan="6" class="text-center text-danger fw-semibold">
                  No records found
                </td>
              </tr>
            <?php } ?>

          </tbody>
        </table>

      </div>
    </div>

  </div>

  <!-- ================= MODAL ================= -->
  <div class="modal fade" id="appointmentModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
      <div class="modal-content">

        <div class="modal-header text-white">
          <h5 class="modal-title">
            <i class="bi bi-file-earmark-plus"></i> New Appointment
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">

          <form id="appointmentForm" method="POST" action="generate_pdf.php" target="_blank">
            <div class="row">

              <div class="col-md-6 mb-3">
                <label>Teacher / Appointee Name </label>
                <input type="text" name="fullname" class="form-control" placeholder="e.g. Juan Dela Cruz" required>
              </div>

               <div class="col-md-6 mb-3">
                <label>Address </label>
                <input type="text" name="address" class="form-control" placeholder="e.g. Maasin City, Southern Leyte" required>
              </div>

              <div class="col-md-4 mb-3">
                <label>Position Title </label>
                <input type="text" name="position" class="form-control" placeholder="e.g. Teacher I" required>
              </div>

              <div class="col-md-2 mb-3">
                <label>SG/JG/PG </label>
                <input type="text" name="sg" class="form-control" placeholder="e.g. 11" required>
              </div>

              <div class="col-md-6 mb-3">
                <label>Status </label>
                <input type="text" name="status" class="form-control" placeholder="e.g. Permanent" required>
              </div>

              <div class="col-md-6 mb-3">
                <label>Office </label>
                <input type="text" name="office" class="form-control" placeholder="e.g. ICT Unit" required>
              </div>

              <div class="col-md-6 mb-3">
                <label>Compensation Words </label>
                <input type="text" name="salary_words" class="form-control"
                  placeholder="e.g. Twenty Five Thousand Pesos" required>
              </div>

              <div class="col-md-6 mb-3">
                <label>Salary Amount </label>
                <input type="text" name="salary_amount" class="form-control" placeholder="e.g. 25,000.00" required>
              </div>

              <div class="col-md-6 mb-3">
                <label>Nature of Appointment </label>
                <input type="text" name="nature" class="form-control" placeholder="e.g. Original / Promotion" required>
              </div>

              <div class="col-md-6 mb-3">
                <label>Vice Name</label>
                <input type="text" name="vice_name" class="form-control" placeholder="e.g. Maria Santos">
              </div>

              <div class="col-md-6 mb-3">
                <label>Vice Status</label>
                <input type="text" name="vice_status" class="form-control" placeholder="e.g. Retired/Transferred">
              </div>

              <div class="col-md-6 mb-3">
                <label>Plantilla Item No. </label>
                <input type="text" name="plantilla" class="form-control" placeholder="e.g. OSEC-DECSB-" required>
              </div>

              <div class="col-md-3 mb-3">
                <label>Page No. </label>
                <input type="text" name="page_no" class="form-control" placeholder="e.g. 15" required>
              </div>

              <div class="col-md-6 mb-3">
                <label>Date of Signing </label>
                <input type="date" name="date_signing" class="form-control" required>
              </div>

              <div class="col-md-6 mb-3">
                <label>Authorized Official </label>
                <input type="text" name="authorized_official" class="form-control" placeholder="e.g. Dr. Maria Santos"
                  required>
              </div>

              <div class="col-md-6 mb-3">
                <label>CSC Action Date </label>
                <input type="date" name="csc_date" class="form-control" required>
              </div>

              <div class="col-md-6 mb-3">
                <label>Published At </label>
                <input type="text" name="published_at" class="form-control"
                  placeholder="e.g. Division of Southern Leyte Bulletin" required>
              </div>

              <div class="col-md-3 mb-3">
                <label>Published From </label>
                <input type="date" name="published_from" class="form-control" required>
              </div>

              <div class="col-md-3 mb-3">
                <label>Published To </label>
                <input type="date" name="published_to" class="form-control" required>
              </div>

              <div class="col-md-3 mb-3">
                <label>Posted From </label>
                <input type="date" name="posted_from" class="form-control" required>
              </div>

              <div class="col-md-3 mb-3">
                <label>Posted To </label>
                <input type="date" name="posted_to" class="form-control" required>
              </div>

              <div class="col-md-6 mb-3">
                <label>HRMPSB Start Date </label>
                <input type="date" name="hrmpsb_start" class="form-control" required>
              </div>

              <div class="col-md-6 mb-3">
                <label>Deliberation Date </label>
                <input type="date" name="deliberation_date" class="form-control" required>
              </div>

              <div class="col-md-6 mb-3">
                <label>Acknowledgement Date </label>
                <input type="date" name="ack_date" class="form-control" required>
              </div>

              <div class="col-md-6 mb-3">
                <label>Appointee Name </label>
                <input type="text" name="appointee" class="form-control" placeholder="e.g. Juan Dela Cruz" required>
              </div>

            </div>

            <button id="printBtn" class="btn btn-success w-100 mt-3" disabled>
              <i class="bi bi-printer"></i> Print to PDF
            </button>

          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    const form = document.getElementById('appointmentForm');
    const btn = document.getElementById('printBtn');

    form.addEventListener('input', function () {
      btn.disabled = !form.checkValidity();
    });
  </script>

  <script>
    const toggle = document.getElementById("darkToggle");

    // Load saved mode
    if (localStorage.getItem("darkMode") === "enabled") {
      document.body.classList.add("dark-mode");
      toggle.classList.remove("bi-moon-stars");
      toggle.classList.add("bi-sun");
    }

    toggle.addEventListener("click", function () {
      document.body.classList.toggle("dark-mode");

      if (document.body.classList.contains("dark-mode")) {
        localStorage.setItem("darkMode", "enabled");
        toggle.classList.remove("bi-moon-stars");
        toggle.classList.add("bi-sun");
      } else {
        localStorage.setItem("darkMode", "disabled");
        toggle.classList.remove("bi-sun");
        toggle.classList.add("bi-moon-stars");
      }
    });
  </script>

</body>

</html>