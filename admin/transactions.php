<?php

include(__DIR__ . '/../config.php');
include(INCLUDE_PATH . '/auth.php');

$action = isset($_GET['action']) ? $_GET['action'] : null;

switch ($action) {
    case 'details':
        details();
        break;
    default:
        index();
}

function index()
{
    $data = [];
    $data['page_title'] = __('Transactions');
    $data['active_menu'] = 'transactions';

    $query = 'order by id desc';
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $data['transactions'] = paginate('transactions', $query, $page, 20);

    include(ADMIN_PATH . '/templates/transactions.php');
}

function details()
{
    if (isset($_GET['id'])) {
        $transaction = R::load('transactions', $_GET['id']);
        if ($transaction) {
            $data = [];
            $data['page_title'] = __('Transaction Details');
            $data['transaction'] = $transaction;

            include(ADMIN_PATH . '/templates/transaction-details.php');
        }
    }
}

$_SESSION['alerts'] = null;