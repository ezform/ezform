<?php

if (!file_exists('config.php')) {
    install();
    exit;
}

include('config.php');

$action = isset($_GET['action']) ? $_GET['action'] : null;

switch ($action) {
    case 'pay':
        pay();
        break;
    case 'callback':
        callback();
        break;
    case 'installation_completed':
        installation_completed();
        break;
    case 'login':
        login();
        break;
    case 'logout':
        logout();
        break;
    default:
        index();
}

function index()
{
    $data = [];
    $data['page_title'] = site_config('site_title');
    $data['form_inputs'] = R::findAll('form_inputs');
    include(THEMES_PATH . '/' . site_config('site_theme') . '/index.php');
}

function pay()
{
    include(INCLUDE_PATH . '/payments/payir.php');

    if (!site_config('payment_amount')) {
        //$this->form_validation->set_rules('amount', 'amount', 'required|numeric', [
        //    'required' => site_config('payment_amount_label') . ' ' . $this->lang->line('is_required'),
        //    'numeric'  => site_config('payment_amount_label') . ' ' . $this->lang->line('must_be_numeric')
        //]);
        $amount = $_POST['amount'];
    } else {
        $amount = site_config('payment_amount');
    }
    $formInputs = R::findAll('form_inputs');
    foreach ($formInputs as $formInput) {
        if (!$formInput->optional) {
            //$this->form_validation->set_rules('input_' . $formInput->id, $formInput->title, 'required', [
            //    'required' => $formInput->title . ' ' . $this->lang->line('is_required')
            //]);
        }
    }
    $formData = $_POST;
    $formInputs = json_decode(json_encode($formInputs), true);
    $inputs = [];
    foreach ($formInputs as $key => $formInput) {
        $inputs[$key]['title'] = $formInput['title'];
        $inputs[$key]['value'] = $formData['input_' . $formInput['id']];
    }
    $transaction = R::dispense('transactions');
    $transaction->amount = $amount;
    $transaction->created_at = date('Y-m-d H:i:s');
    $transaction->description = json_encode($inputs);
    $id = R::store($transaction);

    $payir = R::findOne('payment_providers', '`name` = ?', ['payir']);

    $init = payir_init([
        'api'          => json_decode($payir->configs, true)['api_key'],
        'amount'       => $amount,
        'redirect'     => url('/?action=callback&payment_provider=payir'),
        'factorNumber' => $id
    ]);

    $transaction = R::loadForUpdate('transactions', $id);
    $transaction->token = $init['token'];
    R::store($transaction);

    header('location: ' . $init['payment_url']);
    exit;
}

function callback()
{
    include(INCLUDE_PATH . '/payments/payir.php');

    $data = null;
    if (isset($_GET['payment_provider'])) {
        switch ($_GET['payment_provider']) {
            case 'payir':
                $payir = R::findOne('payment_providers', '`name` = ?', ['payir']);
                $verify = payir_verify(json_decode($payir->configs, true)['api_key'], $_GET['token']);
                $transaction = R::loadForUpdate('transactions', $verify['factorNumber']);
                if ($transaction && $transaction->status == 0 && $transaction->amount == $verify['amount']) {
                    $transaction->transaction_id = $verify['transId'];
                    $transaction->status = 1;
                    $transaction->card_number = $verify['cardNumber'];
                    R::store($transaction);
                    $data['page_title'] = __('Payment Receipt');
                    $data['transaction'] = $transaction;
                    include(THEMES_PATH . '/' . site_config('site_theme') . '/receipt.php');
                    exit;
                }
                break;
        }
    }
    $_SESSION['alerts'] = [[
        'type'    => 'danger',
        'message' => __('Transaction not found')
    ]];
    header('location: ' . url('/'));
    exit;
}

function install()
{
    header('location: ./install');
    exit;
}

function installation_completed()
{
    if (file_exists(__DIR__ . '/install')) {
        rmdir_full(__DIR__ . '/install');
    }
    if (file_exists(__DIR__ . '/config-sample.php')) {
        unlink(__DIR__ . '/config-sample.php');
    }
    header('location: ' . url('/'));
    exit;
}

function login()
{
    $alerts = [];
    if (!$_POST['email']) {
        array_push($alerts, [
            'type'    => 'danger',
            'message' => __('Email is required')
        ]);
    }
    if (!$_POST['password']) {
        array_push($alerts, [
            'type'    => 'danger',
            'message' => __('Password is required')
        ]);
    }
    if ($alerts) {
        $_SESSION['alerts'] = $alerts;
        header('location: ' . url('/login.php'));
        exit;
    }

    $user = R::findOne('users', '`email` = ?', [$_POST['email']]);
    if ($user) {
        if (password_verify($_POST['password'], $user->password)) {
            $_SESSION['user_id'] = $user->id;
            header('location: ' . url('/admin'));
            exit;
        }
    }

    array_push($alerts, [
        'type'    => 'danger',
        'message' => __('Invalid credential')
    ]);
    $_SESSION['alerts'] = $alerts;
    header('location: ' . url('/login.php'));
    exit;
}

function logout()
{
    $_SESSION['user_id'] = null;
    header('location: ' . url('/login.php'));
    exit;
}

$_SESSION['alerts'] = null;