<?php

require(__DIR__ . '/../config.php');
require(INCLUDE_PATH . '/auth.php');

$action = isset($_GET['action']) ? $_GET['action'] : null;

switch ($action) {
    case 'edit':
        edit();
        break;
    default:
        index();
}

function index()
{
    $data = [];
    $data['page_title'] = __('Site Settings');
    $data['active_menu'] = 'site-settings';

    $data['configs'] = R::findAll('configs');

    require(ADMIN_PATH . '/templates/site-settings.php');
}

function edit()
{
    $alerts = [];
    if (isset($_GET['id'])) {
        $config = R::load('configs', $_GET['id']);
        if ($config) {
            $config->value = $_POST['value'];
            R::store($config);

            array_push($alerts, [
                'type'    => 'success',
                'message' => __('Changes saved')
            ]);
            $_SESSION['alerts'] = $alerts;
            header('location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }
    }

    array_push($alerts, [
        'type'    => 'danger',
        'message' => __('Not Found')
    ]);
    $_SESSION['alerts'] = $alerts;
    header('location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}

$_SESSION['alerts'] = null;