(function ($) {
  const pageInit = function () {
    console.log('servers.js');

    $('#server-form-submit').on('click', updateServers);
    getServers();
  };

  const getServers = function () {
    $.get(WPSFTP_AJAX_URL, {
      action: 'wpsftp_servers'
    }, function (response) {
      if (response.success === true) {
        if (response.data.length < 1) {
          toastr.warning('No servers set');
        } else {
          $('#address').val(response.data.address);
          $('#username').val(response.data.username);
        }
      } else {
        toastr.error(response.message);
      }
    });
  };

  const updateServers = function () {
    console.log($('#servers-form').serializeArray());

    $.post(WPSFTP_AJAX_URL, {
      action: 'wpsftp_servers',
      data: $('#servers-form').serializeArray()
    }, function (response) {
      if (response.success === true) {
        toastr.success(response.message);
      } else {
        toastr.error(response.message);
      }
    });
  };

  $(document).ready(function () {
    pageInit();
  });
})(jQuery);