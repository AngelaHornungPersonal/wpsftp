<?php

use phpseclib3\Crypt\PublicKeyLoader;
use phpseclib3\Net\SFTP;
function wpsftp_cron_job() {
    global $wpdb;

    try {
        $server = $wpdb->get_results("SELECT * FROM " . WPSFTP_DB_PREFIX . WPSFTP_SERVER_TABLE_NAME);
        $key = $wpdb->get_results("SELECT * FROM " . WPSFTP_DB_PREFIX . WPSFTP_KEYS_TABLE_NAME);
        $pvKey = PublicKeyLoader::load($key[0]->encryptedPrivateKey, '@Tru$t3d2o27!~');

        //set no timeout, disconnect once done with download
        $sftp = new SFTP($server[0]->ip, $server[0]->port, 0);
        if (!$sftp->login($server[0]->username, $pvKey)) {
            throw new \Exception("SFTP login failed");
        }

        $remoteDirectory = '/wp-content/uploads';
        $localDirectory = WP_CONTENT_DIR . '/uploads/wpsftp-downloads';

        downloadRemoteDirectory($sftp, $remoteDirectory, $localDirectory);

        $sftp->disconnect();
    } catch (\Exception $e) {
        //todo log error
        die($e->getMessage());
    }
}

function downloadRemoteDirectory(SFTP $sftp, string $remoteDirectory, string $localDirectory): void
{
    if (!is_dir($localDirectory)) {
        mkdir($localDirectory, 0755, true);
    }

    $files = $sftp->rawList($remoteDirectory);
    if ($files === false) {
        return;
    }
    foreach($sftp->rawList($remoteDirectory) as $fileName => $file) {
        if ($fileName == '.' || $fileName == '..') {
            continue;
        }

        $remotePath = rtrim($remoteDirectory, '/') . '/' . $fileName;
        $localPath = rtrim($localDirectory, '/') . '/' . $fileName;

        if ($sftp->is_dir($remotePath)) {
            downloadRemoteDirectory($sftp, $remotePath, $localPath);
        } else {
            $sftp->get($remotePath, $localPath);
        }
    }
}
