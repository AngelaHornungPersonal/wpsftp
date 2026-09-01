<?php
use phpseclib3\Crypt\RSA;

function wp_ajax_wpsftp_crons() {
    $response = new stdClass();

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {

    } elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {

    } else {
        $response->success = false;
        $response->code = 400;
        $response->message = 'Invalid request method.';
    }

    wp_send_json($response);
}

function wp_ajax_wpsftp_keys() {
    global $wpdb;
    $response = new stdClass();

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        try {
            /* Do we have a key record, if yes return it, if not generate, store and return one */
            $data = $wpdb->get_results("SELECT * FROM " . WPSFTP_DB_PREFIX . WPSFTP_KEYS_TABLE_NAME);

            if ($data == null) {
                //generate & save keys
                $privateKey = RSA::createKey(4096);

                //todo generate random passphrase and store into .env for program access
                //PKCS8 stands for Public Key Cryptography Standards #8 which adds the Being Private Key & End Private Key plus some additional formatting
                $protectedPrivateKey = $privateKey->withPassword('@Tru$t3d2o27!~')->toString('PKCS8');
                $publicKey = $privateKey->getPublicKey()->toString('PKCS8');

                $wpdb->insert(WPSFTP_DB_PREFIX . WPSFTP_KEYS_TABLE_NAME, array(
                    'encryptedPrivateKey' => $protectedPrivateKey,
                    'publicKey' => $publicKey,
                    'create_date' => date('Y-m-d H:i:s'),
                ));

                $response->data = $publicKey;

            } else {
                $response->data = $data[0]->publicKey;
            }

            $response->success = true;
            $response->message = 'Keys Acquired';
        } catch (\Exception $e) {
            $response->success = false;
            $response->code = 400;
            $response->message = $e->getMessage();
        }
    } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
        try {
            /* No need to generate, delete key then js recalls get which generates one if none exists */
            $wpdb->query('TRUNCATE TABLE ' . WPSFTP_DB_PREFIX . WPSFTP_KEYS_TABLE_NAME);

            $response->success = true;
            $response->code = 200;
            $response->message = 'Credentials Updated';
        } catch (Exception $e) {
            $response->success = false;
            $response->code = 400;
            $response->message = $e->getMessage();
        }
    } else {
        $response->success = false;
        $response->code = 400;
        $response->message = 'Invalid Request Method';
    }

    wp_send_json($response);
}

function wp_ajax_wpsftp_logs() {
    $response = new stdClass();

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {

    } else {
        $response->success = false;
        $response->code = 400;
        $response->message = 'Invalid request method.';
    }

    wp_send_json($response);
}

function wp_ajax_wpsftp_servers() {
    global $wpdb;
    $response = new stdClass();

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        try {
            $data = $wpdb->get_results("SELECT * FROM " . WPSFTP_DB_PREFIX . WPSFTP_SERVER_TABLE_NAME);

            $response->success = true;
            $response->code = 200;
            $response->data = $data;
            $response->message = 'Got Server Data';
        } catch (\Exception $e) {
            $response->success = false;
            $response->code = 400;
            $response->message = $e->getMessage();
        }
    } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
        try {
            //todo add paid gateway for multi server management & better validation
            $wpdb->query("TRUNCATE TABLE " . WPSFTP_DB_PREFIX . WPSFTP_SERVER_TABLE_NAME);

            $data = $_POST['data'];

            $wpdb->insert(WPSFTP_DB_PREFIX . WPSFTP_SERVER_TABLE_NAME, array(
                'ip' => sanitize_text_field($_POST['data']['ip']),
                'username' => sanitize_text_field($_POST['data']['username']),
            ));

            $response->success = true;
            $response->code = 200;
            $response->message = 'Updated Server Data';
        } catch (\Exception $e) {
            $response->success = false;
            $response->code = 400;
            $response->message = $e->getMessage();
        }
    } else {
        $response->success = false;
        $response->code = 400;
        $response->message = 'Invalid request method.';
    }

    wp_send_json($response);
}

function wp_ajax_wpsftp_test_connection() {
    global $wpdb;
    $response = new stdClass();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //there should only ever be one record in that table
        $keys = $wpdb->get_results("SELECT * FROM " . WPSFTP_DB_PREFIX . WPSFTP_KEYS_TABLE_NAME . " WHERE id=1");
    } else {
        $response->success = false;
        $response->code = 400;
        $response->message = 'Invalid request method.';
    }

    wp_send_json($response);
}