<?php
require('include/config.php');
require('include/function.php');

if (!login()) {

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="vendors/bootstrap-4.5.3-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="vendors/fontawesome/css/all.css">
        <link rel="stylesheet" href="css/exchange.css">
        <title>Exchaneg - Sign In</title>
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
                                            <a type="button" onclick="signIn()" class="btn btn-primary btn-user btn-block">
                                                Login
                                            </a>
                                        </form>
                                        <br>
                                        <hr>
                                        <div class="text-center">
                                            <a class="small" href="signup">Don't have an account ? Singup</a>
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
        <a class="whatsapp-suppurt" target="_blank" href="https://wa.me/9876543210">
            <img src="assets/whatsapp.svg" height="50" width="50" alt="">
        </a>

        <!-- Bootstrap core JavaScript-->
        <script src="vendors/jquery/jquery-3.5.1.js"></script>
        <script src="vendors/bootstrap-4.5.3-dist/js/bootstrap.min.js"></script>
        <script src="vendors/fontawesome/js/all.js"></script>
        <script>
            function signIn() {
                $.ajax({
                    url: 'action.php?auth=login',
                    type: 'POST',
                    data: $('#signin-form').serialize(),
                    success: function(response) {
                        if (response == 'empty_username') {
                            alert(response);
                        }

                        if (response == 'empty_password') {
                            alert(response);
                        }
                        if (response == 'invalid_password') {
                            alert(response);
                        }
                        if (response == 'inavlid_username') {
                            alert(response);
                        }
                        if (response == 'success') {
                            window.location.href = '/';
                        }
                    }
                });
            }
        </script>

    </body>

    </html>

<?php
} else {
    header('location:/');
}
?>