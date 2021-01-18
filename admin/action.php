<?php

require('./include/config.php');

if (isset($_GET['setup'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $md5Password = md5($password);

    if ($fname == '') {
        echo "empty_fname";
    } elseif ($lname == '') {
        echo "empty_lname";
    } elseif ($email == '') {
        echo "empty_email";
    } elseif ($username == '') {
        echo "empty_username";
    } elseif ($phone == '') {
        echo "empty_phone";
    } elseif ($password == '') {
        echo "empty_password";
    } elseif ($cpassword == '') {
        echo "empty_cpassword";
    } elseif ($password != $cpassword) {
        echo "password_mistake";
    } else {
        try {
            $insert = "INSERT INTO admin_users(fname,lname, email, username, phone, password,date) VALUES('$fname','$lname','$email','$username','$phone', '$md5Password',now())";
            $connection->exec($insert);
            try {
                $update = "INSERT INTO admin_setup(configured, date) VALUES('YES',now())";
                $connection->exec($update);
                echo "success";
            } catch (PDOException $e) {
                echo "Faield : " . $e->getMessage();
            }
        } catch (PDOException $e) {
            echo "Faield : " . $e->getMessage();
        }
    }
} elseif (isset($_GET['auth'])) {
    $auth = $_GET['auth'];
    if ($auth == 'login') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $md5Password = md5($password);
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
            $rowCount = $statement->rowCount();
            if ($rowCount > 0) {
                $result = $statement->fetchAll();
                foreach ($result as $row) {
                    if ($md5Password == $row['password']) {
                        setcookie('aid', $row['id'], time() + 3600);
                        echo "success";
                    } else {
                        echo "invalid_password";
                    }
                }
            } else {
                echo "inavlid_username";
            }
        }
    }
} elseif (isset($_GET['data'])) {
    if ($_GET['data'] == 'overview') {
        // user overview
        $userQuery = "SELECT * FROM user_details";
        $userStatement = $connection->prepare($userQuery);
        $userStatement->execute();
        $userRowCount = $userStatement->rowCount();
        // posts overview
        $postQuery = "SELECT * FROM post_details";
        $postStatement = $connection->prepare($postQuery);
        $postStatement->execute();
        $postRowCount = $postStatement->rowCount();
        // tasks overview
        $taskQuery = "SELECT * FROM task_details";
        $taskStatement = $connection->prepare($taskQuery);
        $taskStatement->execute();
        $taskRowCount = $taskStatement->rowCount();
        // contact overview
        $contactQuery = "SELECT * FROM contact_details";
        $contactStatement = $connection->prepare($contactQuery);
        $contactStatement->execute();
        $contactRowCount = $contactStatement->rowCount();


        echo "
                <div class='col-xl-3 col-md-6 mb-4'>
                    <div class='card border-left-primary shadow h-100 py-2'>
                        <div class='card-body'>
                            <div class='row no-gutters align-items-center'>
                                <div class='col mr-2'>
                                    <div class='text-xs font-weight-bold text-primary text-uppercase mb-1'>Users</div>
                                    <div class='h5 mb-0 font-weight-bold text-gray-800'>$userRowCount</div>
                                </div>
                                <div class='col-auto'>
                                    <i class='fas fa-user-friends fa-2x text-gray-300'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='col-xl-3 col-md-6 mb-4'>
                    <div class='card border-left-success shadow h-100 py-2'>
                        <div class='card-body'>
                            <div class='row no-gutters align-items-center'>
                                <div class='col mr-2'>
                                    <div class='text-xs font-weight-bold text-success text-uppercase mb-1'>Posts</div>
                                    <div class='h5 mb-0 font-weight-bold text-gray-800'>$postRowCount</div>
                                </div>
                                <div class='col-auto'>
                                    <i class='fas fa-rss fa-2x text-gray-300'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='col-xl-3 col-md-6 mb-4'>
                    <div class='card border-left-info shadow h-100 py-2'>
                        <div class='card-body'>
                            <div class='row no-gutters align-items-center'>
                                <div class='col mr-2'>
                                    <div class='text-xs font-weight-bold text-info text-uppercase mb-1'>Tasks</div>
                                    <div class='h5 mb-0 font-weight-bold text-gray-800'>$taskRowCount</div>
                                </div>
                                <div class='col-auto'>
                                    <i class='fas fa-tasks fa-2x text-gray-300'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='col-xl-3 col-md-6 mb-4'>
                    <div class='card border-left-warning shadow h-100 py-2'>
                        <div class='card-body'>
                            <div class='row no-gutters align-items-center'>
                                <div class='col mr-2'>
                                    <div class='text-xs font-weight-bold text-warning text-uppercase mb-1'>
                                        Pending Contacts
                                    </div>
                                    <div class='h5 mb-0 font-weight-bold text-gray-800'>$contactRowCount</div>
                                </div>
                                <div class='col-auto'>
                                    <i class='fas fa-comments fa-2x text-gray-300'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            ";
    }
} elseif (isset($_GET['create'])) {
    if ($_GET['create'] == 'task') {
        $title = $_POST['title'];
        $details = $_POST['details'];
        $points = $_POST['points'];
        $step1 = $_POST['step1'];
        $step2 = $_POST['step3'];
        $step3 = $_POST['step3'];
        if ($title == '') {
            echo 'empty_title';
        } elseif ($details == '') {
            echo 'empty_details';
        } elseif ($points == '') {
            echo 'empty_points';
        } elseif ($step1 == '') {
            echo "empty_step1";
        } elseif ($step2 == '') {
            echo "empty_step2";
        } elseif ($step3 == '') {
            echo "empty_step3";
        } else {
            try {
                $insert = "INSERT INTO task_details(title, details, points, step1, step2, step3, date) VALUES('$title','$details','$points','$step1','$step2','$step3', now())";
                $connection->exec($insert);
                echo "success";
            } catch (PDOException $e) {
                echo "error";
            }
        }
    }
}
