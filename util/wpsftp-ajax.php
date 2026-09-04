<?php

use phpseclib3\Crypt\PublicKeyLoader;
use phpseclib3\Crypt\RSA;
use phpseclib3\Net\SSH2;

function wp_ajax_wpsftp_crons()
{
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

function wp_ajax_wpsftp_keys()
{
    global $wpdb;
    $response = new stdClass();

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        try {
            /* Do we have a key record, if yes return it, if not generate, store and return one */
            $data = $wpdb->get_results("SELECT * FROM " . WPSFTP_DB_PREFIX . WPSFTP_KEYS_TABLE_NAME);

            if ($data == null) {
                /*
                 * PKCS8 stands for Public Key Cryptography Standards #8
                 * which adds the Being Private Key & End Private Key plus some additional formatting
                 */

                //todo generate random passphrase & its separated storage from the secret key
                $privateKey = RSA::createKey(4096);
                $protectedPrivateKey = $privateKey->withPassword('@Tru$t3d2o27!~')->toString('OpenSSH');
                $publicKey = $privateKey->getPublicKey()->toString('OpenSSH');

                $wpdb->insert(WPSFTP_DB_PREFIX . WPSFTP_KEYS_TABLE_NAME, array(
                    'encryptedPrivateKey' => $protectedPrivateKey,
                    'publicKey' => $publicKey,
                    'create_date' => date('Y-m-d H:i:s'),
                ));

                $response->data = $publicKey;

            } else {
                //private key accessed for authentication in our cron script
                $response->data = $data[0]->publicKey;
            }

            $response->success = true;
            $response->message = 'Key Acquired';
        } catch (\Exception $e) {
            $response->success = false;
            $response->code = 400;
            $response->message = $e->getMessage();
        }
    } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
        try {
            /* No need to generate, delete key then js recalls get which generates one if none exist */
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

function wp_ajax_wpsftp_logs()
{
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

function wp_ajax_wpsftp_servers()
{
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
            //todo add proper paid gateway for multi server management & better validation
            $paid = false;
            if ($paid === false) {
                $wpdb->query("TRUNCATE TABLE " . WPSFTP_DB_PREFIX . WPSFTP_SERVER_TABLE_NAME);
            }

            $wpdb->insert(WPSFTP_DB_PREFIX . WPSFTP_SERVER_TABLE_NAME, array(
                'ip' => sanitize_text_field($_POST['data']['ip']),
                'username' => sanitize_text_field($_POST['data']['username']),
                'port' => sanitize_text_field(intval($_POST['data']['port'])),
                'create_date' => date('Y-m-d H:i:s'),
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

function wp_ajax_wpsftp_test_connection()
{
    global $wpdb;
    $response = new stdClass();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        try {
            //todo allow for multiple servers & keys to be tested and return an array of responses, this is for the future
            $server = $wpdb->get_results("SELECT * FROM " . WPSFTP_DB_PREFIX . WPSFTP_SERVER_TABLE_NAME);
            $key = $wpdb->get_results("SELECT * FROM " . WPSFTP_DB_PREFIX . WPSFTP_KEYS_TABLE_NAME);
            $ssh = new SSH2($server[0]->ip, $server[0]->port);
            $pvKey = PublicKeyLoader::load($key[0]->encryptedPrivateKey, '@Tru$t3d2o27!~');

            if (!$ssh->login($server[0]->username, $pvKey)) {
                throw new \Exception('SSH2 Login Failed!.');
            }

            $response->success = true;
            $response->code = 200;
            $response->message = 'Connection Successful!';
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