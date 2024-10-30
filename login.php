<?php
session_start();
// Check if the user is already logged in, redirect to dashboard if true
if (isset ($_SESSION['user_id'])) {
    header("Location: dashboard/dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/images/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon">
    <title>Slim Reset</title>
    <!-- Google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&amp;display=swap"
        rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.css">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="assets/css/vendors/icofont.css">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="assets/css/vendors/themify.css">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="assets/css/vendors/flag-icon.css">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="assets/css/vendors/feather-icon.css">
    <!-- Plugins css start-->
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="assets/css/vendors/bootstrap.css">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link id="color" rel="stylesheet" href="assets/css/color-1.css" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="assets/css/responsive.css">
</head>

<body>
    <div class="container-fluid p-0">
        <div class="row m-0">
            <div class="col-12 p-0">
                <div class="login-card login-dark">
                    <div style="width:450px;">
                        <div>
                            <a class="logo" href="index.php">
                                <img class="img-fluid for-light" src="assets/images/logo/logo.png" alt="looginpage"
                                    style="width:200px;">
                                <img class="img-fluid for-dark" src="assets/images/logo/logo.png" alt="looginpage"
                                    style="width:200px;">
                            </a>
                        </div>
                        <div class="login-main">
                            <form id="loginForm" method="post" class="theme-form">
                                <h4>Sign in to account</h4>
                                <p>Enter your email & password to login</p>
                                <div class="form-group">
                                    <label class="col-form-label">Email Address</label>
                                    <input id="email" class="form-control" type="email" required=""
                                        placeholder="admin@admin.com">
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Password</label>
                                    <div class="form-input position-relative">
                                        <input id="password" class="form-control" type="password" name="login[password]"
                                            required="" placeholder="*********">
                                        <div class="show-hide">
                                            <span class="show"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-0">
                                    <div class="text-end mt-3">
                                        <button id="loginBtn" class="btn btn-primary btn-block w-100" type="submit">Sign
                                            in</button>
                                    </div>
                                </div>
                                <br/>
                                <a href="index.php">Don't Have an Account? Register Here!</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap/bootstrap.bundle.min.js"></script>
        <script src="assets/js/icons/feather-icon/feather.min.js"></script>
        <script src="assets/js/icons/feather-icon/feather-icon.js"></script>
        <script src="assets/js/config.js"></script>
        <script src="assets/js/script.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            $(document).ready(function () {
                $('#loginForm').submit(function (event) {
                    event.preventDefault();
                    var email = $('#email').val();
                    var password = $('#password').val();
                    $.ajax({
                        url: 'functions/authenticate.php',
                        type: 'POST',
                        data: {
                            email: email,
                            password: password
                        },
                        success: function (response) {
                            if (response.trim() === 'success') {
                                window.location.href = 'dashboard/dashboard.php';
                            } else {
                                Swal.fire({
                                    title: 'Login Failed',
                                    text: "Invalid Login Details",
                                    icon: 'error',
                                    showCancelButton: false,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Ok'
                                });
                            }
                        },
                        error: function (xhr, status, error) {
                            Swal.fire({
                                title: 'Error',
                                text: "An error occurred while processing your request. Please try again.",
                                icon: 'error',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Ok'
                            });
                        }
                    });
                });
            });
        </script>
    </div>
</body>

</html>