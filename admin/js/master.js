// function login
function login() {
  $("#loading").show();
  $("#username").removeClass("is-invalid");
  $("#password").removeClass("is-invalid");
  $("#invalid-username").html("");
  $("#invalid-password").html("");
  $.ajax({
    url: "server.php?auth=login",
    type: "post",
    data: $("#login-form").serialize(),
    success: function (response) {
      if (response == "empty_username") {
        $("#loading").hide();
        $("#username").addClass("is-invalid");
        $("#invalid-username").html("required");
      }
      if (response == "empty_password") {
        $("#loading").hide();
        $("#password").addClass("is-invalid");
        $("#invalid-password").html("required");
      }
      if (response == "invalid_username") {
        $("#loading").hide();
        $("#username").addClass("is-invalid");
        $("#invalid-username").html("Invalid Username");
      }
      if (response == "invalid_password") {
        $("#loading").hide();
        $("#password").addClass("is-invalid");
        $("#invalid-password").html("Invalid Password");
      }
      if (response == "success") {
        window.location.href = "/admin/";
      }
    },
  });
}
