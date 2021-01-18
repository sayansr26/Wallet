// Call the dataTables jQuery plugin
$(document).ready(function () {
  var dataTable = $('#rateTable').DataTable({
    "processing": true,
    "serverSide": true,
    "order": [],
    "ajax": {
      url: "ratedata.php",
      type: "POST"
    }
  });
   $('#rateTable').on('draw.dt', function () {
    $('#rateTable').Tabledit({
      url: 'rateaction.php',
      dataType: 'json',
      buttons: {
        delete: {
          // class: 'btn btn-sm btn-danger rounded shadow',
          html: '<i class="fas fa-trash text-danger fa-lg shadow"></i>',
          action: 'delete'
        },
        edit: {
          // class: 'btn btn-sm btn-primary rounded shadow mx-2',
          html: '<i class="fas text-primary shadow fa-lg fa-edit"></i>',
          action: 'edit'
        },
        confirm: {
          html: 'Are you sure?'
        }
      },
      columns: {
        identifier: [0, 'id'],
        editable: [
          [2, 'rate'],
        ]
      },
      restoreButton: false,
      onSuccess: function (data, textStatus, jqXHR) {
        if (data.action == 'delete') {
          $('#' + data.id).remove();
          $('#dataTable').DataTable().ajax.reload();
        }
      }
    });
  });
});