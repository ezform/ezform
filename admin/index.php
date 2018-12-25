<?php

require(__DIR__ . '/../config.php');
require(INCLUDE_PATH . '/auth.php');

$action = isset($_GET['action']) ? $_GET['action'] : null;

switch ($action) {
    default:
        index();
}

function index()
{
    header('location: ' . url('/admin/transactions.php'));
    exit;
}

$_SESSION['alerts'] = null;