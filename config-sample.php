<?php

session_start();

define('SITE_URL', '{SITE_URL}');
define('DB_DSN', 'mysql:host={DB_HOST};dbname={DB_NAME}');
define('DB_NAME', '{DB_NAME}');
define('DB_USERNAME', '{DB_USERNAME}');
define('DB_PASSWORD', '{DB_PASSWORD}');
define('BASE_PATH', __DIR__);
define('INCLUDE_PATH', __DIR__ . '/includes');
define('LANGUAGES_PATH', __DIR__ . '/content/languages');
define('THEMES_PATH', __DIR__ . '/content/themes');
define('ADMIN_PATH', __DIR__ . '/admin');

include(INCLUDE_PATH . "/rb.php");
R::setup(DB_DSN, DB_USERNAME, DB_PASSWORD);

include(INCLUDE_PATH . "/jdf.php");
include(INCLUDE_PATH . "/functions.php");

function handleException($e)
{
    echo $e->getMessage();
}

set_exception_handler('handleException');