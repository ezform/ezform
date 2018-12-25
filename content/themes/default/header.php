<?php
if (!defined('BASE_PATH')) {
    echo "<h1>404 Not Found</h1>";
    exit;
}
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $data['page_title'] ?></title>
    <link rel="stylesheet" href="<?= SITE_URL . '/content/themes/default/css/styles.css' ?>">
</head>
<body>
