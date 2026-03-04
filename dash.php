<?php
include "auth/check.php";
?>

<!DOCTYPE html>
<html>
<head>
  <title>DepEd Main Dashboard</title>

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

/* DASHBOARD CARDS */
.dashboard-card {
  border: none;
  border-radius: 18px;
  padding: 35px;
  text-align: center;
  cursor: pointer;
  transition: 0.3s ease;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
  background: white;
}

.dashboard-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
}

.dashboard-card i {
  font-size: 45px;
  margin-bottom: 15px;
  color: #0038A8;
}

.dashboard-title {
  font-weight: 600;
  font-size: 18px;
}

.dashboard-desc {
  font-size: 13px;
  color: #6c757d;
}

/* DARK MODE */
body.dark-mode {
  background: #121212;
  color: #e4e4e4;
}

body.dark-mode .dashboard-card {
  background: #1e1e1e;
  color: #e4e4e4;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
}

body.dark-mode .navbar {
  background: linear-gradient(135deg, #001f5c, #0038A8);
}

body.dark-mode .dashboard-desc {
  color: #bbb;
}

.toggle-btn {
  cursor: pointer;
  font-size: 18px;
  color: white;
  margin-right: 15px;
}
</style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container-fluid d-flex justify-content-between align-items-center">

    <div class="d-flex align-items-center">
      <img src="depedlogo2.jpg" style="width:55px; margin-right:12px;">
      <div class="text-white">
        <div class="navbar-brand mb-0 p-0">
          Department of Education
        </div>
        <div style="font-size:13px; font-weight:600; letter-spacing:1px;">
          DIVISION OF SOUTHERN LEYTE
        </div>
      </div>
    </div>

    <div class="d-flex align-items-center">
      <i class="bi bi-moon-stars toggle-btn" id="darkToggle"></i>
      </a>

      <a href="logout.php" class="btn btn-danger btn-sm shadow-sm">
        <i class="bi bi-box-arrow-right"></i> Logout
      </a>
    </div>

  </div>
</nav>

<div class="container mt-5">

  <div class="row g-4">

    <!-- CARD 1 -->
    <div class="col-md-4">
      <div class="dashboard-card" onclick="location.href='dashboard.php'">
        <i class="bi bi-file-earmark-text"></i>
        <div class="dashboard-title">Appointment Records</div>
      </div>
    </div>

    <!-- CARD 2 -->
    <div class="col-md-4">
      <div class="dashboard-card" onclick="location.href='assumption_system/index.php'">
        <i class="bi bi-bar-chart-line"></i>
        <div class="dashboard-title">Certificate of Assumption</div>
      </div>
    </div>

    <!-- CARD 3 -->
    <div class="col-md-4">
      <div class="dashboard-card" onclick="location.href='users.php'">
        <i class="bi bi-people"></i>
        <div class="dashboard-title">Special Order</div>
      </div>
    </div>

    <!-- CARD 4 -->
    <div class="col-md-4">
      <div class="dashboard-card" onclick="location.href='archive.php'">
        <i class="bi bi-archive"></i>
        <div class="dashboard-title">Assignment Order</div>
      </div>
    </div>

    <!-- CARD 5 -->
    <div class="col-md-4">
      <div class="dashboard-card" onclick="location.href='settings.php'">
        <i class="bi bi-gear"></i>
        <div class="dashboard-title">System Settings</div>
      </div>
    </div>

    <!-- CARD 6 -->
    <div class="col-md-4">
      <div class="dashboard-card" onclick="location.href='activity_logs.php'">
        <i class="bi bi-clock-history"></i>
        <div class="dashboard-title">Activity Logs</div>
      </div>
    </div>

  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

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