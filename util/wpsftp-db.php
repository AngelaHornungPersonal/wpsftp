<?php

function wpsftp_activate_db() {
    global $wpdb;

    try {
        $charset_collate = $wpdb->get_charset_collate();

        $tables = "CREATE TABLE " . WPSFTP_DB_PREFIX . WPSFTP_KEYS_TABLE_NAME . "(
        id int(9) NOT NULL AUTO_INCREMENT,
        encryptedPrivateKey varchar(4096) DEFAULT '' NOT NULL,
        publicKey varchar(4096) DEFAULT '' NOT NULL,
        create_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        PRIMARY KEY (id)) $charset_collate;";

        $tables .= "CREATE TABLE " . WPSFTP_DB_PREFIX . WPSFTP_SERVER_TABLE_NAME . "(
        id int(9) NOT NULL AUTO_INCREMENT,
        ip varchar(255) DEFAULT '' NOT NULL,
        username varchar(255) DEFAULT '' NOT NULL,
        port int(5) DEFAULT 22 NOT NULL,
        create_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        PRIMARY KEY (id)) $charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        if (!dbDelta($tables)){
            return false;
        }
    } catch (\Exception $e) {
        //todo log error
        return false;
    }

    return true;
}