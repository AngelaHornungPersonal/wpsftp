<?php

?>
<script>
  WPSFTP_AJAX_URL = '<?php echo esc_url(admin_url('admin-ajax.php', 'relative')); ?>';
</script>
<h3>Server Management</h3>
<div class="row">
    <div class="col-md-8">
        <form id="servers-form">
            <div class="form-group">
                <label for="address">Server Address</label>
                <input type="text" id="address" required>
                <label for="username">Server SFTP Username</label>
                <input type="text" id="username" required>
                <a class="btn btn-primary" type="submit" id="server-form-submit"><i class="fa fa-floppy-o"></i>Submit</a>
            </div>
        </form>
    </div>
    <div class="col-md-4">
        <h4>Details</h4>
        <p>While we don't need your server's SFTP password since we use keys (next tab has explanation)
        we do require your server's IP address so we can find it and your server's SFTP username. This is
        so with your generated key we can authenticate an SFTP connection to your server and upon a schedule
        of your choosing, clone x site's directory into this one. Allowing you to keep an upto date clone
        ready for deployment at a moment's notice. </p>
    </div>
</div>
