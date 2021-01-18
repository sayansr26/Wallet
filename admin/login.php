<?php

require('./include/functions.php');

if (setup()) {


?>

    <!DOCTYPE html>
    <html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Admin Panel - Login</title>

        <!-- Custom fonts for this template-->
        <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

        <!-- Custom styles for this template-->
        <link href="css/sb-admin-2.min.css" rel="stylesheet">

    </head>

    <body class="bg-gradient-primary">

        <div class="container">

            <!-- Outer Row -->
            <div class="row justify-content-center">

                <div class="col-xl-10 col-lg-12 col-md-9">

                    <div class="card o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <!-- Nested Row within Card Body -->
                            <div class="row">
                                <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                                <div class="col-lg-6">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                        </div>
                                        <form class="user" id="signin-form" action="#" method="POST">
                                            <div class="form-group">
                                                <div class="form_div">
                                                    <input type="text" name="username" id="username" class="form_input" placeholder=" ">
                                                    <label for="username" id="username-label" class="form_label">Username</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="form_div">
                                                    <input type="password" name="password" id="password" class="form_input" placeholder=" ">
                                                    <label for="password" id="password-label" class="form_label">Password</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox small">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck">
                                                    <label class="custom-control-label" for="customCheck">Remember
                                                        Me</label>
                                                </div>
                                            </div>
                                            <a href="#" type="button" onclick="signIn()" class="btn btn-primary btn-user btn-block">
                                                Login
                                            </a>
                                            <hr>
                                            <a href="#" class="btn btn-google btn-user btn-block">
                                                <i class="fab fa-google fa-fw"></i> Login with Google
                                            </a>
                                            <a href="#" class="btn btn-facebook btn-user btn-block">
                                                <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
                                            </a>
                                        </form>
                                        <hr>
                                        <div class="text-center">
                                            <a class="small" href="forgot-password.html">Forgot Password?</a>
                                        </div>
                                        <br>
                                        <div class="text-center">
                                            <a class="small" href="/">&copy;All Right Reserved Website 2020</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

        <!-- Bootstrap core JavaScript-->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin-2.min.js"></script>
        <!-- login script -->
        <script>
            function signIn() {
                $('#username').removeClass('invalid');
                $('#password').removeClass('invalid');
                $.ajax({
                    url: 'action.php?auth=login',
                    type: 'post',
                    data: $('#signin-form').serialize(),
                    success: function(response) {
                        if (response == 'empty_username') {
                            $('#username').addClass('invalid');
                        }
                        if (response == 'empty_password') {
                            $('#password').addClass('invalid');
                        }
                        if (response == 'invalid_username') {
                            $('#username').addClass('invalid');
                        }
                        if (response == 'invalid_password') {
                            $('#password').addClass('invalid');
                        }
                        if (response == 'success') {
                            window.location.href = "/admin/";
                        }
                    }
                });
            }
        </script>

    </body>

    </html>

<?php

} else {
    header('location:setup?msg=You have to complete this setup');
}

?>