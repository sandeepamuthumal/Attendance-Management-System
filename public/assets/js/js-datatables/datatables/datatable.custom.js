(function ($) {
  $(document).ready(function () {
    // Basic table example
    $("#basic-1").DataTable();
    $('#transaction').DataTable({
      "searchable": true,
      "paging": false,
      "ordering": false,
      "info": false,
      "bLengthChange": false
    });
    $('#manage-invoice').DataTable({
      "searchable": true,
      "paging": false,
      "ordering": false,
      "info": false,
      "bLengthChange": false
    });
    $('#best-sell').DataTable({
      "searchable": true,
      "paging": false,
      "ordering": false,
      "info": false,
      "bLengthChange": false
    });
    $('#recent-order').DataTable({
      "searchable": true,
      "paging": false,
      "ordering": false,
      "info": false,
      "bLengthChange": false
    });
    $('#student-detail').DataTable({
      "searchable": true,
      "paging": false,
      "ordering": false,
      "info": false,
      "bLengthChange": false
    });
    $('#assignment').DataTable({
      "searchable": true,
      "paging": false,
      "ordering": false,
      "info": false,
      "bLengthChange": false
    });
  });
})(jQuery);
