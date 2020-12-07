<?php ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="vendors/bootstrap-4.5.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendors/fontawesome/css/all.css">
    <link rel="stylesheet" href="css/exchange.css">
    <title>Echnage - Sign Up</title>
</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Setup an Account!</h1>
                            </div>
                            <form class="user" id="setup-form" method="POST" action="#">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <div class="form_div">
                                            <input type="text" name="fname" id="fname" class="form_input" placeholder=" ">
                                            <label for="fname" id="fname-label" class="form_label">First Name</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form_div">
                                            <input type="text" name="lname" id="lname" class="form_input" placeholder=" ">
                                            <label for="lname" id="lname-label" class="form_label">Last Name</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form_div">
                                        <input type="email" name="email" id="email" class="form_input" placeholder=" ">
                                        <label for="email" id="email-label" class="form_label">Email Address</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form_div">
                                        <input type="text" name="username" id="username" class="form_input" placeholder=" ">
                                        <label for="username" id="username-label" class="form_label">Username</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form_div">
                                        <input type="text" name="phone" id="phone" class="form_input" placeholder=" ">
                                        <label for="phone" id="phone-label" class="form_label">Phone</label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <div class="form_div">
                                            <input type="password" name="password" id="password" class="form_input" placeholder=" ">
                                            <label for="password" id="password-label" class="form_label">Password</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form_div">
                                            <input type="password" name="cpassword" id="cpassword" class="form_input" placeholder=" ">
                                            <label for="cpassword" id="cpassword-label" class="form_label">Repeat Password</label>
                                        </div>
                                    </div>
                                </div>
                                <a href="#" type="button" class="btn btn-primary btn-user btn-block" onclick="setup()">
                                    Finish Setup
                                </a>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="/">&copy;All Right Reserved Website 2020</a>
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
        function setup() {
            $.ajax({
                url: 'action.php?setup=1',
                type: 'post',
                data: $('#setup-form').serialize(),
                success: function(response) {
                    if (response == 'empty_fname') {
                        alert('First name required');
                    }
                    if (response == 'empty_lname') {
                        alert('Last name required');
                    }
                    if (response == 'empty_email') {
                        alert('Email required');
                    }
                    if (response == 'empty_username') {
                        alert('Username required');
                    }
                    if (response == 'empty_phone') {
                        alert('Phone number required');
                    }
                    if (response == 'empty_password') {
                        alert('Password required');
                    }
                    if (response == 'empty_cpassword') {
                        alert('Confirm password required');
                    }
                    if (response == 'paswword_mismatch') {
                        alert('Password not match');
                    }
                    if (response == 'email_error') {
                        alert('Email already registerd');
                    }
                    if (response == 'username_error') {
                        alert('Username already taken');
                    }
                    if (response == 'success') {
                        window.location.href = "/";
                    }
                }
            });
        }
    </script>

</body>

</html>