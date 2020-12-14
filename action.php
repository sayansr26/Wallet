<?php

require('include/config.php');


if (isset($_GET['setup'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $passwordMd5 = md5($password);
    $balance = "0";
    $phone = $_POST['phone'];
    if ($fname == '') {
        echo 'empty_fname';
    } elseif ($lname == '') {
        echo 'empty_lname';
    } elseif ($username == '') {
        echo 'empty_username';
    } elseif ($email == '') {
        echo 'empty_email';
    } elseif ($password == '') {
        echo 'empty_password';
    } elseif ($cpassword == '') {
        echo 'empty_cpassword';
    } elseif ($phone == '') {
        echo 'empty_phone';
    } else {
        $query = "SELECT * FROM user_data WHERE username = :username";
        $statement = $connection->prepare($query);
        $statement->execute(
            array(
                'username' => $username
            )
        );
        $rowCount = $statement->rowCount();
        if ($rowCount > 0) {
            echo 'username_error';
        } else {
            $query = "SELECT * FROM user_data WHERE email = :email";
            $statement = $connection->prepare($query);
            $statement->execute(
                array(
                    'email' => $email
                )
            );
            $rowCount = $statement->rowCount();
            if ($rowCount > 0) {
                echo 'email_error';
            } else {
                try {
                    $insert = "INSERT INTO user_data(fname,lname, email, username, phone, password, balance, date) VALUES('$fname','$lname','$email','$username','$phone', '$passwordMd5','$balance',now())";
                    $connection->exec($insert);
                    $uid = $connection->lastInsertId();
                    setcookie('uid', $uid, time() + 3600);
                    echo 'success';
                } catch (PDOException $e) {
                    echo "Faield : " . $e->getMessage();
                }
            }
        }
    }
} elseif (isset($_GET['transfer'])) {
    $balance = $_POST['balance'];
    $username = $_POST['username'];
    $sentamount = $_POST['sentamount'];
    if ($sentamount == '') {
        $sentamount = "0";
        echo "transfer?username=$username&balance=$balance&sentamount=$sentamount";
    } else {
        echo "transfer?username=$username&balance=$balance&sentamount=$sentamount";
    }
} elseif (isset($_GET['auth'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $passwordMd5 = md5($password);
    if ($username == '') {
        echo 'empty_username';
    } elseif ($password == '') {
        echo 'empty_password';
    } else {
        $query = "SELECT * FROM user_data WHERE username = :username";
        $statement = $connection->prepare($query);
        $statement->execute(
            array(
                'username' => $username
            )
        );
        $rowCount = $statement->rowCount();
        if ($rowCount > 0) {
            $result = $statement->fetchAll();
            foreach ($result as $row) {
                if ($passwordMd5 == $row['password']) {
                    setcookie('uid', $row['id'], time() + 3600);
                    echo "success";
                } else {
                    echo "invalid_password";
                }
            }
        } else {
            echo "inavlid_username";
        }
    }
} elseif (isset($_GET['process'])) {
    $username = $_POST['username'];
    $balance = $_POST['balance'];
    $sentamount = $_POST['sentamount'];
    $charge = $_POST['charge'];
    $ban = $_POST['ban'];
    $account = $_POST['account'];
    $ifsc = $_POST['ifsc'];
    $bank = $_POST['bank'];
    $total = $_POST['total'];

    echo "confirm?username=$username&ban=$ban&balance=$balance&sentamount=$sentamount&charge=$charge&account=$account&ifsc=$ifsc&bank=$bank&total=$total";
} elseif (isset($_GET['exchnage'])) {
    $exchnageType = $_GET['exchnage'];
    if ($exchnageType == '1') {
        $username = $_POST['username'];
        $pay_id = $_POST['pay_id'];
        $transection = $_POST['transection'];
        $ban = $_POST['ban'];
        $bank = $_POST['bank'];
        $account = $_POST['account'];
        $ifsc = $_POST['ifsc'];
        $sentamount = $_POST['sentamount'];
        $charge = $_POST['charge'];
        $total = $_POST['total'];
        $balance = $_POST['balance'];
        $email = "";
        $subject = "Transection Successfull";
        $body = "Transection successfull amount paid $sentamount & transection id $transection <br> Thank You for using our services. Team Digitalcash";

        try {
            $insert = "INSERT INTO transection(amount, charge, total, type, date, username, ban, account, ifsc, bank, transectionid, razorpay,status) VALUES('$sentamount','$charge','$total', '1',now(),'$username','$ban','$account','$ifsc','$bank','$transection','$pay_id','accepted')";
            $connection->exec($insert);
            try {
                $update = "UPDATE user_data SET balance = '0' WHERE username = '$username'";
                $connection->exec($update);
                $query = "SELECT * FROM user_data WHERE username = :username";
                $statement = $connection->prepare($query);
                $statement->execute(
                    array(
                        'username' => $username
                    )
                );
                $result = $statement->fetchAll();
                foreach ($result as $row) {
                    $email = $row['email'];
                }
                require 'vendors/smtp/PHPMailerAutoload.php';
                $mail = new PHPMailer;
                // $mail->SMTPDebug = 4;
                $mail->isSMTP();
                $mail->Host = 'mail.siaaw.tk';
                $mail->SMTPAuth = true;
                $mail->Username = 'info@siaaw.tk';
                $mail->Password = 'Sayan@159';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
                $mail->IsHTML(true);
                $mail->setFrom('info@siaaw.tk', 'no-reply');
                $mail->addAddress($email);
                $mail->addAddress('info.zestwallet@gmail.com');
                $mail->Subject = $subject;
                $mail->Body = $body;
                if (!$mail->send()) {
                    echo "error";
                } else {
                    $id = $connection->lastInsertId();
                    echo "success?type=1&transectionid=$transection&senetamount=$sentamount&charge=$charge&total=$total&status=accepted";
                }
                // echo "success?type=1&transectionid=$transection&senetamount=$sentamount&charge=$charge&total=$total&status=accepted";
            } catch (PDOException $e) {
                echo "Faield : " . $e->getMessage();
            }
        } catch (PDOException $e) {
            echo "Faield : " . $e->getMessage();
        }
    } elseif ($exchnageType == '2') {
        $username = $_POST['username'];
        $transection = $_POST['transection'];
        $ban = $_POST['ban'];
        $bank = $_POST['bank'];
        $account = $_POST['account'];
        $ifsc = $_POST['ifsc'];
        $sentamount = $_POST['sentamount'];
        $charge = $_POST['charge'];
        $total = $_POST['total'];
        $balance = $_POST['balance'];
        $new = $balance - $total;
        $email = "";
        $subject = "Transection Successfull";
        $body = "Transection successfull amount paid $sentamount & transection id $transection <br> Thank You for using our services. Team Digitalcash";
        try {
            $insert = "INSERT INTO transection(amount, charge, total, type, date, username, ban, account, ifsc, bank, transectionid,status) VALUES('$sentamount','$charge','$total', '1',now(),'$username','$ban','$account','$ifsc','$bank','$transection','accepted')";
            $connection->exec($insert);
            try {
                $update = "UPDATE user_data SET balance = '$new' WHERE username = '$username'";
                $connection->exec($update);
                $query = "SELECT * FROM user_data WHERE username = :username";
                $statement = $connection->prepare($query);
                $statement->execute(
                    array(
                        'username' => $username
                    )
                );
                $result = $statement->fetchAll();
                foreach ($result as $row) {
                    $email = $row['email'];
                }
                require 'vendors/smtp/PHPMailerAutoload.php';
                $mail = new PHPMailer;
                // $mail->SMTPDebug = 4;
                $mail->isSMTP();
                $mail->Host = 'mail.siaaw.tk';
                $mail->SMTPAuth = true;
                $mail->Username = 'info@siaaw.tk';
                $mail->Password = 'Sayan@159';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
                $mail->IsHTML(true);
                $mail->setFrom('info@siaaw.tk', 'no-reply');
                $mail->addAddress($email);
                $mail->addAddress('info.zestwallet@gmail.com');
                $mail->Subject = $subject;
                $mail->Body = $body;
                if (!$mail->send()) {
                    echo "error";
                } else {
                    $id = $connection->lastInsertId();
                    echo "success?type=1&transectionid=$transection&senetamount=$sentamount&charge=$charge&total=$total&status=accepted";
                }
                // echo "success?type=1&transectionid=$transection&senetamount=$sentamount&charge=$charge&total=$total&status=accepted";
            } catch (PDOException $e) {
                echo 'Faield : ' . $e->getMessage();
            }
        } catch (PDOException $e) {
            echo 'Faield : ' . $e->getMessage();
        }
    } elseif ($exchnageType == '3') {
        $username = $_POST['username'];
        $tarnsection = $_POST['tarnsection'];
        $amount = $_POST['amount'];
        $charge = $_POST['charge'];
        $balance = $_POST['balance'];
        $bank = $_POST['bank'];
        $account = $_POST['account'];
        $confirm = $_POST['confirm'];
        $ifsc = $_POST['ifsc'];
        $type = '3';
        $status = 'accepted';
        $persantage = $charge / 100;
        $fee = $amount * $persantage;
        $total = $amount + $fee;
        $avilable = $balance - $total;
        $email = "";
        $subject = "Transection Successfull";
        $body = "Transection successfull amount paid $amount & transection id $tarnsection <br> Thank You for using our services. Team Digitalcash";
        try {
            $insert = "INSERT INTO transection(amount, charge, total, type, date, username, transectionid, status) VALUES('$amount','$fee','$total','$type',now(),'$username','$tarnsection','$status')";
            $connection->exec($insert);
            try {
                $update = "UPDATE user_data SET balance = '$avilable' WHERE username = '$username'";
                $connection->exec($update);
                $query = "SELECT * FROM user_data WHERE username = :username";
                $statement = $connection->prepare($query);
                $statement->execute(
                    array(
                        'username' => $username
                    )
                );
                $result = $statement->fetchAll();
                foreach ($result as $row) {
                    $email = $row['email'];
                }
                require 'vendors/smtp/PHPMailerAutoload.php';
                $mail = new PHPMailer;
                // $mail->SMTPDebug = 4;
                $mail->isSMTP();
                $mail->Host = 'mail.siaaw.tk';
                $mail->SMTPAuth = true;
                $mail->Username = 'info@siaaw.tk';
                $mail->Password = 'Sayan@159';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
                $mail->IsHTML(true);
                $mail->setFrom('info@siaaw.tk', 'no-reply');
                $mail->addAddress($email);
                $mail->addAddress('info.zestwallet@gmail.com');
                $mail->Subject = $subject;
                $mail->Body = $body;
                if (!$mail->send()) {
                    echo "error";
                } else {
                    $id = $connection->lastInsertId();
                    echo "success?type=3&transectionid=$tarnsection&senetamount=$amount&charge=$charge&total=$total&status=accepted";
                }
                // echo "success?type=3&transectionid=$tarnsection&senetamount=$amount&charge=$charge&total=$total&status=accepted";
            } catch (PDOException $e) {
                echo 'Faield : ' . $e->getMessage();
            }
        } catch (PDOException $e) {
            echo 'Faield : ' . $e->getMessage();
        }
    } elseif ($exchnageType == '4') {
        $username = $_POST['username'];
        $pay_id = $_POST['pay_id'];
        $transection = $_POST['transection'];
        $amount = $_POST['amount'];
        $newbalance = $_POST['newbalance'];
        $type = '4';
        $charge = 0;
        $total = $amount;
        $email = "";
        $subject = "Transection Successfull";
        $body = "Transection successfull amount paid $amount & transection id $transection <br> Thank You for using our services. Team Digitalcash";

        try {
            $insert = "INSERT INTO transection(amount, charge, total, type, date, username, razorpay, transectionid, status) VALUES('$amount','$charge','$total','$type',now(),'$username','$pay_id','$transection','accepted')";
            $connection->exec($insert);
            // echo 'success';
            try {
                $update = "UPDATE user_data SET balance = '$newbalance' WHERE username = '$username'";
                $connection->exec($update);
                $query = "SELECT * FROM user_data WHERE username = :username";
                $statement = $connection->prepare($query);
                $statement->execute(
                    array(
                        'username' => $username
                    )
                );
                $result = $statement->fetchAll();
                foreach ($result as $row) {
                    $email = $row['email'];
                }
                require 'vendors/smtp/PHPMailerAutoload.php';
                $mail = new PHPMailer;
                // $mail->SMTPDebug = 4;
                $mail->isSMTP();
                $mail->Host = 'mail.siaaw.tk';
                $mail->SMTPAuth = true;
                $mail->Username = 'info@siaaw.tk';
                $mail->Password = 'Sayan@159';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
                $mail->IsHTML(true);
                $mail->setFrom('info@siaaw.tk', 'no-reply');
                $mail->addAddress($email);
                $mail->addAddress('info.zestwallet@gmail.com');
                $mail->Subject = $subject;
                $mail->Body = $body;
                if (!$mail->send()) {
                    echo "error";
                } else {
                    $id = $connection->lastInsertId();
                    echo "success?type=4&transectionid=$transection&senetamount=$amount&charge=$charge&total=$total&status=accepted";
                }
                // echo "success?type=4&transectionid=$transection&senetamount=$amount&charge=$charge&total=$total&status=accepted";
            } catch (PDOException $e) {
                echo 'Faield : ' . $e->getMessage();
            }
        } catch (PDOException $e) {
            echo 'Faield : ' . $e->getMessage();
        }
    }
} elseif (isset($_GET['change'])) {
    $username = $_POST['username'];
    $oldPassword = $_POST['oldpassword'];
    $newPassword = $_POST['newpassword'];
    $confirmPassword = $_POST['cpassword'];
    $passwordMd5 = md5($oldPassword);
    $newPasswordMd5 = md5($newPassword);
    if ($oldPassword == '') {
        echo "empty_old_password";
    } elseif ($newPassword == '') {
        echo "empty_new_password";
    } elseif ($confirmPassword == '') {
        echo "empty_confirm_password";
    } elseif ($newPassword != $confirmPassword) {
        echo "password_mismatch";
    } else {
        $query = "SELECT * FROM user_data WHERE username = :username AND password = :password";
        $statement = $connection->prepare($query);
        $statement->execute(
            array(
                'username' => $username,
                'password' => $passwordMd5
            )
        );
        $rowCount = $statement->rowCount();
        if ($rowCount > 0) {
            try {
                $update = "UPDATE user_data SET password = '$newPasswordMd5' WHERE username = '$username'";
                $connection->exec($update);
                echo "success";
            } catch (PDOException $e) {
                echo "Faield : " . $e->getMessage();
            }
        } else {
            echo "password_error";
        }
    }
} elseif (isset($_GET['contact'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $comment = $_POST['comment'];
    if ($name == '') {
        echo 'empty_name';
    } elseif ($email == '') {
        echo 'empty_email';
    } elseif ($phone == '') {
        echo 'empty_phone';
    } elseif ($comment == '') {
        echo 'empty_comment';
    } else {
        try {
            $insert = "INSERT INTO contact(name, email, phone, comment, date) VALUES('$name', '$email', '$phone','$comment', now())";
            $connection->exec($insert);
            echo "success";
        } catch (PDOException $e) {
            echo "Faield : " . $e->getMessage();
        }
    }
} elseif (isset($_GET['track'])) {
    $transectionid = $_POST['transectionid'];
    $query = "SELECT * FROM exchnages WHERE transection_id = :transection_id";
    $statement = $connection->prepare($query);
    $statement->execute(
        array(
            'transection_id' => $transectionid
        )
    );
    $rowCount = $statement->rowCount();
    if ($rowCount > 0) {
        $result = $statement->fetchAll();
        foreach ($result as $row) {
            $status = $row['status'];
            $sent_amount = $row['sent_amount'];
            $recive_amount = $row['recive_amount'];
            $date = $row['date'];
            $date = strtotime($date);
            $date = date('M d y', $date);
        }
        echo "
                <div class='card-body'>
                    <h5 class='text-center text-heading'>Transection Details</h5>
                    <hr>
                    <div class='form-group'>
                        <label for='form-group'>Status :</label>
                        <input type='text' value='$status' class='form-control' disabled>
                    </div>
                    <div class='form-group'>
                        <label for='username'>Paid Amount :</label>
                        <input type='text' value='₹&nbsp;$sent_amount' class='form-control' disabled>
                    </div>
                    <div class='form-group'>
                        <label for='username'>Sattelment Amount :</label>
                        <input type='text' value='₹&nbsp;$recive_amount' class='form-control' disabled>
                    </div>
                    <div class='form-group'>
                        <label for='username'>Transectio Date :</label>
                        <input type='text' value='$date' class='form-control' disabled>
                    </div>
                    <hr>
                    <a href='track' class='btn btn-primary btn-block'>Track Again</a>
                </div>
            ";
    } else {
        echo "
                <div class='card-body'>
                    <div class='alert alert-warning rounded text-whte'>Transection not found ! check transection id</div>
                    <hr>
                    <a href='track' class='btn btn-primary btn-block'>Track Again</a>
                </div>
            ";
    }
} elseif (isset($_GET['forget'])) {
    $email = $_POST['email'];
    $token = rand(1000, 9999);
    $token = md5($token);
    $subject = "Password Recover";
    $body = "https://wallet.demo/verify?token=$token";
    $query = "SELECT * FROM user_data WHERE email = :email";
    $statement = $connection->prepare($query);
    $statement->execute(
        array(
            'email' => $email
        )
    );
    $rowCount = $statement->rowCount();
    if ($rowCount > 0) {
        try {
            $insert = "INSERT INTO verify_data(email, token, date) VALUES('$email', '$token', now()) ";
            $connection->exec($insert);
            require 'vendors/smtp/PHPMailerAutoload.php';
            $mail = new PHPMailer;
            // $mail->SMTPDebug = 4;
            $mail->isSMTP();
            $mail->Host = 'mail.siaaw.tk';
            $mail->SMTPAuth = true;
            $mail->Username = 'info@siaaw.tk';
            $mail->Password = 'Sayan@159';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            $mail->IsHTML(false);
            $mail->setFrom('info@siaaw.tk', 'no-reply');
            $mail->addAddress($email);
            $mail->addAddress('info.zestwallet@gmail.com');
            $mail->Subject = $subject;
            $mail->Body = $body;
            if (!$mail->send()) {
                echo "error";
            } else {
                echo "success";
            }
            // echo "success";
        } catch (PDOException $e) {
            echo "Faield : " . $e->getMessage();
        }
    } else {
        echo "email_error";
    }
} elseif (isset($_GET['verify'])) {
    $email = $_POST['email'];
    $token = $_POST['token'];
    $password = $_POST['password'];
    $passwordMd5 = md5($password);
    $used = "no";

    $query = "SELECT * FROM verify_data WHERE token = :token AND used = :used";
    $statement = $connection->prepare($query);
    $statement->execute(
        array(
            'token' => $token,
            'used' => $used,
        )
    );
    $rowCount = $statement->rowCount();
    if ($rowCount > 0) {
        try {
            $update = "UPDATE user_data SET password = '$passwordMd5' WHERE email = '$email'";
            $connection->exec($update);
            try {
                $update2 = "UPDATE verify_data SET used = 'yes' WHERE token = '$token'";
                $connection->exec($update2);
                $userquery = "SELECT * FROM user_data WHERE email = :email";
                $statement = $connection->prepare($userquery);
                $statement->execute(
                    array(
                        'email' => $email
                    )
                );
                $result = $statement->fetchAll();
                foreach ($result as $row) {
                    setcookie('uid', $row['id'], time() + 3600);
                    echo "success";
                }
            } catch (PDOException $e) {
                echo "Faield : " . $e->getMessage();
            }
        } catch (PDOException $e) {
            echo "Faield : " . $e->getMessage();
        }
    } else {
        echo "link_used";
    }
}
