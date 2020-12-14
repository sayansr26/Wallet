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
        <title>Exchaneg - Forget Password</title>
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
                                            <h1 class="h4 text-gray-900 mb-4">Recover Password</h1>
                                        </div>
                                        <form class="user" id="forget-form" action="#" method="POST">
                                            <div class="form-group">
                                                <div class="form_div">
                                                    <input type="email" name="email" id="email" class="form_input" placeholder=" ">
                                                    <label for="email" id="email-label" class="form_label">Email</label>
                                                </div>
                                            </div>
                                            <a type="button" onclick="recover()" class="btn btn-primary btn-user btn-block">
                                                Recover Account
                                            </a>
                                        </form>
                                        <br>
                                        <hr>
                                        <div class="text-center">
                                            <a class="small" href="login">Back to login </a>
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
            <div class="row my-5">
                <div style="display: none;" id="msg-danger" class="col-lg-4 col-10 mx-auto">
                    <div class="shadow rounded bg-danger text-white p-2">
                        <p class="card-text">Email id not found !</p>
                    </div>
                </div>
                <div style="display: none;" id="msg-success" class="col-lg-4 col-10 mx-auto">
                    <div class="shadow rounded bg-success text-white p-2">
                        <p class="card-text">Verification mail send !</p>
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
            function recover() {
                var email = $('#email').val();
                if (email == '') {
                    $('.card-text').html('Email id required !');
                    $('#msg-danger').fadeIn(500);
                    $('#msg-danger').delay(5000).fadeOut(500);
                } else {
                    $.ajax({
                        url: 'action.php?forget=1',
                        type: 'post',
                        data: $('#forget-form').serialize(),
                        success: function(response) {
                            // alert(response);
                            if (response == 'email_error') {
                                $('.card-text').html('Email not found !');
                                $('#msg-danger').fadeIn(500);
                                $('#msg-danger').delay(5000).fadeOut(500);
                                $('#email').val('');
                            } else if (response == 'success') {
                                $('.card-text').html('Recovery mail send successfully !');
                                $('#msg-success').fadeIn(500);
                                $('#msg-success').delay(5000).fadeOut(500);
                                $('#email').val('');
                            }
                        }
                    });
                }
            }
        </script>

    </body>

    </html>

<?php
} else {
    header('location:/');
}
?>