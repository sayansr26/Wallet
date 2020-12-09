<?php
// getting connection
require('connection.php');
require('function.php');
if (login()) {
    $view_id = "";
    if (isset($_GET['id'])) {
        $view_id = $_GET['id'];
    }
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
        <!-- font awesome bootstrap master css placeholder -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/all.css">
        <link rel="stylesheet" href="css/placeholder-loading.min.css">
        <link rel="stylesheet" href="css/master.css">
        <title>Exchnage Transections</title>
    </head>

    <body>
        <div class="wrapper">
            <nav class="navbar navbar-expand-sm navbar-dark bg-primary">
                <a class="navbar-brand" href="/admin/">
                    <!-- <img src="assets/Icon.png" alt="icon" class="d-inline-block align-center mr-1" height="30" width="30"> -->
                    <strong>Exchnages</strong>
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
                        <li class="nav-item active">
                            <a class="nav-link" href="exchnages">Exchnages <span class="sr-only">(current)</span></a>
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
            <input type="hidden" id="view_id" value="<?php echo $view_id; ?>">
            <div class="container shadow user-panel" id="data" style="display: none;"></div>
            <div class="container my-5" id="skelton">
                <div class="row">
                    <div class="col-12">
                        <div class="ph-item shadow">
                            <div class="ph-col-4">
                                <div class="ph-picture"></div>
                            </div>
                            <div class="ph-col-8">
                                <div class="ph-row">
                                    <div class="ph-col-6 big"></div>
                                </div>
                                <div class="ph-row">
                                    <div class="ph-col-4 big"></div>
                                </div>
                                <div class="ph-row">
                                    <div class="ph-col-10 empty"></div>
                                    <div class="ph-col-2 big"></div>
                                </div>
                            </div>
                            <div class="ph-col-12">
                                <div class="ph-row">
                                    <div class="ph-col-12 empty"></div>
                                </div>
                                <div class="ph-row">
                                    <div class="ph-col-2 big"></div>
                                    <div class="ph-col-2 empty"></div>
                                    <div class="ph-col-8 big"></div>
                                </div>
                                <div class="ph-row">
                                    <div class="ph-col-2 small"></div>
                                    <div class="ph-col-2 empty"></div>
                                    <div class="ph-col-6 small"></div>
                                    <div class="ph-col-2 empty"></div>
                                </div>
                                <div class="ph-row">
                                    <div class="ph-col-2 small"></div>
                                    <div class="ph-col-2 empty"></div>
                                    <div class="ph-col-6 small"></div>
                                    <div class="ph-col-2 empty"></div>
                                </div>
                                <div class="ph-row">
                                    <div class="ph-col-2 small"></div>
                                    <div class="ph-col-2 empty"></div>
                                    <div class="ph-col-6 small"></div>
                                    <div class="ph-col-2 empty"></div>
                                </div>
                                <div class="ph-row">
                                    <div class="ph-col-2 small"></div>
                                    <div class="ph-col-2 empty"></div>
                                    <div class="ph-col-6 small"></div>
                                    <div class="ph-col-2 empty"></div>
                                </div>
                                <div class="ph-row">
                                    <div class="ph-col-2 small"></div>
                                    <div class="ph-col-2 empty"></div>
                                    <div class="ph-col-6 small"></div>
                                    <div class="ph-col-2 empty"></div>
                                </div>
                                <div class="ph-row">
                                    <div class="ph-col-2 small"></div>
                                    <div class="ph-col-2 empty"></div>
                                    <div class="ph-col-6 small"></div>
                                    <div class="ph-col-2 empty"></div>
                                </div>
                                <div class="ph-row">
                                    <div class="ph-col-2 small"></div>
                                    <div class="ph-col-2 empty"></div>
                                    <div class="ph-col-6 small"></div>
                                    <div class="ph-col-2 empty"></div>
                                </div>
                                <div class="ph-row">
                                    <div class="ph-col-2 small"></div>
                                    <div class="ph-col-2 empty"></div>
                                    <div class="ph-col-6 small"></div>
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
            var view_id = $('#view_id').val();

            function fetchdata() {
                $.ajax({
                    url: 'server.php?data=transection',
                    type: 'post',
                    data: {
                        id: view_id
                    },
                    success: function(response) {
                        $('#data').html(response);
                    }
                });
            }
            $(document).ready(function() {
                $('#skelton').delay(2000).fadeOut(500);
                $('#data').delay(2500).fadeIn(500);
                $('#transection-data').delay(2500).fadeIn(500);
                fetchdata();
            });

            function updateTrans() {
                $.ajax({
                    url: 'server.php?update=exchnage',
                    type: 'post',
                    data: $('#exchnage-update').serialize(),
                    success: function(response) {
                        alert(response);
                    }
                });
            }
        </script>
    </body>

    </html>
<?php
} else {
    header('location:login?error=sorry_you_have_t0_login_first');
}
?>