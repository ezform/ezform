<?php
if (!defined('BASE_PATH')) {
    echo "<h1>404 Not Found</h1>";
    exit;
}
?>
<?php include('header.php'); ?>
    <div class="center-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="box">
                        <div class="title">
                            <h1><?= $data['page_title'] ?></h1>
                            <br>
                        </div>
                        <div class="content">
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered text-center" style="table-layout: fixed;">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <?= __('ID') ?>
                                                    </td>
                                                    <td><?= $transaction->id ?></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <?= __('Amount') ?>
                                                    </td>
                                                    <td><?= custom_money_format($transaction->amount) ?></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <?= __('Status') ?>
                                                    </td>
                                                    <td><?= $transaction->status ?></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <?= __('Transaction ID') ?>
                                                    </td>
                                                    <td><?= $transaction->transaction_id ?></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <?= __('Card Number') ?>
                                                    </td>
                                                    <td style="direction: ltr">
                                                        <span><?= $transaction->card_number ?></span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <?= __('Date') ?>
                                                    </td>
                                                    <td style="direction: ltr">
                                                        <span><?= jdate('Y/n/j H:i:s', strtotime($transaction->created_at)) ?></span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="footer">
                            <button class="button purple"><?= __('Print') ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include('footer.php'); ?>