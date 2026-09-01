(function ($) {
  const pageInit = function() {
    console.log('keys.js');

    //actions
    $('#new-keys').on('click', generateKeys);
    getKeys();
  }

  const getKeys = function () {
    /* grabs public key if it exists, if it doesn't it generates a whole new key set and returns it */
    $.get(WPSFTP_AJAX_URL, {
      action: 'wpsftp_keys'
    }, function (response) {
      if (response.success === true) {
        $('#public-key').empty().val(response.data);
        toastr.success(response.message);
      } else {
        toastr.error(response.message);
      }
    })
  }

  /*
   * disabled while testing on my bench
   */
  const generateKeys = function () {
    /* if called, means new keys are requested, post deletes, get regenerates if none are found */
    /*$.post(WPSFTP_AJAX_URL, {
      action: 'wpsftp_keys'
    }, function (response) {
      if (response.success === true) {
        getKeys();
      } else {
        toastr.error(response.message);
      }
    });*/
  }

  $(document).ready(function() {
    pageInit();
  });
})(jQuery);