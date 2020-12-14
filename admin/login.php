<?php

require('connection.php');
require('function.php');

if (!login()) {

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="assets/favicon.png" type="image/png">
        <!-- font awesome bootstrap master and placeholder-->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/all.css">
        <link rel="stylesheet" href="css/login.css">
        <title>Exchange Admin Login</title>
    </head>

    <body>
        <div class="wrapper">
            <div class="container">
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="card shadow">
                            <div class="card-body">
                                <h5 class="text-center"><strong>Login</strong></h5>
                                <hr>
                                <form action="#" method="POST" id="login-form">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="fas fa-user"></i>
                                                </span>
                                            </div>
                                            <input type="text" name="username" id="username" placeholder="Username" class="form-control rounded-right">
                                            <div class="invalid-feedback" id="invalid-username"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="fas fa-key"></i>
                                                </span>
                                            </div>
                                            <input type="password" name="password" id="password" placeholder="Password" class="form-control rounded-right">
                                            <div class="invalid-feedback" id="invalid-password"></div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-primary btn-block" onclick="login()">Login</button>
                                    </div>
                                    <hr>
                                    <div class="form-group text-center">
                                        <div class="spinner-border text-primary" role="status" id="loading" style="display: none;">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="js/jquery-3.5.1.js"></script>
        <script src="js/popper.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/all.js"></script>
        <script src="js/master.js"></script>
    </body>

    </html>
<?php
} else {
    header('location:/admin/');
}
?>