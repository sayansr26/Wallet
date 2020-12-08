<?php
require('include/config.php');
require('include/function.php');
require_once('vendors/razorpay-php/Razorpay.php');

use Razorpay\Api\Api;

if (login()) {

    if (isset($_GET['username'])) {
        $username = $_GET['username'];
        $ban = $_GET['ban'];
        $balance = $_GET['balance'];
        $sentamount = $_GET['sentamount'];
        $charge = $_GET['charge'];
        $account = $_GET['account'];
        $ifsc = $_GET['ifsc'];
        $bank = $_GET['bank'];
        $total = $_GET['total'];
        $transectionId = rand(10, 99);
        $transectionIdProtect = sha1($transectionId);
        $balanceToAdd = 0;
        if ($total > $balance) {
            $balanceToAdd = $total - $balance;
            $razorpayBalance  = $balanceToAdd * 100;
        }
    }
    $keyId = 'rzp_test_n3hzno9GxC7dTy';
    $secretKey = 'dG2RVfWFPxx9Tn49mZR550kB';
    $api = new Api($keyId, $secretKey);
    $order = $api->order->create(array(
        'receipt' => $transectionIdProtect,
        'amount' => $razorpayBalance,
        'payment_capture' => 1,
        'currency' => 'INR'
    ));
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="vendors/bootstrap-4.5.3-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="vendors/fontawesome/css/all.css">
        <link rel="stylesheet" href="css/exchange.css">
        <title>Exchange - Confirm</title>
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
                <div class="row pt-2">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div id="details" class="card w-75 shadow">
                            <div class="card-body">
                                <form action="" method="POST" id="pay-data">
                                    <h5 class="text-center text-heading">Details Confirm</h5>
                                    <hr>
                                    <div class="form-group">
                                        <label for="username">Sender Name :</label>
                                        <input type="text" value="<?php echo $ban; ?>" class="form-control" disabled>
                                        <input type="hidden" name="ban" value="<?php echo $ban; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="username">Bank Name :</label>
                                        <input type="text" value="<?php echo $bank; ?>" class="form-control" disabled>
                                        <input type="hidden" name="bank" value="<?php echo $bank; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="username">Account No. :</label>
                                        <input type="text" value="<?php echo $account; ?>" class="form-control" disabled>
                                        <input type="hidden" name="account" value="<?php echo $account; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="username">IFSC CODE :</label>
                                        <input type="text" value="<?php echo $ifsc; ?>" class="form-control" disabled>
                                        <input type="hidden" name="ifsc" value="<?php echo $ifsc; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="username">Sent Amount :</label>
                                        <input type="text" value="<?php echo $sentamount; ?>" class="form-control" disabled>
                                        <input type="hidden" name="sentamount" value="<?php echo $sentamount; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="username">Charge :</label>
                                        <input type="text" value="<?php echo $charge; ?>" class="form-control" disabled>
                                        <input type="hidden" name="charge" value="<?php echo $charge; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="username">Total payble amount :</label>
                                        <input type="text" value="<?php echo $total; ?>" class="form-control" disabled>
                                        <input type="hidden" name="total" value="<?php echo $total; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="username">Wallet Balance :</label>
                                        <input type="text" value="<?php echo $balance; ?>" class="form-control" disabled>
                                        <input type="hidden" name="balance" value="<?php echo $balance; ?>">
                                    </div>
                                    <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
                                    <input type="hidden" name="pay_id" id="pay_id">
                                    <input type="hidden" name="transection" id="transection" value="<?php echo $transectionIdProtect; ?>">
                                    <?php
                                    if ($balanceToAdd > 0) {
                                        echo "      <div class='form-group'>
                                                        <button class='btn btn-primary btn-block' id='rzp-button1'>Add ₹ $balanceToAdd & Transfer</button>
                                                    </div>
                                                    
                                                ";
                                    } else {
                                        echo "
                                                    <div class='form-group'>
                                                        <button type='button' onclick='transfer()' class='btn btn-primary btn-block'>Transfer Now</button>
                                                    </div>
                                                ";
                                    }
                                    ?>

                                </form>
                            </div>
                            <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
                            <script>
                                var options = {
                                    "key": "<?php echo $keyId; ?>", // Enter the Key ID generated from the Dashboard
                                    "amount": "<?php echo $order->amount; ?>", // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
                                    "currency": "INR",
                                    "name": "Exchange",
                                    "description": "Test Transaction",
                                    "image": "https://picsum.photos/500",
                                    "order_id": "<?php echo $order->id ?>",
                                    "handler": function(response) {
                                        $('#pay_id').val(response.razorpay_payment_id);
                                        $.ajax({
                                            url: 'action.php?exchnage=1',
                                            type: 'post',
                                            data: $('#pay-data').serialize(),
                                            success: function(respo) {
                                                // alert(respo);
                                                if (respo.indexOf('success') != -1) {
                                                    // alert("redirect");
                                                    window.location.href = respo;
                                                } else {
                                                    alert(respo);
                                                }
                                            }
                                        });
                                    },
                                    "prefill": {
                                        "name": "Test Gatway",
                                        "email": "info@example.com",
                                        "contact": "9999999999"
                                    },
                                    "notes": {
                                        "address": "Razorpay Corporate Office"
                                    },
                                    "theme": {
                                        "color": "#40bf19"
                                    }
                                };
                                var rzp1 = new Razorpay(options);
                                rzp1.on('payment.failed', function(response) {
                                    alert(response.error.code);
                                    alert(response.error.description);
                                    alert(response.error.source);
                                    alert(response.error.step);
                                    alert(response.error.reason);
                                    alert(response.error.metadata.order_id);
                                    alert(response.error.metadata.payment_id);
                                });
                                document.getElementById('rzp-button1').onclick = function(e) {
                                    rzp1.open();
                                    e.preventDefault();
                                }
                            </script>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <img src="assets/bank.svg" alt="" class="img-fluid animated-element">
                    </div>
                </div>
            </div>
        </section>
        <br>
        <a class="whatsapp-suppurt" target="_blank" href="https://wa.me/9876543210">
            <img src="assets/whatsapp.svg" height="50" width="50" alt="">
        </a>
        <!-- section header -->
        <script src="vendors/jquery/jquery-3.5.1.js"></script>
        <script src="vendors/bootstrap-4.5.3-dist/js/bootstrap.min.js"></script>
        <script src="vendors/fontawesome/js/all.js"></script>
        <script>
            function transfer() {
                $.ajax({
                    url: 'action.php?exchnage=2',
                    type: 'post',
                    data: $('#pay-data').serialize(),
                    success: function(response) {
                        window.location.href = response;
                    }
                });
            }
        </script>
    </body>

    </html>
<?php
} else {
    header('location:login');
}
?>