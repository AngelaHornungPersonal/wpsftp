<?php
/*
 * Plugin Name: WPSFTP
 * Description: An automated SFTP service which clones a designated site into the Wordpress install it sits on in regular intervals
 * Requires at least: 7.0
 * Requires PHP: 8.0.0
 * Author: Angela Hornung
 * Prefix: wpsftp
 */

//load classes and configs
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'wpsftpConfig.php');
require WPSFTP_ROOT_DIR_PATH . DIRECTORY_SEPARATOR . 'vendor/autoload.php';
require_once(WPSFTP_UTIL_DIR_PATH . DIRECTORY_SEPARATOR . 'wpsftp-db.php');
require_once(WPSFTP_UTIL_DIR_PATH . DIRECTORY_SEPARATOR . 'wpsftp-ajax.php');
require_once(WPSFTP_UTIL_DIR_PATH . DIRECTORY_SEPARATOR . 'wpsftp-cron.php');

//hooks
register_activation_hook(__FILE__, 'wpsftp_activate');
register_deactivation_hook(__FILE__, 'wpsftp_deactivate');
register_uninstall_hook(__FILE__, 'wpsftp_uninstall');

//actions
add_action('admin_menu', 'wpsftp_admin_menu');
add_action('wp_enqueue_scripts', 'wpsftp_wp_enqueue_scripts');
add_action('admin_enqueue_scripts', 'wpsftp_wp_enqueue_scripts');

//ajax actions
add_action('wp_ajax_wpsftp_crons', 'wp_ajax_wpsftp_crons');
add_action('wp_ajax_wpsftp_keys', 'wp_ajax_wpsftp_keys');
add_action('wp_ajax_wpsftp_logs', 'wp_ajax_wpsftp_logs');
add_action('wp_ajax_wpsftp_servers', 'wp_ajax_wpsftp_servers');
add_action('wp_ajax_wpsftp_test_connection', 'wp_ajax_wpsftp_test_connection');
add_action('wp_ajax_wpsftp_test_sftp', 'wpsftp_cron_job');

/**
 * @throws Exception
 */
function wpsftp_activate() {
    if (wpsftp_activate_db() !== true) {
        throw new \Exception('Failed to activate WPSFTP due to database table initiation failure.');
    }
}

function wpsftp_deactivate() {
    //todo add warning & questionnaire
}

function wpsftp_uninstall() {
    //todo add cron-job backup & removal
}

function wpsftp_admin_menu() {
    add_menu_page(
        'WPSFTP Admin',
        'WPSFTP Admin',
        'manage_options',
        'wpsftp',
        'wpsftp_admin_page'
    );
}

function wpsftp_admin_page()
{
    ?>
    <div class="wrap">
        <div class="wpsftp-wrapper">
            <?php include(WPSFTP_ADMIN_DIR_PATH . DIRECTORY_SEPARATOR . 'admin.php'); ?>
            <?php wp_enqueue_script('admin-js', WPSFTP_ADMIN_URL . '/admin.js', array('jquery')); ?>
        </div>
    </div>
    <?php
}

function wpsftp_wp_enqueue_scripts() {
    /* bootstrap */
    wp_enqueue_style('bootstrap-css', WPSFTP_ASSETS_URL . '/style/bootstrap/css/wpsftp-bootstrap.css');
    wp_enqueue_script('bootstrap-js', WPSFTP_ASSETS_URL . '/style/bootstrap/js/bootstrap.min.js', array('jquery'), null, true);

    /* toastr */
    wp_enqueue_style('toastr-css', WPSFTP_ASSETS_URL . '/toastr/build/toastr.css');
    wp_enqueue_script('toastr-js', WPSFTP_ASSETS_URL . '/toastr/build/toastr.min.js');
}
?>

