<?php

require('include/config.php');
require('include/function.php');
$balance = "";
$username = "";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="vendors/bootstrap-4.5.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendors/fontawesome/css/all.css">
    <link rel="stylesheet" href="css/exchange.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <title>Exchnage</title>
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
                        <li class="nav-item active">
                            <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="track">Track</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="affilate">Affilate</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact">Contact</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white font-weight-bold" href="tel://917024394944"><i class="fas fa-phone"></i>&nbsp;&nbsp;+91 7024394944</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav mr-1">
                        <?php
                        if (!login()) {
                            echo "
                                        <li class='nav-item'>
                                            <a href='login' class='nav-link btn btn-custom'>
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
                    <div class="card shadow" data-aos="flip-right">
                        <div class="card-body">
                            <form action="transfer" id="transfer-form" method="POST">
                                <input type="hidden" name="username">
                                <h1 class="text-center font-weight-bold" style="color: #707070;">Zestmoney To Bank Transfer Instantly</h1>
                                <div class="d-flex text-center justify-content-around align-items-center">
                                    <h5 class="card-title text-center"><i class="fas fa-arrow-circle-up"></i>&nbsp;Send</h5>
                                    <h5 class="card-title text-center"><i class="fas fa-arrow-circle-down"></i>&nbsp;Recive</h5>
                                </div>
                                <div class="d-flex text-center justify-content-around align-items-center">
                                    <img src="assets/send.png" class="img-fluid hidden-image" width="75" height="75" alt="">
                                    <select name="send_money" id="send" class="form-control mx-2">
                                        <option value="wallet">ZestMoney</option>
                                    </select>
                                    <select name="recive_money" id="send" class="form-control mx-2">
                                        <option value="bank">Bank Transfer</option>
                                    </select>
                                    <img src="assets/recive.png" class="img-fluid hidden-image" width="75" height="75" alt="">
                                </div>
                                <div class="d-flex text-center justify-content-around align-items-center">
                                    <?php
                                    if (login()) {
                                        $uid = $_COOKIE['uid'];
                                        $balenceInfo = "SELECT * FROM user_data WHERE id = :id";
                                        $statement = $connection->prepare($balenceInfo);
                                        $statement->execute(
                                            array(
                                                'id' => $uid
                                            )
                                        );
                                        $result = $statement->fetchAll();
                                        foreach ($result as $row) {
                                            $balance = $row['balance'];
                                            $username = $row['username'];
                                        }
                                    }

                                    ?>
                                    <input type="hidden" name="username" value="<?php echo $username; ?>">
                                    <input type="number" value="<?php echo $balance; ?>" class="form-control mx-2 my-2" placeholder="Avilable Balance" disabled>
                                    <input type="hidden" id="balance" value="<?php echo $balance; ?>" name="balance">
                                    <input type="number" id="sentamount" name="sentamount" class="form-control mx-2 my-2" placeholder="Ammount to sent">
                                </div>
                                <?php
                                if (login()) {
                                    echo "
                                            <button type='button' onClick='transfer()' class='btn btn-primary btn-block'>
                                                <i class='fas fa-exchange-alt'></i>&nbsp;Transfer
                                            </button>
                                        ";
                                } else {
                                    echo "
                                            <button type='button' onClick='login()' class='btn btn-primary btn-block'>
                                                <i class='fas fa-exchange-alt'></i>&nbsp;Transfer
                                            </button>
                                        ";
                                }
                                ?>
                                <br>
                                <div class="text-center">
                                    <a class="text-center" href=""><img src="assets/download.png" height="50" class="text-center img-fluid" alt="download"></a>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <img src="assets/transfer.svg" alt="" class="img-fluid animated-element">
                </div>
            </div>
        </div>
    </section>
    <!-- section header -->
    <!-- section tracking -->
    <section class="tracking">
        <div class="container">
            <h5 class="text-center text-heading">Overview</h5>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-12">
                    <div class="card mx-auto shadow">
                        <div class="card-body">
                            <h5><i class="fas fa-user"></i></h5>
                            <h5 class="number">5000</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <div class="card mx-auto shadow">
                        <div class="card-body">
                            <h5><i class="fas fa-exchange-alt"></i></h5>
                            <h5 class="number">5000</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <div class="card mx-auto shadow">
                        <div class="card-body">
                            <h5><i class="fas fa-wallet"></i></h5>
                            <h5 class="number">5000</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- section tracking -->
    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="staticBackdropLabel">You Have To Sign In First</h5>
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
    <script>
        $('.number').counterUp({
            delay: 10,
            time: 1000
        });
    </script>
    <script>
        function signIn() {
            $.ajax({
                url: 'action.php?auth=login',
                type: 'POST',
                data: $('#signinform').serialize(),
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

        function login() {
            $('#staticBackdrop').modal('show');
        }

        function transfer() {
            var sentamount = $('#sentamount').val();
            if (sentamount == '') {
                alert('Sent amount is required');
            } else {
                $.ajax({
                    url: 'action.php?transfer=1',
                    data: $('#transfer-form').serialize(),
                    type: 'post',
                    success: function(response) {
                        window.location.href = response;
                    }
                });
            }
        }
    </script>
    <script>
        AOS.init();
    </script>
</body>

</html>