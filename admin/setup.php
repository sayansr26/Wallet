<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Admin Panel - Setup</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
          <div class="col-lg-7">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Setup an Account!</h1>
              </div>
              <form class="user" id="setup-form" method="POST" action="#">
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <div class="form_div">
                      <input type="text" name="fname" id="fname" class="form_input" placeholder=" ">
                      <label for="fname" id="fname-label" class="form_label">First Name</label>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form_div">
                      <input type="text" name="lname" id="lname" class="form_input" placeholder=" ">
                      <label for="lname" id="lname-label" class="form_label">Last Name</label>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="form_div">
                    <input type="email" name="email" id="email" class="form_input" placeholder=" ">
                    <label for="email" id="email-label" class="form_label">Email Address</label>
                  </div>
                </div>
                <div class="form-group">
                  <div class="form_div">
                    <input type="text" name="username" id="username" class="form_input" placeholder=" ">
                    <label for="username" id="username-label" class="form_label">Username</label>
                  </div>
                </div>
                <div class="form-group">
                  <div class="form_div">
                    <input type="text" name="phone" id="phone" class="form_input" placeholder=" ">
                    <label for="phone" id="phone-label" class="form_label">Phone</label>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <div class="form_div">
                      <input type="password" name="password" id="password" class="form_input" placeholder=" ">
                      <label for="password" id="password-label" class="form_label">Password</label>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form_div">
                      <input type="password" name="cpassword" id="cpassword" class="form_input" placeholder=" ">
                      <label for="cpassword" id="cpassword-label" class="form_label">Repeat Password</label>
                    </div>
                  </div>
                </div>
                <a href="#" type="button" class="btn btn-primary btn-user btn-block" onclick="setup()">
                  Finish Setup
                </a>
              </form>
              <hr>
              <div class="text-center">
                <a class="small" href="/">&copy;All Right Reserved Website 2020</a>
              </div>
            </div>
          </div>
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

  <!-- calling js for functions -->
  <script>
    function setup() {
      $('#fname').removeClass('invalid');
      $('#lname').removeClass('invalid');
      $('#email').removeClass('invalid');
      $('#phone').removeClass('invalid');
      $('#username').removeClass('invalid');
      $('#password').removeClass('invalid');
      $('#cpassword').removeClass('invalid');
      $.ajax({
        url: 'action.php?setup=true',
        type: 'post',
        data: $('#setup-form').serialize(),
        success: function(response) {
          if (response == 'empty_fname') {
            $('#fname').addClass('invalid');
          }
          if (response == 'empty_lname') {
            $('#lname').addClass('invalid');
          }
          if (response == 'empty_email') {
            $('#email').addClass('invalid');
          }
          if (response == 'empty_phone') {
            $('#phone').addClass('invalid');
          }
          if (response == 'empty_username') {
            $('#username').addClass('invalid');
          }
          if (response == 'empty_password') {
            $('#password').addClass('invalid');
          }
          if (response == 'empty_cpassword') {
            $('#cpassword').addClass('invalid');
          }
          if (response == 'password_mistake') {
            $('#cpassword').addClass('invalid');
          }
          if (response == 'success') {
            window.location.href = "login";
          }
        }
      });
    }
  </script>

</body>

</html>