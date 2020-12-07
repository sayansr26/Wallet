<?php 

// getting connection

require('connection.php');
require('function.php');

if(login()){
    $uid = $_COOKIE['uid'];
    $query = "SELECT * FROM admin_users WHERE id = :id";
    $statement = $connection->prepare($query);
    $statement->execute(
        array(
            'id' => $uid
        )
    );
    $result = $statement->fetchAll();
    foreach($result as $row){
        $username = $row['username'];
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/favicon.png" type="image/png">
    <!-- font awesome bootstrap master css placeholder  -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/placeholder-loading.min.css">
    <link rel="stylesheet" href="css/master.css">
    <title>Viewerally Links</title>
</head>

<body>
    <div class="wrapper">
        <nav class="navbar navbar-expand-sm navbar-light bg-warning">
            <a class="navbar-brand" href="index.php">
                <img src="assets/Icon.png" alt="icon" class="d-inline-block align-center mr-1" height="30" width="30">
                <strong>ViewerAlly</strong>
            </a>
            <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse"
                data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavId">
                <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="users">Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="withdraw">Withdraw</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="links">Links <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="diamonds">Diamonds</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contacts">Contacts</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="nav-link dropdown-toggle" id="navbarDropdown"
                            role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="assets/favicon.png" alt="#" width="25" height="25"
                                class="rounded rounded-circle border border-dark d-inline-block align-top mr-1">
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
            <h5 class="text-secondary my-3"><i class="fas fa-user"></i>&nbsp;YouTube Links Overview <span
                    class="text-primary fa-pull-right"><button type='button' class="btn btn-warning shadow btn-sm"
                        onclick="add_link()"><i class="fas fa-plus-circle"></i>&nbsp;Add Links</button></span></h5>
            <div class="row my-5">
                <div class="table-responsive">
                    <table class="table shadow table-hover rounded">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>#</th>
                                <th>Username</th>
                                <th>Link</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="yt-links-data"></tbody>
                    </table>
                </div>
            </div>
            <h5 class="text-secondary my-3"><i class="fas fa-user"></i>&nbsp;Instagram Links Overview</h5>
            <div class="row my-5">
                <div class="table-responsive">
                    <table class="table shadow table-hover rounded">
                        <thead class="bg-secondary text-white">
                            <tr>
                                <th>#</th>
                                <th>Username</th>
                                <th>Link</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="it-links-data"></tbody>
                    </table>
                </div>
            </div>
            <h5 class="text-secondary my-3"><i class="fas fa-user"></i>&nbsp;Facebook Links Overview</h5>
            <div class="row my-5">
                <div class="table-responsive">
                    <table class="table shadow table-hover rounded">
                        <thead class="bg-warning text-white">
                            <tr>
                                <th>#</th>
                                <th>Username</th>
                                <th>Link</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="ft-links-data"></tbody>
                    </table>
                </div>
            </div>
            <h5 class="text-secondary my-3"><i class="fas fa-user"></i>&nbsp;Web Links Overview</h5>
            <div class="row my-5">
                <div class="table-responsive">
                    <table class="table shadow table-hover rounded">
                        <thead class="bg-info text-white">
                            <tr>
                                <th>#</th>
                                <th>Username</th>
                                <th>Link</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="wt-links-data"></tbody>
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
            <a href="withdrawexport.php"><i class="fas fa-download"></i></a>
        </div> -->
    </div>
    <!-- withdraw modal -->
    <div class="modal fade" id="modalLinks">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h6 class="modal-title">Add Links</h6>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="#" method="POST" id="links-form">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                </div>
                                <input type="hidden" name="username" value="Admin">
                                <input type="text" value="Admin" class="form-control rounded-right" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="fas fa-info-circle"></i>
                                    </span>
                                </div>
                                <select name="category" id="category" class="form-control rounded-right">
                                    <option value="YouTube">YouTube</option>
                                    <option value="Instagram">Instagram</option>
                                    <option value="Facebook">Facebook</option>
                                    <option value="Web">Web</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="fas fa-info-circle"></i>
                                    </span>
                                </div>
                                <select name="sub_category" id="sub_category" class="form-control rounded-right">
                                    <option disabled class="text-primary">YouTube Options</option>
                                    <option value="views">Views</option>
                                    <option value="likes">Likes</option>
                                    <option value="comments">Comments</option>
                                    <option value="subscribe">Subscribe</option>
                                    <option disabled class="text-primary">Instagram Options</option>
                                    <option value="likes">Likes</option>
                                    <option value="comments">Comments</option>
                                    <option value="share">Share</option>
                                    <option value="follow">Follow</option>
                                    <option disabled class="text-primary">Facebook Options</option>
                                    <option value="likes">Likes</option>
                                    <option value="comments">Comments</option>
                                    <option value="share">Share</option>
                                    <option disabled class="text-primary">Web Options</option>
                                    <option value="views">Views</option>
                                    <option value="referral">Referral</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="fas fa-link"></i>
                                    </span>
                                </div>
                                <input type="text" name="link" id="link" class="form-control rounded-right"
                                    placeholder="Link">
                                <div class="invalid-feedback" id="invalid-link"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-primary btn-block" onclick="link_paste()"><i
                                    class="fas fa-plus-circle"></i>&nbsp;Add Link</button>
                        </div>
                        <div class="alert alert-success shadow" id="link-success" style="display: none;"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- withdraw modal -->
    <!-- jquery proper js bootstrap font awesome master js -->
    <script src="js/jquery-3.5.1.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/all.js"></script>
    <script src="js/master.js"></script>
    <script>
        $(document).ready(function () {
            $('#skelton').delay(2000).fadeOut(500);
            $('#data').delay(2500).fadeIn(500);
        });

        function add_link() {
            $('#modalLinks').modal('show');
        }

        function link_paste() {
            $.ajax({
                url: 'server.php?data=add_link',
                type: 'post',
                data: $('#links-form').serialize(),
                success: function (response) {
                    if (response == 'success') {
                        $('#link-success').html('Successfully Added');
                        $('#link-success').show();
                        $('#link-success').delay(5000).fadeOut(500);
                    }
                    if (response == 'empty') {
                        $('#link').addClass('is-invalid');
                        $('#invalid-link').html('required');
                    }
                }
            });
        }
    </script>
    <script>
        function fetchYtdata() {
            $.ajax({
                url: 'server.php?data=yt_data',
                type: 'post',
                success: function (response) {
                    $('#yt-links-data').html(response);
                }

            });
        }

        function fetchItdata() {
            $.ajax({
                url: 'server.php?data=it_data',
                type: 'post',
                success: function (response) {
                    $('#it-links-data').html(response);
                }

            });
        }

        function fetchFtdata() {
            $.ajax({
                url: 'server.php?data=ft_data',
                type: 'post',
                success: function (response) {
                    $('#ft-links-data').html(response);
                }

            });
        }

        function fetchWebdata() {
            $.ajax({
                url: 'server.php?data=web_data',
                type: 'post',
                success: function (response) {
                    $('#wt-links-data').html(response);
                }

            });
        }
        setInterval(function () {
            fetchYtdata();
            fetchItdata();
            fetchFtdata();
            fetchWebdata();
        }, 1000);
    </script>
</body>

</html>
<?php 
}else{
    header('location:login?sorry_you_have_to_login_first');
}
?>