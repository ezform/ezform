<?php

include(__DIR__ . '/../config.php');
include(INCLUDE_PATH . '/auth.php');

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

    $latestRelease = curl_get('https://ezform.ir/release.json');
    if ($latestRelease) {
        if (isset($latestRelease->version) && version_compare($latestRelease->version, app_version()) > 0) {
            $data['release'] = $latestRelease;
        }
    }

    include(ADMIN_PATH . '/templates/update.php');
}

function install()
{
    $latestRelease = curl_get('https://ezform.ir/release.json');
    if ($latestRelease) {
        if (isset($latestRelease->version) && version_compare($latestRelease->version, app_version()) > 0) {
            $file = file_get_contents($latestRelease->url, false, $context);
            if (!file_exists(BASE_PATH . '/tmp')) {
                mkdir(BASE_PATH . '/tmp');
            }
            file_put_contents(BASE_PATH . '/tmp/update.zip', $file);
            $zip = new ZipArchive;
            if ($zip->open(BASE_PATH . '/tmp/update.zip') === true) {
                $zip->extractTo(BASE_PATH . '/tmp');
                $zip->close();
                copy(__DIR__ . '/update-installer.php', BASE_PATH . '/update-installer.php');
                $_SESSION['maintenance_mode'] = true;
                header('location: ' . url('/update-installer.php'));
                exit;
            }
        }
    }
}

function cleanup()
{
    if (file_exists(BASE_PATH . '/tmp')) {
        rmdir_full(BASE_PATH . '/tmp');
    }
    if (file_exists(BASE_PATH . '/install')) {
        rmdir_full(BASE_PATH . '/install');
    }
    if (file_exists(BASE_PATH . '/config-sample.php')) {
        unlink(BASE_PATH . '/config-sample.php');
    }
    if (file_exists(BASE_PATH . '/update-installer.php')) {
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