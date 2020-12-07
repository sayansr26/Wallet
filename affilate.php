<?php

require('include/config.php');
require('include/function.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="vendors/bootstrap-4.5.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendors/fontawesome/css/all.css">
    <link rel="stylesheet" href="css/exchange.css">
    <title>Affilate Pograms</title>
</head>

<body>
    <!-- section header -->
    <section class="header-container">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-dark bg-theme-trans">
                <a class="navbar-brand" href="/">Exchnage</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="/">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="track">Track</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="affilate">Affilate <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="testimonial">Testimonial</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact">Contact</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav mr-1">
                        <?php
                        if (!login()) {
                            echo "
                                        <li class='nav-item'>
                                            <a class='nav-link btn btn-custom' href='login'>
                                                <i class='fas fa-sign-in-alt'></i>&nbsp;Sign In
                                            </a>
                                        </li>
                                    ";
                        } else {
                            $uid = $_COOKIE['uid'];
                            $query = "SELECT * FROM user_data WHERE id = :uid";
                            $statement = $connection->prepare($query);
                            $statement->execute(
                                array(
                                    'uid' => $uid
                                )
                            );
                            $result = $statement->fetchAll();
                            foreach ($result as $row) {
                                $username = $row['username'];
                            }
                            echo "
                                    <li class='nav-item dropdown'>
                                        <a class='nav-link btn btn-custom dropdown-toggle text-dark' href='' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                            <img src='assets/send.png' width='35' height='35' class='rounded-circle d-inline-block align-center' alt=''>&nbsp;$username
                                        </a>
                                        <div class='dropdown-menu' aria-labelledby='navbarDropdown'>
                                            <a class='dropdown-item' href='profile'>Profile</a>
                                            <a class='dropdown-item' href='wallet'>Wallet</a>
                                            <a class='dropdown-item' href='logout'>Logout</a>
                                        </div>
                                    </li>
                                    ";
                        }
                        ?>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="container">
            <div class="row my-5 pt-2">
                <div class="col-lg-8 col-md-8 col-12">
                    <div class="card w-75 mx-auto shadow">
                        <div class="card-body">
                            <h5 class="text-center text-heading">Affilate Program</h5>
                            <hr>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Placeat ipsa reiciendis nesciunt dignissimos minima commodi iure molestias, id consequatur neque, quasi rerum soluta nobis voluptas delectus quaerat pariatur, nihil incidunt! Lorem ipsum dolor, sit amet consectetur adipisicing elit. At possimus adipisci nisi ullam quis voluptatum fuga? Cumque harum ipsum repellat pariatur. Eligendi deleniti architecto saepe in officiis expedita quaerat excepturi!</p>
                            <hr>
                            <button class="btn btn-primary btn-block">Join Us</button>
                            <br>
                        </div>
                    </div>

                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <img src="assets/affilate.svg" alt="" class="img-fluid animated-element">
                </div>
            </div>
        </div>
    </section>
    <!-- section header -->
    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="staticBackdropLabel">Sign In</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mx-auto">
                    <form action="#" id="signinform" method="POST">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <input type="text" name="username" class="form-control rounded-right" placeholder="Username">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-key"></i>
                                    </div>
                                    <input type="password" name="password" class="form-control rounded-right" placeholder="Password">
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="form-group">
                        <button type="button" onclick="signIn()" class="btn btn-primary btn-block">Sign In</button>
                    </div>
                    <hr>
                    <div class="form-group">
                        <p>Don't have an account ? <a href="signup">Sign Up</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a class="whatsapp-suppurt" target="_blank" href="https://wa.me/9876543210">
        <img src="assets/whatsapp.svg" height="50" width="50" alt="">
    </a>
    <script src="vendors/jquery/jquery-3.5.1.js"></script>
    <script src="vendors/properjs/proper.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Counter-Up/1.0.0/jquery.counterup.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.js"></script>
    <script src="vendors/bootstrap-4.5.3-dist/js/bootstrap.min.js"></script>
    <script src="vendors/fontawesome/js/all.js"></script>
</body>

</html>