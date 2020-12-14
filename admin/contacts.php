<?php

// getting connection

require('connection.php');
require('function.php');

if (login()) {
    $uid = $_COOKIE['aid'];
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
        <link rel="shortcut icon" href="assets/favicon.ico" type="image/x-icon">
        <!-- font awesome bootstrap master css placeholder  -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/all.css">
        <link rel="stylesheet" href="css/placeholder-loading.min.css">
        <link rel="stylesheet" href="css/master.css">
        <title>Contacts</title>
    </head>

    <body>
        <div class="wrapper">
            <nav class="navbar navbar-expand-sm navbar-dark bg-primary">
                <a class="navbar-brand" href="/admin/">
                    <!-- <img src="assets/Icon.png" alt="icon" class="d-inline-block align-center mr-1" height="30" width="30"> -->
                    <strong>Exchnage</strong>
                </a>
                <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="collapsibleNavId">
                    <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/">Home</a>
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
                        <li class="nav-item active">
                            <a class="nav-link" href="contacts"> <span class="sr-only">(current)</span>Contacts</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="assets/favicon.ico" alt="#" width="25" height="25" class="rounded rounded-circle border border-dark d-inline-block align-top mr-1">
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
                <h5 class="text-secondary my-3"><i class="fas fa-user"></i>&nbsp;Contacts Overview</h5>
                <div class="row my-5">
                    <div class="table-responsive">
                        <table class="table table-hover rounded">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Comment</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody id="contacts-data"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="container" id="skelton">
                <div class="row my-5">
                    <div class="col-12">
                        <div class="ph-item shadow">
                            <div class="col-12">
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
                                    <div class="ph-col-2 big"></div>
                                    <div class="ph-col-2 empty"></div>
                                    <div class="ph-col-2 big"></div>
                                    <div class="ph-col-2 empty"></div>
                                    <div class="ph-col-2 big"></div>
                                    <div class="ph-col-2 empty"></div>
                                </div>
                                <div class="ph-row">
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
            <!-- <div class="fav shadow">
            <a href="userexport.php"><i class="fas fa-download"></i></a>
        </div> -->
        </div>
        <!-- jquery proper js bootstrap font awesome master js -->
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
            function fetchdata() {
                $.ajax({
                    url: 'server.php?data=contacts',
                    type: 'post',
                    success: function(response) {
                        $('#contacts-data').html(response);
                    }

                });
            }
            setInterval(function() {
                fetchdata();
            }, 1000);
        </script>
    </body>

    </html>
<?php
} else {
    header('location:login?sorry_you_have_to_login_first');
}
?>