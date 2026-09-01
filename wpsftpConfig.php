<?php

/* Global General Config */
define('WPSFTP_PLUGIN_NAME', 'WPSFTP');
define('WPSFTP_PLUGIN_SLUG', 'wpsftp');
define('WPSFTP_PLUGIN_VERSION', '0.0.1');

/* Global File Paths */
define('WPSFTP_ROOT_DIR_NAME', 'wpsftp');
define('WPSFTP_ROOT_DIR_PATH', plugin_dir_path(__FILE__));
define('WPSFTP_ADMIN_DIR_PATH', WPSFTP_ROOT_DIR_PATH . 'admin');
define('WPSFTP_ASSETS_DIR_PATH', WPSFTP_ROOT_DIR_PATH . 'assets');
define('WPSFTP_EMAIL_DIR_PATH', WPSFTP_ROOT_DIR_PATH . 'email');
define('WPSFTP_UTIL_DIR_PATH', WPSFTP_ROOT_DIR_PATH . 'util');

/* Global Directory URLS */
define('WPSFTP_ROOT_DIR_URL', plugin_dir_url(__FILE__));
define('WPSFTP_ADMIN_URL', plugin_dir_url(__FILE__) . 'admin');
define('WPSFTP_ASSETS_URL', plugin_dir_url(__FILE__) . 'assets');
define('WPSFTP_EMAIL_URL', plugin_dir_url(__FILE__) . 'email');
define('WPSFTP_UTIL_URL', plugin_dir_url(__FILE__) . 'util');

/* Global Database Details */
global $wpdb;
define('WPSFTP_PLUGIN_PREFIX', 'wpsftp');
define('WPSFTP_DB_PREFIX', 'wpsftp_');
define('WPSFTP_KEYS_TABLE_NAME', 'keys');
define('WPSFTP_SERVER_TABLE_NAME', 'servers');
