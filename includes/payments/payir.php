<?php

function payir_init($data)
{
    $result = curl_post('https://pay.ir/pg/send', [
        'api'          => isset($data['api']) ? $data['api'] : null,
        'amount'       => isset($data['amount']) ? $data['amount'] : null,
        'redirect'     => isset($data['redirect']) ? $data['redirect'] : null,
        'mobile'       => isset($data['mobile']) ? $data['mobile'] : null,
        'factorNumber' => isset($data['factorNumber']) ? $data['factorNumber'] : null,
        'description'  => isset($data['description']) ? $data['description'] : null,
        'resellerId'   => '1000000012'
    ]);

    $result = json_decode($result, true);

    if (isset($result['token'])) {
        return [
            'payment_url' => 'https://pay.ir/pg/' . $result['token'],
            'token'       => $result['token']
        ];
    }

    $_SESSION['alerts'] = [[
        'type'    => 'danger',
        'message' => $result['errorMessage']
    ]];
    header('location: ' . url('/'));
    exit;
}

function payir_verify($api, $token)
{
    $result = curl_post('https://pay.ir/pg/verify', [
        'api'   => $api,
        'token' => $token,
    ]);

    $result = json_decode($result, true);

    if (isset($result['status']) && $result['status'] == '1') {
        return $result;
    }

    $_SESSION['alerts'] = [[
        'type'    => 'danger',
        'message' => $result['errorMessage']
    ]];
    header('location: ' . url('/'));
    exit;
}