<?php
if (isset($_GET['error'])) {
    echo '<div class="alert alert-danger text-center position-fixed top-0 w-100 shadow-sm">
            Invalid username or password
          </div>';
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>DepEd Appointment System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            height: 100vh;
            overflow: hidden;
            transition: 0.3s ease;
        }

        .left-panel {
            background: linear-gradient(135deg, #0038A8, #0056d6);
            color: white;
            height: 100vh;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            text-align: center;
            transition: 0.3s ease;
        }

        .wave {
            position: absolute;
            bottom: 0;
            width: 100%;
        }

        .right-panel {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
            transition: 0.3s ease;
        }

        .login-card {
            width: 390px;
            border-radius: 20px;
            background: #ffffff;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            transition: 0.3s ease;
        }

        .login-title {
            font-weight: 600;
            color: #0038A8;
        }

        .form-control {
            height: 48px;
            border-radius: 12px;
            transition: 0.3s ease;
        }

        .btn-primary {
            height: 50px;
            border-radius: 12px;
            font-weight: 600;
            background: linear-gradient(135deg, #0038A8, #0056d6);
            border: none;
        }

        .logo {
            width: 110px;
            margin-bottom: 20px;
        }

        .toggle-pass {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
        }

        .dark-toggle {
            position: absolute;
            top: 20px;
            right: 20px;
            cursor: pointer;
            font-size: 20px;
            color: white;
            z-index: 10;
        }

        /* =========================
           DARK MODE STYLES
        ========================== */

        body.dark-mode {
            background: #121212;
        }

        body.dark-mode .right-panel {
            background: #181818;
        }

        body.dark-mode .login-card {
            background: #242424;
            color: #ffffff;
        }

        body.dark-mode .login-title {
            color: #4dabff;
        }

        body.dark-mode .form-control {
            background: #2f2f2f;
            border: 1px solid #444;
            color: #ffffff;
        }

        body.dark-mode .form-control::placeholder {
            color: #bbbbbb;
        }

        body.dark-mode .btn-primary {
            background: linear-gradient(135deg, #0056d6, #0038A8);
        }

        body.dark-mode .left-panel {
            background: linear-gradient(135deg, #001f5c, #0038A8);
        }

        body.dark-mode .text-muted {
            color: #cccccc !important;
        }

        @media(max-width: 768px) {
            .left-panel {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="row">

            <!-- LEFT -->
            <div class="col-md-6 left-panel">
                <i class="bi bi-moon-fill dark-toggle" onclick="toggleDarkMode()"></i>

                <img src="depedlogo2.jpg" class="logo">
                <h2 class="fw-bold">DepEd Appointment System</h2>
                <p>Division of Southern Leyte</p>

                <svg class="wave" viewBox="0 0 1440 320">
                    <path fill="#ffffff" fill-opacity="0.2"
                        d="M0,224L80,218.7C160,213,320,203,480,192C640,181,800,171,960,186.7C1120,203,1280,245,1360,266.7L1440,288V320H0Z">
                    </path>
                </svg>
            </div>

            <!-- RIGHT -->
            <div class="col-md-6 right-panel">

                <div class="card login-card">
                    <div class="card-body p-4 text-center">

                        <h4 class="login-title mb-1">System Login</h4>
                        <p class="text-muted mb-4">Enter your credentials</p>

                        <form action="authenticate.php" method="post">

                            <div class="mb-3 position-relative">
                                <i class="bi bi-person position-absolute"
                                    style="left:14px; top:50%; transform:translateY(-50%); color:#6c757d;"></i>
                                <input name="username" class="form-control ps-5" placeholder="Username" required>
                            </div>

                            <div class="mb-3 position-relative">
                                <i class="bi bi-lock position-absolute"
                                    style="left:14px; top:50%; transform:translateY(-50%); color:#6c757d;"></i>

                                <input type="password" id="password" name="password" class="form-control ps-5 pe-5"
                                    placeholder="Password" required>

                                <i class="bi bi-eye toggle-pass" id="togglePassword"></i>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                LOGIN
                            </button>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- SUCCESS MODAL -->
    <div class="modal fade" id="successModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center border-0 shadow">
                <div class="modal-body p-4">
                    <i class="bi bi-check-circle-fill text-success fs-1"></i>
                    <h5 class="mt-3 fw-semibold">Login Successful</h5>
                    <p class="text-muted mb-0">Redirecting to dashboard...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- LOGOUT MODAL -->
    <div class="modal fade" id="logoutModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center border-0 shadow">
                <div class="modal-body p-4">
                    <i class="bi bi-box-arrow-right text-primary fs-1"></i>
                    <h5 class="mt-3 fw-semibold">Logout Successful</h5>
                    <p class="text-muted mb-0">You have been logged out.</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.getElementById("togglePassword").addEventListener("click", function () {
            const password = document.getElementById("password");
            password.type = password.type === "password" ? "text" : "password";
            this.classList.toggle("bi-eye");
            this.classList.toggle("bi-eye-slash");
        });

        /* DARK MODE WITH LOCAL STORAGE */
        function toggleDarkMode() {
            document.body.classList.toggle("dark-mode");

            if (document.body.classList.contains("dark-mode")) {
                localStorage.setItem("theme", "dark");
            } else {
                localStorage.setItem("theme", "light");
            }
        }

        window.onload = function () {
            if (localStorage.getItem("theme") === "dark") {
                document.body.classList.add("dark-mode");
            }
        };
    </script>

    <?php if (isset($_GET['success'])) { ?>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                var successModal = new bootstrap.Modal(document.getElementById('successModal'));
                successModal.show();

                setTimeout(function () {
                    window.location.href = "dashboard.php";
                }, 1800);
            });
        </script>
    <?php } ?>

    <?php if (isset($_GET['logout'])) { ?>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                var logoutModal = new bootstrap.Modal(document.getElementById('logoutModal'));
                logoutModal.show();
            });
        </script>
    <?php } ?>

</body>

</html>