<?php

include(__DIR__ . '/../config.php');
include(INCLUDE_PATH . '/auth.php');

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