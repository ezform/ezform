<?php

require(__DIR__ . '/../config.php');
require(INCLUDE_PATH . '/auth.php');

$action = isset($_GET['action']) ? $_GET['action'] : null;

switch ($action) {
    case 'install':
        install();
        break;
    default:
        index();
}

function index()
{
    $data = [];
    $data['page_title'] = __('Update');
    $data['active_menu'] = 'update';

    $releases = curl_get('https://api.github.com/repos/ezform/ezform/releases');
    foreach ($releases as $release) {
        if (!$release->prerelease) {
            if (version_compare($release->tag_name, APP_VERSION) > 0) {
                $data['release'] = $release;
            }
        }
    }

    require(ADMIN_PATH . '/templates/update.php');
    exit;
}

function install()
{

}

$_SESSION['alerts'] = null;