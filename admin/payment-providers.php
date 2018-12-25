<?php

require(__DIR__ . '/../config.php');
require(INCLUDE_PATH . '/auth.php');

$action = isset($_GET['action']) ? $_GET['action'] : null;

switch ($action) {
    case 'payir':
        payir();
        break;
    default:
        index();
}

function index()
{
    $data = [];
    $data['page_title'] = __('Payment Providers');
    $data['active_menu'] = 'payment-providers';

    $data['payir'] = R::findOne('payment_providers', '`name` = ?', ['payir']);

    require(ADMIN_PATH . '/templates/payment-providers.php');
    exit;
}

function payir()
{
    $alerts = [];
    if (!$_POST['api_key']) {
        array_push($alerts, [
            'type'    => 'danger',
            'message' => __('API Key is required')
        ]);
    }

    if ($alerts) {
        $_SESSION['alerts'] = $alerts;
        header('location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    $payir = R::findOne('payment_providers', '`name` = ?', ['payir']);
    $payir->configs = json_encode(['api_key' => $_POST['api_key']]);
    R::store($payir);

    array_push($alerts, [
        'type'    => 'success',
        'message' => __('Changes saved')
    ]);
    $_SESSION['alerts'] = $alerts;
    header('location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}

$_SESSION['alerts'] = null;