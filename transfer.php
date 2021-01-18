<?php
require('include/config.php');
require('include/function.php');
if (login()) {
    $username = "";
    $balance = "";
    $sentamount = "";
    $exchangeRate = "";
    $charge = "";
    $total = "";






    if (isset($_GET['username'])) {
        $username = $_GET['username'];
        $balance = $_GET['balance'];
        $sentamount = $_GET['sentamount'];

        $phoneQuery = "SELECT * FROM user_data WHERE username = :username";
        $statement = $connection->prepare($phoneQuery);
        $statement->execute(
            array(
                'username' => $username
            )
        );
        $result  = $statement->fetchAll();
        foreach ($result as $row) {
            $phone = $row['phone'];

            $accountQuery = "SELECT * FROM accounts WHERE phone = :phone";
            $statement = $connection->prepare($accountQuery);
            $statement->execute(
                array(
                    'phone' => $phone
                )
            );
            $rowCount = $statement->rowCount();
            $result = $statement->fetchAll();
            if ($rowCount > 0) {
                foreach ($result as $row) {
                    $ban = $row['banificary'];
                    $acc = $row['account'];
                    $isc = $row['ifsc'];
                    $bank = $row['bank_name'];
                    $banificary = "
                                <div class='form-group'>
                                    <div class='form_div'>
                                        <input type='text' class='form_input' placeholder=' ' disabled value='" . $row['banificary'] . "'>
                                        <label for='ban' id='ban-label' class='form_label'>Banificary Name</label>
                                    </div>
                                </div>   
                                ";
                    $account = "
                        <div class='form-group'>
                            <div class='form_div'>
                                <input type='text' disabled value='" . $row['account'] . "' class='form_input' placeholder=' ' required>
                                <label for='account' id='account-label' class='form_label'>Account Number</label>
                            </div>
                        </div>";
                    $confirmAccount = "";
                    $ifsc = "<div class='form-group'>
                    <div class='form_div'>
                        <input type='text' disabled value='" . $row['ifsc'] . "' class='form_input' placeholder=' ' required>
                        <label for='ifsc' id='ifsc-label' class='form_label'>IFSCCODE</label>
                    </div>
                </div>";
                    $bankName = "<div class='form-group'>
                    <div class='form_div'>
                        <input type='text' disabled value='" . $row['bank_name'] . "' class='form_input' placeholder=' ' required>
                        <label for='bank' id='bank-label' class='form_label'>Bank Name</label>
                    </div>
                </div> ";
                }
            } else {
                $banificary = "
                    <div class='form-group'>
                        <div class='form_div'>
                            <input type='text' name='ban' id='ban' class='form_input' placeholder=' ' required>
                            <label for='ban' id='ban-label' class='form_label'>Banificary Name</label>
                        </div>
                    </div>
                ";
                $account = "
                    <div class='form-group'>
                        <div class='form_div'>
                            <input type='text' name='account' id='account' class='form_input' placeholder=' ' required>
                            <label for='account' id='account-label' class='form_label'>Account Number</label>
                        </div>
                    </div> 
                ";
                $confirmAccount = "
                        <div class='form-group'>
                            <div class='form_div'>
                                <input type='text' name='caccount' id='caccount' class='form_input' placeholder=' ' required>
                                <label for='caccount' id='caccount-label' class='form_label'>Confirm Account Number</label>
                            </div>
                        </div>
                    ";
                $ifsc = "
                <div class='form-group'>
                    <div class='form_div'>
                        <input type='text' name='ifsc' id='ifsc' class='form_input' placeholder=' ' required>
                        <label for='ifsc' id='ifsc-label' class='form_label'>IFSCCODE</label>
                    </div>
                </div>
            ";
                $bankName = "
                    <div class='form-group'>
                        <div class='form_div'>
                            <input type='text' name='bank' id='bank' class='form_input' placeholder=' ' required>
                            <label for='bank' id='bank-label' class='form_label'>Bank Name</label>
                        </div>
                    </div> 
                ";
            }
        }
    }

    $rate = "SELECT * FROM exchnage_rate";
    $statement = $connection->prepare($rate);
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        $exchangeRate = $row['rate'];
        $exchangeRate = $exchangeRate / 100;
        $charge = $sentamount * $exchangeRate;
        $total = $sentamount + $charge;
    }

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="vendors/bootstrap-4.5.3-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="vendors/fontawesome/css/all.css">
        <link rel="stylesheet" href="css/exchange.css">
        <title>Exchange - Transfer</title>
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
                                            <a class='nav-link btn btn-custom' data-toggle='modal' data-target='#staticBackdrop'>
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
                    <div class="col-lg-6 col-md-6 col-12">
                        <div id="details" class="card shadow w-75">
                            <div class="card-body">
                                <form action="#" method="POST" id="trasferform">
                                    <input type="hidden" value="<?php echo $balance; ?>" name="balance">
                                    <input type="hidden" value="<?php echo $username; ?>" name="username">
                                    <input type="hidden" value="<?php echo $sentamount; ?>" name="sentamount">
                                    <input type="hidden" value="<?php echo $charge; ?>" name="charge">
                                    <input type="hidden" value="<?php echo $total; ?>" name="total">
                                    <?php
                                    if ($ban != '') {
                                        echo "
                                                <input type='hidden' value='$ban' name='ban'>
                                                <input type='hidden' value='$acc' name='account'>
                                                <input type='hidden' value='$isc' name='ifsc'>
                                                <input type='hidden' value='$bank' name='bank'>
                                            ";
                                    }
                                    ?>
                                    <div class="container">
                                        <h5 class="text-center text-heading">Fill Transfer Details</h5>
                                        <hr>
                                        <div class="form-group">
                                            <div class="form_div">
                                                <input type="text" value="<?php echo $sentamount; ?>" disabled class="form_input" placeholder=" " required>
                                                <label class="form_label">Sent Amount</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form_div">
                                                <input type="text" class="form_input" placeholder=" " disabled value="<?php echo $charge; ?>" required>
                                                <label class="form_label">Fee</label>
                                            </div>
                                        </div>
                                        <?php echo $banificary; ?>
                                        <?php echo $account; ?>
                                        <?php echo $confirmAccount; ?>
                                        <?php echo $ifsc; ?>
                                        <?php echo $bankName; ?>
                                        <div class="form-group">
                                            <div class="form_div">
                                                <input type="text" disabled value="<?php echo $total; ?>" class="form_input" placeholder=" " required>
                                                <label class="form_label">Total Amount</label>
                                            </div>
                                        </div>
                                        <div class="from-group">
                                            <span class="font-small text-secondary"><strong>Note:</strong> You can only transfer money to default account, for changes contact admin</span>
                                        </div>
                                        <br>
                                        <button type="button" onclick="process()" class="btn btn-primary btn-user btn-block">
                                            Prossess
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <img src="assets/bank.svg" alt="" class="img-fluid animated-element">
                    </div>
                </div>
            </div>
        </section>
        <br>
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
        <script>
            function process() {
                var ban = $('#ban').val();
                var account = $('#account').val();
                var caccount = $('#caccount').val();
                var ifsc = $('#ifsc').val();
                var bank = $('#bank').val();
                // alert(ban, account, caccount, ifsc, bank);
                if (ban == '') {
                    alert('Banificary name required');
                } else if (account == '') {
                    alert('Account number required');
                } else if (caccount == '') {
                    alert('Confirm account required');
                } else if (ifsc == '') {
                    alert('IFSC Code required');
                } else if (bank == '') {
                    alert('Bank name required');
                } else if (account != caccount) {
                    alert('Account number not match');
                } else {
                    $.ajax({
                        url: 'action.php?process=1',
                        data: $('#trasferform').serialize(),
                        type: 'post',
                        success: function(response) {
                            window.location.href = response;
                        }
                    });
                }
            }
        </script>
    </body>

    </html>
<?php
} else {
    header('location:login');
}
?>