<?php

// getting connection

require('connection.php');

if (isset($_GET['auth'])) {
    $auth = $_GET['auth'];
    if ($auth == 'login') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $password_md5 = md5($password);

        if ($username == '') {
            echo "empty_username";
        } elseif ($password == '') {
            echo "empty_password";
        } else {
            $query = "SELECT * FROM admin_users WHERE username = :username";
            $statement = $connection->prepare($query);
            $statement->execute(
                array(
                    'username' => $username
                )
            );
            $count = $statement->rowCount();
            if ($count > 0) {
                $result = $statement->fetchAll();
                foreach ($result as $row) {
                    if ($password_md5 == $row['password']) {
                        setcookie('uid', $row['id'], time() + 3600);
                        echo "success";
                    } else {
                        echo "invalid_password";
                    }
                }
            } else {
                echo "invalid_username";
            }
        }
    }
} elseif (isset($_GET['data'])) {
    $data = $_GET['data'];
    if ($data == 'users') {
        $query = "SELECT * FROM user_data";
        $statement = $connection->prepare($query);
        $statement->execute();
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $id = $row['id'];
            $username = $row['username'];
            $email = $row['email'];
            $phone = $row['phone'];

            echo "
                    <tr>
                        <th scope='col'>$id</th>
                        <th scope='col'>$username</th>
                        <th scope='col'>$email</th>
                        <th scope='col'>$phone</th>
                        <th scope='col'>
                            <a href='viewuser?id=$id' class='btn btn-warning btn-sm shadow'><i class='fas fa-eye'></i>&nbsp;View</a>
                        </th>
                    </tr>
                ";
        }
    } elseif ($data == 'view_user') {
        $id = $_POST['id'];
        $query = "SELECT * FROM user_data WHERE id = :id";
        $statement = $connection->prepare($query);
        $statement->execute(
            array(
                'id' => $id
            )
        );
        $count = $statement->rowCount();
        if ($count > 0) {
            $result = $statement->fetchAll();
            foreach ($result as $row) {
                $username = $row['username'];
                $fname = $row['fname'];
                $lname = $row['lname'];
                $phone = $row['phone'];
                $reg_date = $row['date'];
                $email = $row['email'];
                $reg_date = strtotime($reg_date);
                $reg_date = date('M d Y', $reg_date);
            }

            echo "
                    <div class='row'>
                        <div class='col-lg-4 col-md-4 col-12'>
                            <img src='assets/bg-2.jpg' alt='1' class='rounded img-fluid'>
                        </div>
                        <div class='col-lg-8 col-md-8 col-12'>
                            <h5 class=text-primary my-5''>@$username</h5>
                            <h5 class='text-secondary'>$fname $lname</h5>
                            <h5 class='text-secondary'>$email</h5>
                            <h5 class='text-secondary'>$phone</h5>
                            <h5 class='text-secondary'>$reg_date</h5>
                        </div>
                    </div>
                ";
        }
    } elseif ($data == 'contacts') {
        $query = "SELECT * FROM contact";
        $statement = $connection->prepare($query);
        $statement->execute();
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $id = $row['id'];
            $name = $row['name'];
            $email = $row['email'];
            $comment = $row['comment'];
            $date = $row['date_time'];
            $date = strtotime($date);
            $date = date('M d y', $date);

            echo "
                    <tr>
                        <th scope='col'>$id</th>
                        <th scope='col'>$name</th>
                        <th scope='col'>$email</th>
                        <th scope='col'>$comment</th>
                        <th scope='col'>$date</th>
                    </tr>
                ";
        }
    } elseif ($data == 'exchnages') {
        $query = "SELECT * FROM transection";
        $statement = $connection->prepare($query);
        $statement->execute();
        $rowCount = $statement->rowCount();
        if ($rowCount > 0) {
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $id = $row['id'];
                $username = $row['username'];
                $recived_amount = $row['sent_amount'];
                $havetoSend = $row['recive_amount'];
                $reazorpayId = $row['pay_id'];
                $status = $row['status'];
                $date = $row['date'];
                $date = strtotime($date);
                $date = date('Y m d', $date);

                echo "
                        <tr>
                            <th scope='col'>$id</th>
                            <th scope='col'>$username</th>
                            <th scope='col'>$recived_amount</th>
                            <th scope='col'>$havetoSend</th>
                            <th scope='col'>$reazorpayId</th>
                            <th scope='col'>$status</th>
                            <th scope='col'>$date</th>
                            <th scope='col'>
                                <a href='transdetails?id=$id' class='btn btn-warning btn-sm shadow'><i class='fas fa-eye'></i>&nbsp;View</a>
                            </th>
                        </tr>
                    ";
            }
        }
    } elseif ($data == 'transection') {
        $viewId = $_POST['id'];
        $query = "SELECT * FROM exchnages WHERE id = :id";
        $statement = $connection->prepare($query);
        $statement->execute(
            array(
                'id' => $viewId
            )
        );
        $rowCount = $statement->rowCount();
        if ($rowCount > 0) {
            $result = $statement->fetchAll();
            foreach ($result as $row) {
                $username = $row['username'];
                $recivedAmount = $row['sent_amount'];
                $transferAmount = $row['recive_amount'];
                $transection_id = $row['transection_id'];
                $razorypaId = $row['pay_id'];
                $bankName = $row['bank'];
                $account = $row['account'];
                $ifsc = $row['ifsc'];
                $status = $row['status'];
                $date = $row['date'];
                $date = strtotime($date);
                $date = date('d M Y', $date);

                echo "
                        <h5 class='text-center'>Exchnage Details</h5>
                        <hr>
                        <div class='row'>
                            <div class='col-6'><h5><strong>Sender Username : </strong></h5></div>
                            <div class='col-6'><h5>$username</h5></div>
                            <div class='col-6'><h5><strong>Recived Amount : </strong></h5></div>
                            <div class='col-6'><h5>$recivedAmount</h5></div>
                            <div class='col-6'><h5><strong>Transfer Amount : </strong></h5></div>
                            <div class='col-6'><h5>$transferAmount</h5></div>
                            <div class='col-6'><h5><strong>Transection ID : </strong></h5></div>
                            <div class='col-6'><h5>$transection_id</h5></div>
                            <div class='col-6'><h5><strong>Razorpay ID : </strong></h5></div>
                            <div class='col-6'><h5>$razorypaId</h5></div>
                            <div class='col-6'><h5><strong>Bank Name : </strong></h5></div>
                            <div class='col-6'><h5>$bankName</h5></div>
                            <div class='col-6'><h5><strong>Account No : </strong></h5></div>
                            <div class='col-6'><h5>$account</h5></div>
                            <div class='col-6'><h5><strong>IFSC CODE : </strong></h5></div>
                            <div class='col-6'><h5>$ifsc</h5></div>
                            <div class='col-6'><h5><strong>Date : </strong></h5></div>
                            <div class='col-6'><h5>$date</h5></div>
                            <div class='col-6'><h5><strong>Status : </strong></h5></div>
                            <div class='col-6'>
                                <form actuin='#' method='post' id='exchnage-update'>
                                    <div class='form-group'>
                                        <input type='hidden' name='transid' value='$viewId'>
                                        <select class='form-control' name='status'>
                                            <option value='$status'>$status</option>
                                            <option value='accepted'>accepted</option>
                                            <option value='rejected'>rejected</option>
                                            <option value='complete'>complete</option>
                                            <option value='bank process'>bank process</option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                            <div class='col-12'>
                                <button type='button' onClick='updateTrans()' class='btn btn-outline-primary btn-block'>Update</button>
                            </div>
                        </div>
                    ";
            }
        }
    } elseif ($data == 'rate') {
        $query = "SELECT * FROM exchnage_rate";
        $statement = $connection->prepare($query);
        $statement->execute();
        $rowCount = $statement->rowCount();
        if ($rowCount > 0) {
            $result = $statement->fetchAll();
            foreach ($result as $row) {
                $id = $row['id'];
                $currency = $row['currency'];
                $fee = $row['rate'];

                echo "
                        <tr>
                            <th scope='col'>$id</th>
                            <th scope='col'>$currency</th>
                            <th scope='col'>$fee</th>
                            <th scope='col'>
                                <a href='ratedetails?id=$id' class='btn btn-warning btn-sm shadow'><i class='fas fa-eye'></i>&nbsp;View</a>
                            </th>
                        </tr>
                    ";
            }
        }
    } elseif ($data == 'ratedata') {
        $id = $_POST['id'];
        $query = "SELECT * FROM exchnage_rate WHERE id = :id";
        $statement = $connection->prepare($query);
        $statement->execute(
            array(
                'id' => $id,
            )
        );
        $rowCount = $statement->rowCount();
        if ($rowCount > 0) {
            $result = $statement->fetchAll();
            foreach ($result as $row) {
                $id = $row['id'];
                $currency = $row['currency'];
                $fee = $row['rate'];

                echo "  <h5 class='text-center'>Exchnage Rate</h5>
                        <hr>
                        <form action='#' method='POST' id='rate-form'>
                            <div class='row'>
                                
                                <div class='col-12'>
                                    <div class='form-group'>
                                        <label for='id'>Id</label>
                                        <input type='text' value='$id' class='form-control' disabled>
                                        <input type='hidden' name='id' value='$id' class='form-control'>
                                    </div>
                                    <div class='form-group'>
                                        <label for='currency'>Currency</label>
                                        <input type'text' name='currency' value='$currency' class='form-control'>
                                    </div>
                                    <div class='form-group'>
                                        <label for='fee'>Fee (%)</label>
                                        <input type'number' name='fee' value='$fee' class='form-control'>
                                    </div>
                                    <br>
                                    <div class='form-group'>
                                        <button type='button' onClick='reatechange()' class='btn btn-primary btn-block'>Chnage Details</button>
                                    </div>
                                </div>
                                
                            </div>
                        </form>
                    ";
            }
        }
    }
} elseif (isset($_GET['update'])) {
    $update = $_GET['update'];
    if ($update == 'exchnage') {
        $transid = $_POST['transid'];
        $status = $_POST['status'];

        try {
            $update = "UPDATE transection SET status = '$status' WHERE id = $transid";
            $connection->exec($update);
            echo "success";
        } catch (PDOException $e) {
            echo "Faield : " . $e->getMessage();
        }
    } elseif ($update == 'rate') {
        $id = $_POST['id'];
        $currency = $_POST['currency'];
        $fee = $_POST['fee'];
        try {
            $update = "UPDATE exchnage_rate SET rate = '$fee' WHERE id = '$id'";
            $connection->exec($update);
            echo "success";
        } catch (PDOException $e) {
            echo "Faield : " . $e->getMessage();
        }
    }
}