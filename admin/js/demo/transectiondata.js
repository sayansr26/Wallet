// Call the dataTables jQuery plugin
$(document).ready(function () {
  var dataTable = $('#dataTable').DataTable({
    "processing": true,
    "serverSide": true,
    "order": [],
    "ajax": {
      url: "transectiondata.php",
      type: "POST"
    }
  });
});