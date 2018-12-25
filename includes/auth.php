<?php

$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : "";

if (!$userId) {
    header('location: ' . url('/login.php'));
    exit;
}