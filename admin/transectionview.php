<?php
require('./include/config.php');
require('./include/functions.php');
if (login()) {
    $uid = $_COOKIE['aid'];
    $query = "SELECT * FROM admin_users WHERE id = :uid";
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
    if (isset($_GET['view'])) {
        $resultQuery = "SELECT * FROM transection WHERE id = :id";
        $statement =  $connection->prepare($resultQuery);
        $statement->execute(
            array(
                'id' => $_GET['view']
            )
        );
        $result = $statement->fetchAll();
        foreach ($result as $row) {
            $id = $row['id'];
            $amount = $row['amount'];
            $charge = $row['charge'];
            $total = $row['total'];
            $type = $row['type'];
            $date = $row['date'];
            $date = strtotime($date);
            $date = date('d-M-Y', $date);
            $user = $row['username'];
            $ban = $row['ban'];
            $account = $row['account'];
            $ifsc = $row['ifsc'];
            $bank = $row['bank'];
            $razorpay = $row['razorpay'];
            $transectionid = $row['transectionid'];
            $status = $row['status'];
            if ($status == 'accepted') {
                $status = "<span class='badge badge-primary'>$status</span>";
            } elseif ($status == 'completed') {
                $status = "<span class='badge badge-success'>$status</span>";
            } elseif ($status == 'rejected') {
                $status = "<span class='badge badge-danger'>$status</span>";
            }
            if ($type == '1') {
                $type = 'Bank Transfer';
            } elseif ($type == '2') {
                $type = 'Bank Transfer';
            } elseif ($type == '3') {
                $type = 'Withdrawl';
            } elseif ($type == '4') {
                $type = 'Add Money';
            }
        }
    }
    if (isset($_POST['submit'])) {
        $updatedStatus = $_POST['status'];
        try {
            $update = "UPDATE transection SET status = '$updatedStatus' WHERE id = '$id'";
            $connection->exec($update);
            $phoneQuery = "SELECT * FROM user_data WHERE username = :username";
            $statement = $connection->prepare($phoneQuery);
            $statement->execute(
                array(
                    'username' => $user
                )
            );
            $result = $statement->fetchAll();
            foreach ($result as $row) {
                $phone = $row['phone'];
                $name = 'User';
            }
            // header('location:transections?msg=updated succsess fully');
            $field = array(
                "sender_id" => "FSTSMS",
                "language" => "english",
                "route" => "qt",
                "numbers" => "$phone, 7024394944",
                "message" => "43396",
                "variables" => "{#AA#}|{#BB#}|{#EE#}",
                "variables_values" => "$name|$amount|$transectionid"
            );

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://www.fast2sms.com/dev/bulk",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($field),
                CURLOPT_HTTPHEADER => array(
                    "authorization: YzovdVO34G9anBwrJ5I6pPUEF8ciLgetjRKblyD2MXCq71SfQuSXRKxdzOTgfM6rUaGbBJ5wQ3F0HYNv",
                    "cache-control: no-cache",
                    "accept: */*",
                    "content-type: application/json"
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                header('location:transections?msg=updated succsess fully');
            }
        } catch (PDOException $e) {
            echo "Faield : " . $e->getMessage();
        }
    }
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Transections Details</title>
        <!-- Custom fonts for this template-->
        <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
        <!-- Custom styles for this template-->
        <link href="css/sb-admin-2.min.css" rel="stylesheet">
        <link rel="stylesheet" href="vendor/datatables/dataTables.bootstrap4.min.css">
    </head>

    <body id="page-top">
        <!-- Page Wrapper -->
        <div id="wrapper">
            <!-- Sidebar -->
            <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
                <!-- Sidebar - Brand -->
                <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/admin/">
                    <div class="sidebar-brand-icon rotate-n-15">
                        <i class="fas fa-laugh-wink"></i>
                    </div>
                    <div class="sidebar-brand-text mx-3">Admin Panel</div>
                </a>
                <!-- Divider -->
                <hr class="sidebar-divider my-0">
                <!-- Nav Item - Dashboard -->
                <li class="nav-item">
                    <a class="nav-link" href="/admin/">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span></a>
                </li>
                <!-- Divider -->
                <hr class="sidebar-divider">
                <!-- Heading -->
                <div class="sidebar-heading">
                    Utilities
                </div>
                <!-- Nav Item - Pages Collapse Menu -->
                <li class="nav-item active">
                    <a class="nav-link active collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fas fa-tasks"></i>
                        <span>Transections</span>
                    </a>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Transection Options:</h6>
                            <a class="collapse-item" href="transections">View Transections</a>
                        </div>
                    </div>
                </li>
                <!-- Nav Item - Utilities Collapse Menu -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseannounce" aria-expanded="true" aria-controls="collapseannounce">
                        <i class="fas fa-money-check-alt"></i>
                        <span>Accounts</span>
                    </a>
                    <div id="collapseannounce" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Account Options:</h6>
                            <a class="collapse-item" href="accounts">View All</a>
                        </div>
                    </div>
                </li>
                <!-- Divider -->
                <hr class="sidebar-divider">
                <!-- Heading -->
                <div class="sidebar-heading">
                    Addons
                </div>
                <!-- Nav Item - Users -->
                <li class="nav-item">
                    <a class="nav-link" href="users">
                        <i class="fas fa-user-friends"></i>
                        <span>Manage Users</span></a>
                </li>
                <!-- Nav Item - Users -->
                <li class="nav-item">
                    <a class="nav-link" href="charges">
                        <i class="fas fa-file-invoice-dollar"></i>
                        <span>Charges</span></a>
                </li>
                <!-- Nav Item - Contacts -->
                <li class="nav-item">
                    <a class="nav-link" href="contacts">
                        <i class="fas fa-stethoscope"></i>
                        <span>Contact Requests</span></a>
                </li>
                <!-- Divider -->
                <hr class="sidebar-divider d-none d-md-block">
                <!-- Sidebar Toggler (Sidebar) -->
                <div class="text-center d-none d-md-inline">
                    <button class="rounded-circle border-0" id="sidebarToggle"></button>
                </div>
            </ul>
            <!-- End of Sidebar -->
            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">
                <!-- Main Content -->
                <div id="content">
                    <!-- Topbar -->
                    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                        <!-- Sidebar Toggle (Topbar) -->
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>
                        <!-- Topbar Search -->
                        <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                            <div class="input-group">
                                <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button">
                                        <i class="fas fa-search fa-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                        <!-- Topbar Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                            <li class="nav-item dropdown no-arrow d-sm-none">
                                <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-search fa-fw"></i>
                                </a>
                                <!-- Dropdown - Messages -->
                                <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                                    <form class="form-inline mr-auto w-100 navbar-search">
                                        <div class="input-group">
                                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="button">
                                                    <i class="fas fa-search fa-sm"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </li>
                            <!-- Nav Item - Alerts -->
                            <li class="nav-item dropdown no-arrow mx-1">
                                <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-bell fa-fw"></i>
                                    <!-- Counter - Alerts -->
                                    <span class="badge badge-danger badge-counter">3+</span>
                                </a>
                                <!-- Dropdown - Alerts -->
                                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                                    <h6 class="dropdown-header">
                                        Alerts Center
                                    </h6>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <div class="mr-3">
                                            <div class="icon-circle bg-primary">
                                                <i class="fas fa-file-alt text-white"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="small text-gray-500">December 12, 2019</div>
                                            <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                        </div>
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <div class="mr-3">
                                            <div class="icon-circle bg-success">
                                                <i class="fas fa-donate text-white"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="small text-gray-500">December 7, 2019</div>
                                            $290.29 has been deposited into your account!
                                        </div>
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <div class="mr-3">
                                            <div class="icon-circle bg-warning">
                                                <i class="fas fa-exclamation-triangle text-white"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="small text-gray-500">December 2, 2019</div>
                                            Spending Alert: We've noticed unusually high spending for your account.
                                        </div>
                                    </a>
                                    <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                                </div>
                            </li>
                            <div class="topbar-divider d-none d-sm-block"></div>
                            <!-- Nav Item - User Information -->
                            <li class="nav-item dropdown no-arrow">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $username; ?></span>
                                    <img class="img-profile rounded-circle" src="img/user.png">
                                </a>
                                <!-- Dropdown - User Information -->
                                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                    <a class="dropdown-item" href="profile">
                                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Profile
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Logout
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </nav>
                    <!-- End of Topbar -->
                    <!-- Begin Page Content -->
                    <div class="container-fluid">
                        <!-- Page Heading -->
                        <!-- <div class="d-sm-flex align-items-center justify-content-between mb-2">
                                                <h1 class="h3 mb-0 text-gray-800">Transections</h1>
                                            </div> -->
                        <!-- Content Row -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card shadow">
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Transectio Details</h6>
                                        <div class="dropdown no-arrow">
                                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                                <div class="dropdown-header">Options:</div>
                                                <a class="dropdown-item" href="createtask">Create New Tasks</a>
                                                <a class="dropdown-item" href="">Download As CSV</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-7">
                                                <h5 class="text-info">Transectional Details</h5>
                                                <hr>
                                                <div>
                                                    <h6 class="text-dark">Transection ID: <span class="float-right"><?php echo $transectionid; ?></span></h6>
                                                    <h6 class="text-dark">Razorpay ID: <span class="float-right"><?php echo $razorpay; ?></span></h6>
                                                    <h6 class="text-dark">Satelment Amount: <span class="float-right"><?php echo $amount; ?></span></h6>
                                                    <h6 class="text-dark">Charge Collect: <span class="float-right"><?php echo $charge; ?></span></h6>
                                                    <h6 class="text-dark">Total Paid: <span class="float-right"><?php echo $total; ?></span></h6>
                                                    <h6 class="text-dark">Transfer Type: <span class="float-right"><?php echo $type; ?></span></h6>
                                                    <h6 class="text-dark">Username: <span class="float-right"><?php echo $user; ?></span></h6>
                                                    <h6 class="text-dark">Status: <span class="float-right"><?php echo $status; ?></span></h6>
                                                    <h6 class="text-dark">Date: <span class="float-right"><?php echo $date; ?></span></h6>
                                                </div>
                                            </div>
                                            <div class="col-5">
                                                <h5 class="text-info">Account Details</h5>
                                                <hr>
                                                <div>
                                                    <h6 class="text-dark">Banificary Name: <span class="float-right"><?php echo $ban; ?></span></h6>
                                                    <h6 class="text-dark">Account Number: <span class="float-right"><?php echo $account; ?></span></h6>
                                                    <h6 class="text-dark">IFSC CODE: <span class="float-right"><?php echo $ifsc; ?></span></h6>
                                                    <h6 class="text-dark">Bank Name: <span class="float-right"><?php echo $bank; ?></span></h6>
                                                </div>
                                            </div>
                                            <!-- <div class="col-12 mt-2">
                                                                    <h5>Actions</h5>
                                                                    <hr>
                                                                    <div class="row">
                                                                        <div class="col-6">
                                                                            <div class="form-group">
                                                                                <select class="form-control">
                                                                                    <option>Accepted</option>
                                                                                    <option>Rejected</option>
                                                                                    <option>Completed</option>
                                                                                    <option>Bank Processing</option>
                                                                                    <option>Refunded</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <button class="btn btn-block shadow btn-primary">Update</button>
                                                                        </div>
                                                                    </div>
                                                                </div> -->
                                        </div>
                                    </div>
                                    <div class="card-footer bg-primary">
                                        <div class="col-12">
                                            <h5 class="text-light font-weight-bold text-center">Actions</h5>
                                            <hr>
                                            <form method="POST">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <select name="status" class="form-control shadow">
                                                                <option value="accepted">Accepted</option>
                                                                <option value="rejected">Rejected</option>
                                                                <option value="completed">Completed</option>
                                                                <option value="bank process">Bank Processing</option>
                                                                <option value="refunded">Refunded</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <button type="submit" name="submit" class="btn btn-block shadow btn-warning">Update</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.container-fluid -->
                </div>
                <!-- End of Main Content -->
                <!-- Footer -->
                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Copyright &copy; Your Website 2020</span>
                        </div>
                    </div>
                </footer>
                <!-- End of Footer -->
            </div>
            <!-- End of Content Wrapper -->
        </div>
        <!-- End of Page Wrapper -->
        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>
        <!-- Logout Modal-->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-primary" href="logout.php">Logout</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bootstrap core JavaScript-->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- Core plugin JavaScript-->
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin-2.min.js"></script>
        <script type="text/javascript" src="vendor/datatables/dataTables.bootstrap4.js"></script>
        <script type="text/javascript" src="vendor/datatables/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="js/demo/transectiondata.js"></script>
    </body>

    </html>
<?php
} else {
    header('location:login?msg=Sorry you have to login first');
}
?>