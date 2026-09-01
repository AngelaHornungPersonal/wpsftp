<?php

?>
<script>
  WPSFTP_AJAX_URL = '<?php echo esc_url(admin_url('admin-ajax.php', 'relative')); ?>';
</script>
<h3>Keys</h3>
<div class="row">
    <div class="col-md-6">
        <h4>Key Generator</h4>
        <div class="row" style="margin-top: 15px;">
            <div class="form-group">
                <label for="public-key" hidden>Public Key</label>
                <textarea type="text" id="public-key" style="width: 100%; height: 150px;" readonly></textarea>
            </div>
        </div>
        <div class="row" style="margin-top: 15px;">
            <a class="btn btn-success" style="max-width: 250px; margin-left: 10px;" id="new-keys">Generate New Keys</a>
        </div>
    </div>
    <div class="col-md-4">
        <h4>Details</h4>
        <p>To ensure we don't need to store your SFTP passwords which is a high security risk, we instead
        generate keys. One key is private and stays on this Wordpress install's host. The other key is public
        and you'll install it into the Wordpress install's host you're attempting to clone. Keys can be replaced
        with the click of a button.</p>
    </div>
</div>
