<?php

function __($key)
{
    if (file_exists(THEMES_PATH . '/' . site_config('site_theme') . '/languages/' . site_config('locale') . '.json')) {
        $themeLang = file_get_contents(THEMES_PATH . '/' . site_config('site_theme') . '/languages/' . site_config('locale') . '.json');
        $themeLang = json_decode($themeLang, true);
        if (isset($themeLang[$key])) {
            return $themeLang[$key];
        }
    }
    if (file_exists(LANGUAGES_PATH . '/' . site_config('locale') . '.json')) {
        $coreLang = file_get_contents(LANGUAGES_PATH . '/' . site_config('locale') . '.json');
        $coreLang = json_decode($coreLang, true);
        if (isset($coreLang[$key])) {
            return $coreLang[$key];
        }
    }

    return $key;
}

function site_config($key)
{
    $config = R::findOne('configs', '`key` = ?', [$key]);

    return $config->getProperties()['value'];
}

function curl_post($url, $params)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
    ]);
    $res = curl_exec($ch);
    curl_close($ch);

    return $res;
}

function curl_get($url)
{
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL            => $url,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_TIMEOUT        => 30,
        CURLOPT_HTTPHEADER     => [
            'User-Agent: EZForm',
        ]
    ]);
    $res = curl_exec($ch);
    curl_close($ch);

    return json_decode($res);
}

function custom_money_format($money)
{
    return number_format($money, 0, '', ',');
}

function paginate($table, $query, $page, $perPage)
{
    $data = [];
    $data['current_page'] = $page;
    $data['per_page'] = $perPage;
    $data['total_pages'] = ceil(R::count($table, $query) / $perPage);
    $data['data'] = R::findAll($table, $query . ' limit ?, ? ', [(($page - 1) * $perPage), $perPage]);

    return $data;
}

function url($u)
{
    return site_config('site_url') . $u;
}

function app_version()
{
    if (file_exists(BASE_PATH . '/info.json')) {
        $info = json_decode(file_get_contents(BASE_PATH . '/info.json'));
        if (isset($info->version)) {
            return $info->version;
        }
    }

    return null;
}

function rmdir_full($dir)
{
    if (!file_exists($dir)) {
        return true;
    }
    if (!is_dir($dir)) {
        return unlink($dir);
    }
    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }
        if (!rmdir_full($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }
    }

    return rmdir($dir);
}