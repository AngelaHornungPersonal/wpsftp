<?php

?>
<script>
    WPSFTP_AJAX_URL = '<?php echo esc_url(admin_url('admin-ajax.php', 'relative')); ?>';
</script>
<h2>WPSFTP Administration</h2>
<div class="row">
    <div class="col-md-2">
        <a class="btn btn-danger" style="width: 100%;">Report a Bug</a>
    </div>
    <div class="col-md-2">
        <a class="btn btn-warning" style="width: 100%;">Request Support</a>
    </div>
    <div class="col-md-2">
        <a class="btn btn-success" style="width: 100%;">Request a Feature</a>
    </div>
</div>
<div class="row" style="margin-top: 15px;">

</div>
<ul class="nav nav-tabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="server-nav" data-bs-toggle="tab" data-bs-target="#server-tab"
                type="button" role="tab" aria-controls="Server Management" aria-selected="false">Server Management</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="key-nav" data-bs-toggle="tab" data-bs-target="#key-tab"
                type="button" role="tab" aria-controls="Keys Management" aria-selected="false">Keys Management</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="cron-nav" data-bs-toggle="tab" data-bs-target="#cron-tab"
                type="button" role="tab" aria-controls="Cron Job Management" aria-selected="false">Cron Job Management</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="log-nav" data-bs-toggle="tab" data-bs-target="#log-tab"
                type="button" role="tab" aria-controls="Logs" aria-selected="false">Logs</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="file-nav" data-bs-toggle="tab" data-bs-target="#file-tab"
                type="button" role="tab" aria-controls="File Management" aria-selected="false">File Management</button>
    </li>
</ul>
<div class="tab-content" id="adminTablesContent">
    <div class="tab-pane fade" id="server-tab" role="tabpanel" aria-labelledby="server-tab">
        <?php include(plugin_dir_path(__FILE__) . 'partial/servers/servers.php'); ?>
        <?php wp_enqueue_script('server-js', WPSFTP_ADMIN_URL . '/partial/servers/servers.js', array('jquery')); ?>
    </div>
    <div class="tab-pane fade show active" id="key-tab" role="tabpanel" aria-labelledby="key-tab">
        <?php include(plugin_dir_path(__FILE__) . 'partial/keys/keys.php'); ?>
        <?php wp_enqueue_script('key-js', WPSFTP_ADMIN_URL . '/partial/keys/keys.js', array('jquery')); ?>
    </div>
    <div class="tab-pane fade" id="cron-tab" role="tabpanel" aria-labelledby="cron-tab">
        <?php include(plugin_dir_path(__FILE__) . 'partial/crons/crons.php'); ?>
        <?php wp_enqueue_script('cron-js', WPSFTP_ADMIN_URL . '/partial/crons/crons.js', array('jquery')); ?>
    </div>
    <div class="tab-pane fade" id="log-tab" role="tabpanel" aria-labelledby="log-tab">
        <?php include(plugin_dir_path(__FILE__) . 'partial/logs/logs.php'); ?>
        <?php wp_enqueue_script('log-js', WPSFTP_ADMIN_URL . '/partial/logs/logs.js', array('jquery')); ?>
    </div>
    <div class="tab-pane fade" id="file-tab" role="tabpanel" aria-labelledby="file-tab">
        <?php include(plugin_dir_path(__FILE__) . 'partial/files/files.php'); ?>
        <?php wp_enqueue_script('file-js', WPSFTP_ADMIN_URL . '/partial/files/files.js', array('jquery')); ?>
    </div>
</div>
