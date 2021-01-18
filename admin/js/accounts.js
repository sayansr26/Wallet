// Call the dataTables jQuery plugin
$(document).ready(function () {
  var dataTable = $('#accountTable').DataTable({
    "processing": true,
    "serverSide": true,
    "order": [],
    "ajax": {
      url: "accountsdata.php",
      type: "POST"
    }
  });
});