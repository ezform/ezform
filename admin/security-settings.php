<?php

require(__DIR__ . '/../config.php');
require(INCLUDE_PATH . '/auth.php');

$action = isset($_GET['action']) ? $_GET['action'] : null;

switch ($action) {
    case 'change_password':
        change_password();
        break;
    default:
        index();
}

function index()
{
    $data = [];
    $data['page_title'] = __('Security Settings');
    $data['active_menu'] = 'security-settings';

    require(ADMIN_PATH . '/templates/security-settings.php');
}

function change_password()
{
    $alerts = [];
    if (!$_POST['current_password']) {
        array_push($alerts, [
            'type'    => 'danger',
            'message' => __('Current password is required')
        ]);
    }
    if (!$_POST['password']) {
        array_push($alerts, [
            'type'    => 'danger',
            'message' => __('New password is required')
        ]);
    }
    if (!$_POST['password_confirmation']) {
        array_push($alerts, [
            'type'    => 'danger',
            'message' => __('Password confirmation is required')
        ]);
    } else {
        if ($_POST['password'] !== $_POST['password_confirmation']) {
            array_push($alerts, [
                'type'    => 'danger',
                'message' => __('Password confirmation not match')
            ]);
        }
    }

    if ($alerts) {
        $_SESSION['alerts'] = $alerts;
        header('location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    $user = R::load('users', $_SESSION['user_id']);
    if (!password_verify($_POST['current_password'], $user->password)) {
        array_push($alerts, [
            'type'    => 'danger',
            'message' => __('Current password is wrong')
        ]);
    }

    if ($alerts) {
        $_SESSION['alerts'] = $alerts;
        header('location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    $user->password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    R::store($user);

    array_push($alerts, [
        'type'    => 'success',
        'message' => __('Changes saved')
    ]);
    $_SESSION['alerts'] = $alerts;
    header('location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}

$_SESSION['alerts'] = null;