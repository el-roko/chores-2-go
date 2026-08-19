<?php
session_start();
require_once "guestguard.php";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login · Chores-2-Go</title>
    <link rel="stylesheet" type="text/css" href="../assets/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        body {
            background: url('assets/img/ban.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .overlay {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: linear-gradient(145deg, rgba(26,38,57,0.85), rgba(42,59,92,0.75));
            z-index: -1;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.08);
            border-radius: 28px;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.12);
            box-shadow: 0 24px 64px rgba(0,0,0,0.3);
            padding: 2.5rem 2.5rem;
            transition: all 0.3s ease;
        }
        .glass-card:hover {
            box-shadow: 0 32px 80px rgba(0,0,0,0.35);
        }

        .glass-card h4 {
            font-weight: 700;
            color: #ffffff;
            letter-spacing: -0.01em;
            margin-bottom: 1.5rem;
        }
        .glass-card h4 i {
            color: #8ab4f8;
            margin-right: 0.5rem;
        }

        .form-label {
            font-weight: 500;
            color: rgba(255,255,255,0.85);
            font-size: 0.85rem;
            margin-bottom: 0.3rem;
        }

        .form-control {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 16px;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            color: #ffffff;
            transition: 0.2s ease;
            box-shadow: none;
        }
        .form-control::placeholder {
            color: rgba(255,255,255,0.35);
        }
        .form-control:focus {
            background: rgba(255,255,255,0.12);
            border-color: rgba(255,255,255,0.25);
            box-shadow: 0 0 0 4px rgba(255,255,255,0.05);
            color: #ffffff;
        }

        .form-check-label {
            color: rgba(255,255,255,0.7);
            font-size: 0.85rem;
        }
        .form-check-input {
            background-color: rgba(255,255,255,0.1);
            border-color: rgba(255,255,255,0.2);
        }
        .form-check-input:checked {
            background-color: #8ab4f8;
            border-color: #8ab4f8;
        }

        .btn-primary-modern {
            background: linear-gradient(145deg, #8ab4f8, #6a8fc0);
            border: none;
            border-radius: 40px;
            padding: 0.8rem 2.5rem;
            font-weight: 600;
            color: #1a2639;
            transition: 0.2s ease;
            width: 100%;
            letter-spacing: 0.01em;
            font-size: 0.95rem;
        }
        .btn-primary-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(138, 180, 248, 0.25);
            color: #1a2639;
        }

        .brand-text {
            font-weight: 700;
            color: #ffffff;
            font-size: 1.8rem;
            letter-spacing: -0.02em;
        }
        .brand-text i {
            color: #8ab4f8;
            margin-right: 0.5rem;
        }
        .brand-sub {
            color: rgba(255,255,255,0.5);
            font-weight: 400;
            font-size: 0.9rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .navbar-custom {
            padding: 1rem 2rem;
            background: transparent;
        }
        .navbar-custom .brand {
            font-weight: 700;
            color: #ffffff;
            text-decoration: none;
            font-size: 1.3rem;
        }
        .navbar-custom .brand i {
            color: #8ab4f8;
            margin-right: 8px;
        }

        @media (max-width: 768px) {
            .glass-card {
                padding: 1.8rem 1.2rem;
                margin: 0 0.5rem;
            }
            .brand-text {
                font-size: 1.4rem;
            }
        }
    </style>
</head>
<body>
    <div class="overlay"></div>

    <div class="container-fluid px-3 px-md-4">

        <!-- Navbar -->
        <?php require_once "partials/admin_navbar.php"; ?>

        <!-- Brand Header -->
        <div class="row justify-content-center mt-4">
            <div class="col-md-6 text-center">
                <h1 class="brand-text"><i class="fas fa-shield-alt"></i>CHORES-2-GO ADMIN</h1>
                <p class="brand-sub">Secure Administration Panel</p>
            </div>
        </div>

                   

        <!-- Login Card -->
        <div class="row justify-content-center mt-4">
            <div class="col-md-4">
                <div class="glass-card">
                    <?php require_once "partials/feedback.php"; ?>
                    <h4 class="text-center"><i class="fas fa-lock"></i>Admin Login</h4>

                    <form action="process/process_login.php" method="post" id="loginForm">
                        <div class="form-group mb-3">
                            <label for="email" class="form-label"><i class="fas fa-envelope me-1"></i>Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="admin@chores2go.com" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="pwd" class="form-label"><i class="fas fa-key me-1"></i>Password</label>
                            <input type="password" name="pwd" id="pwd" class="form-control" placeholder="••••••••" required>
                            <div class="form-check mt-2">
                                <input type="checkbox" name="show_pwd" id="show_pwd" class="form-check-input">
                                <label for="show_pwd" class="form-check-label"><i class="fas fa-eye me-1"></i>Show password</label>
                            </div>
                        </div>

                        <div class="my-3 text-center">
                            <button class="btn btn-primary-modern" name="btnlogin">
                                <i class="fas fa-sign-in-alt me-2"></i>Login
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <?php require_once "partials/admin_ext.php"; ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#show_pwd").change(function(){
                var val = $(this).prop("checked");
                if(val){
                    $("#pwd").attr("type","text");
                } else {
                    $("#pwd").attr("type","password");
                }
            });
        });
    </script>
</body>
</html>