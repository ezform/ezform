<?php

require(__DIR__ . '/../config.php');
require(INCLUDE_PATH . '/auth.php');

$action = isset($_GET['action']) ? $_GET['action'] : null;

switch ($action) {
    case 'install':
        install();
        break;
    case 'cleanup':
        cleanup();
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
            if (version_compare($release->tag_name, app_version()) > 0) {
                $data['release'] = $release;
                break;
            }
        }
    }

    require(ADMIN_PATH . '/templates/update.php');
    exit;
}

function install()
{
    if (isset($_GET['release']) && version_compare($_GET['release'], app_version()) > 0) {
        $opts = [
            'http' => [
                'method' => 'GET',
                'header' => 'User-Agent: EZForm'
            ]
        ];
        $context = stream_context_create($opts);
        $file = file_get_contents('https://api.github.com/repos/ezform/ezform/zipball/' . $_GET['release'], false, $context);
        if (!file_exists(BASE_PATH . '/tmp')) {
            mkdir(BASE_PATH . '/tmp');
        }
        file_put_contents(BASE_PATH . '/tmp/update.zip', $file);
        $zip = new ZipArchive;
        if ($zip->open(BASE_PATH . '/tmp/update.zip') === true) {
            $zip->extractTo(BASE_PATH . '/tmp');
            $zip->close();
            copy(__DIR__ . 'update-installer.php', BASE_PATH);
            $_SESSION['maintenance_mode'] = true;
            header('location: ' . url('/update-installer.php'));
            exit;
        }
    }
}

function cleanup()
{
    if (!file_exists(BASE_PATH . '/tmp')) {
        rmdir(BASE_PATH . '/tmp');
    }
    if (!file_exists(BASE_PATH . '/update-installer.php')) {
        unlink(BASE_PATH . '/update-installer.php');
    }
    array_push($alerts, [
        'type'    => 'success',
        'message' => __('Updated')
    ]);
    $_SESSION['alerts'] = $alerts;
    $_SESSION['maintenance_mode'] = null;
    header('location: ' . url('/admin/update.php'));
    exit;
}

$_SESSION['alerts'] = null;