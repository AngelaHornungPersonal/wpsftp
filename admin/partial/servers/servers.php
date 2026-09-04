<?php

?>
<script>
  WPSFTP_AJAX_URL = '<?php echo esc_url(admin_url('admin-ajax.php', 'relative')); ?>';
</script>
<h3>Server Management</h3>
<div class="row">
    <div class="col-md-9">
        <h4>Server Form</h4>
        <form id="server-form" method="post">
            <div class="form-group">
                <label for="ip">Server Address</label>
                <input type="text" id="ip" name="ip" required>
                <label for="username">Server SFTP Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group" style="margin-top: 15px;">
                <label for="port">Port Number</label>
                <input type="number" id="port" name="port" required>
                <input class="btn btn-secondary" type="submit" value="submit" id="server-submit">
            </div>
        </form>
    </div>
    <div class="col-md-3">
        <h4>Details</h4>
        <p>While we don't need your server's SFTP password since we use keys (next tab has explanation)
        we do require your server's IP address so we can find it and your server's SFTP username. This is
        so with your generated key we can authenticate an SFTP connection to your server and upon a schedule
        of your choosing, clone x site's directory into this one. Allowing you to keep an upto date clone
        ready for deployment at a moment's notice. </p>
        <a class="btn btn-primary" id="connection-test">Test Connection</a>
        <a class="btn btn-primary" id="sftp-test">Test SFTP</a>
    </div>
</div>
<div class="row" hidden>
    <h3>Server Table</h3>
    <!-- server table for paid version of software -->
</div>
