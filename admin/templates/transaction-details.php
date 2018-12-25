<?php
if (!defined('BASE_PATH')) {
    echo "<h1>404 Not Found</h1>";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $data['page_title'] ?></title>
    <link rel="stylesheet" href="<?= url('/includes/css/styles.css') ?>">
</head>
<body class="window">
    <div>
        <br>
        <h2 class="text-center text-info"><b><?= $data['page_title'] ?></b></h2>
        <br>
        <div class="table-responsive">
            <table class="table table-bordered text-center" style="table-layout: fixed;">
                <tbody>
                    <tr>
                        <td>
                            <?= __('ID') ?>
                        </td>
                        <td><?= $data['transaction']->id ?></td>
                    </tr>
                    <tr>
                        <td>
                            <?= __('Amount') ?>
                        </td>
                        <td><?= custom_money_format($data['transaction']->amount) ?></td>
                    </tr>
                    <tr>
                        <td>
                            <?= __('Status') ?>
                        </td>
                        <td>
                            <span class="<?= $data['transaction']->status ? 'text-success' : 'text-danger' ?>"><?= $data['transaction']->status ? __('Success') : __('Failed') ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?= __('Transaction ID') ?>
                        </td>
                        <td><?= $data['transaction']->transaction_id ?></td>
                    </tr>
                    <tr>
                        <td>
                            <?= __('Card Number') ?>
                        </td>
                        <td style="direction: ltr">
                            <span><?= $data['transaction']->card_number ?></span>
                        </td>
                    </tr>
                    <?php if (json_decode($data['transaction']->description, true)) : ?>
                        <tr>
                            <td>
                                <?= __('Inputs') ?>
                            </td>
                            <td>
                                <?php foreach (json_decode($data['transaction']->description, true) as $input) : ?>
                                    <b><?= $input['title'] ?> : </b> <?= $input['value'] ?> <br>
                                <?php endforeach; ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <tr>
                        <td>
                            <?= __('Date') ?>
                        </td>
                        <td><?= jdate('Y/n/j H:i:s', strtotime($data['transaction']->created_at)) ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>