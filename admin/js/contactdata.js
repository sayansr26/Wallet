$(document).ready(function(){
	var dataTable = $('#contactTable').DataTable({
    "processing": true,
    "serverSide": true,
    "order": [],
    "ajax": {
      url: "contactdata.php",
      type: "POST"
    }
  });
});