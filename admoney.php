<?php

require('include/config.php');
require('include/function.php');


if (login()) {
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
        $balance = $row['balance'];
    }
}
$transectionId = rand(10, 99);
$transectionIdProtect = sha1($transectionId);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="vendors/bootstrap-4.5.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendors/fontawesome/css/all.css">
    <link rel="stylesheet" href="css/exchange.css">
    <title>Exchnages - Admoney</title>
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
                        <li class="nav-item">
                            <a class="nav-link" href="affilate">Affilate</a>
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
                            <form action="payment" method="POST" id="addmoney-data">
                                <h5 class="text-center text-heading">Add money</h5>
                                <hr>
                                <div class="form-group">
                                    <div class="form_div">
                                        <input type="number" name="amount" id="amount" class="form_input" placeholder=" " required>
                                        <label for="amount" id="amount-label" class="form_label">Amount Want To Add</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form_div">
                                        <input type="text" name="charge" id="charge" class="form_input" placeholder=" " disabled>
                                        <label for="charge" id="charge-label" class="form_label">Charge 0 %</label>
                                    </div>
                                </div>
                                <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
                                <input type="hidden" name="balance" id="balance" value="<?php echo $balance; ?>">
                                <input type="hidden" name="transection" id="transection" value="<?php echo $transectionIdProtect; ?>">
                                <div class='form-group'>
                                    <button type="submit" class='btn btn-primary btn-block'>Process</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <img src="assets/testimonial.svg" alt="" class="img-fluid animated-element">
                </div>
            </div>
        </div>
    </section>
    <!-- section header -->
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