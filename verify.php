<?php
require('include/config.php');
require('include/function.php');


if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $query = "SELECT * FROM verify_data WHERE token = :token";
    $statement = $connection->prepare($query);
    $statement->execute(
        array(
            'token' => $token
        )
    );
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        $email = $row['email'];
    }
    // echo $token;
}

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
        <title>Exchaneg - Account Recover</title>
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
                                            <h1 class="h4 text-gray-900 mb-4">Account Recover</h1>
                                        </div>
                                        <form class="user" id="forget-form" action="#" method="POST">
                                            <input type="hidden" name="email" value="<?php echo $email; ?>">
                                            <input type="hidden" name="token" value="<?php echo $token; ?>">
                                            <div class="form-group">
                                                <div class="form_div">
                                                    <input type="password" name="password" id="password" class="form_input" placeholder=" ">
                                                    <label for="password" id="password-label" class="form_label">Password</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="form_div">
                                                    <input type="password" name="cpassword" id="cpassword" class="form_input" placeholder=" ">
                                                    <label for="cpassword" id="cpassword-label" class="form_label">Confirm Password</label>
                                                </div>
                                            </div>
                                            <a type="button" onclick="recover()" class="btn btn-primary btn-user btn-block">
                                                Reset Password
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
                var password = $('#password').val();
                var cpassword = $('#cpassword').val();
                if (password == '') {
                    $('.card-text').html('Password required !');
                    $('#msg-danger').fadeIn(500);
                    $('#msg-danger').delay(5000).fadeOut(500);
                    $('#password').val('');
                    $('#cpassword').val('');
                } else if (cpassword == '') {
                    $('.card-text').html('Confirm Password required !');
                    $('#msg-danger').fadeIn(500);
                    $('#msg-danger').delay(5000).fadeOut(500);
                    $('#password').val('');
                    $('#cpassword').val('');
                } else if (password != cpassword) {
                    $('.card-text').html('Password mismatch !');
                    $('#msg-danger').fadeIn(500);
                    $('#msg-danger').delay(5000).fadeOut(500);
                    $('#password').val('');
                    $('#cpassword').val('');
                } else {
                    $.ajax({
                        url: 'action.php?verify=1',
                        type: 'post',
                        data: $('#forget-form').serialize(),
                        success: function(response) {
                            if (response == 'link_used') {
                                $('.card-text').html('Link already used !');
                                $('#msg-danger').fadeIn(500);
                                $('#msg-danger').delay(5000).fadeOut(500);
                                $('#password').val('');
                                $('#cpassword').val('');
                            } else if (response == 'success') {
                                window.location.href = '/';
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