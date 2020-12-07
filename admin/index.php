<?php

require('connection.php');
require('function.php');

if (login()) {
    $uid = $_COOKIE['uid'];
    $query = "SELECT * FROM admin_users WHERE id = :id";
    $statement = $connection->prepare($query);
    $statement->execute(
        array(
            'id' => $uid
        )
    );
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        $username = $row['username'];
    }

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="assets/favicon.png" type="image/png">
        <!-- font awesome bootstrap master and placeholder -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/all.css">
        <link rel="stylesheet" href="css/placeholder-loading.min.css">
        <link rel="stylesheet" href="css/master.css">
        <title>Exchnage Admin</title>
    </head>

    <body>
        <div class="wrapper">
            <nav class="navbar navbar-expand-sm navbar-light bg-warning">
                <a class="navbar-brand" href="/admin/">
                    <!-- <img src="assets/Icon.png" alt="icon" class="d-inline-block align-center mr-1" height="30" width="30"> -->
                    <strong>Exchange</strong>
                </a>
                <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="collapsibleNavId">
                    <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                        <li class="nav-item active">
                            <a class="nav-link" href="/admin/">Home <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="users">Users</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="exchnages">Exchnages</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="rates">Exchnage Rates</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contacts">Contacts</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="assets/favicon.png" alt="#" width="25" height="25" class="rounded rounded-circle border border-dark d-inline-block align-top mr-1">
                                <span class='d-inline-block'><?php echo $username; ?></span>
                            </a>
                            <div class="dropdown-menu w-50 fade" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="logout.php">Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <div class="container" id="data" style="display: none;">
                <h5 class="text-secondary mt-2">Pending Requests</h5>
                <div class="row my-5">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table shadow rounded table-hover">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th>#</th>
                                        <th>Username</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="w-request"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container" id="skelton">
                <div class="row my-4">
                    <div class="col-lg-3 col-md-3 col-12">
                        <div class="ph-item shadow">
                            <div class="ph-col-12">
                                <div class="ph-row">
                                    <div class="ph-col-12 big"></div>
                                    <div class="ph-col-12 small"></div>
                                    <div class="ph-col-10 small"></div>
                                    <div class="ph-col-12 empty"></div>
                                    <div class="ph-col-6 small"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-12">
                        <div class="ph-item shadow">
                            <div class="ph-col-12">
                                <div class="ph-row">
                                    <div class="ph-col-12 big"></div>
                                    <div class="ph-col-12 small"></div>
                                    <div class="ph-col-10 small"></div>
                                    <div class="ph-col-12 empty"></div>
                                    <div class="ph-col-6 small"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-12">
                        <div class="ph-item shadow">
                            <div class="ph-col-12">
                                <div class="ph-row">
                                    <div class="ph-col-12 big"></div>
                                    <div class="ph-col-12 small"></div>
                                    <div class="ph-col-10 small"></div>
                                    <div class="ph-col-12 empty"></div>
                                    <div class="ph-col-6 small"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-12">
                        <div class="ph-item shadow">
                            <div class="ph-col-12">
                                <div class="ph-row">
                                    <div class="ph-col-12 big"></div>
                                    <div class="ph-col-12 small"></div>
                                    <div class="ph-col-10 small"></div>
                                    <div class="ph-col-12 empty"></div>
                                    <div class="ph-col-6 small"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="ph-item shadow">
                            <div class="ph-col-12">
                                <div class="ph-picture"></div>
                                <div class="ph-row">
                                    <div class="ph-col-12 big"></div>
                                    <div class="ph-col-2 big"></div>
                                    <div class="ph-col-2 empty"></div>
                                    <div class="ph-col-2 big"></div>
                                    <div class="ph-col-2 empty"></div>
                                    <div class="ph-col-2 big"></div>
                                    <div class="ph-col-2 empty"></div>
                                </div>
                                <div class="ph-row">
                                    <div class="ph-col-12 big"></div>
                                    <div class="ph-col-2 big"></div>
                                    <div class="ph-col-2 empty"></div>
                                    <div class="ph-col-2 big"></div>
                                    <div class="ph-col-2 empty"></div>
                                    <div class="ph-col-2 big"></div>
                                    <div class="ph-col-2 empty"></div>
                                </div>
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
        <script>
            $(document).ready(function() {
                $('#skelton').delay(2000).fadeOut(500);
                $('#data').delay(2500).fadeIn(500);
            });
        </script>
        <script>
            function getdata() {
                $.ajax({
                    url: 'server.php?data=overview',
                    type: 'post',
                    success: function(response) {
                        $('#data-overview').html(response);
                    }
                });
            }

            function requestdata() {
                $.ajax({
                    url: 'server.php?data=requests',
                    type: 'post',
                    success: function(response) {
                        $('#w-request').html(response);
                    }
                });
            }
            setInterval(function() {
                getdata();
                requestdata();
            }, 1000);
        </script>
    </body>

    </html>
<?php
} else {
    header('location:login?sorry_you_have_to_login_first');
}
?>