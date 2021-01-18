// Call the dataTables jQuery plugin
$(document).ready(function () {
  var dataTable = $('#userTable').DataTable({
    "processing": true,
    "serverSide": true,
    "order": [],
    "ajax": {
      url: "userdata.php",
      type: "POST"
    }
  });
});