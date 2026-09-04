(function ($) {
  let $serverForm, $connectionTest;

  const pageInit = function () {
    $serverForm = $('#server-form');
    $connectionTest = $('#connection-test');

    $serverForm.on('submit', updateServers);
    $connectionTest.on('click', testConnection);
    $('#sftp-test').on('click', testSFTP);
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
          $('#ip').val(response.data[0].ip);
          $('#username').val(response.data[0].username);
          $('#port').val(response.data[0].port);
        }
      } else {
        toastr.error(response.message);
      }
    });
  };

  const updateServers = function (e) {
    e.preventDefault();
    $.post(WPSFTP_AJAX_URL, {
      action: 'wpsftp_servers',
      data: $serverForm.serializeObject()
    }, function (response) {
      if (response.success === true) {
        toastr.success(response.message);
      } else {
        toastr.error(response.message);
      }
    });
  };

  const testConnection = function () {
    $.post(WPSFTP_AJAX_URL, {
      action: 'wpsftp_test_connection'
    }, function (response) {
      console.log(response);
      if (response.success === true) {
        toastr.success(response.message);
      } else {
        toastr.error(response.message);
      }
    })
  }

  const testSFTP = function () {
    $.post(WPSFTP_AJAX_URL, {
      action: 'wpsftp_test_sftp'
    }, function(response){
      console.log(response);
    })
  }

  // secret sauce method, thanks Paul Colella
  jQuery.fn.serializeObject = function () {
    let arrayData, objectData;
    arrayData = this.serializeArray();

    objectData = {};

    $.each(arrayData, function () {
      let value;

      if (this.value != null) {
        value = this.value;
      } else {
        value = '';
      }

      if (objectData[this.name] != null) {
        if (!objectData[this.name].push) {
          objectData[this.name] = [objectData[this.name]];
        }

        objectData[this.name].push(value);
      } else {
        objectData[this.name] = value;
      }
    });

    return objectData;
  };

  $(document).ready(function () {
    pageInit();
  });
})(jQuery);