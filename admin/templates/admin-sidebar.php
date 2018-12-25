<?php
if (!defined('BASE_PATH')) {
    echo "<h1>404 Not Found</h1>";
    exit;
}
?>
<main class="py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-3">
                <div class="list-group">
                    <a href="<?= url('/admin/transactions.php') ?>" class="list-group-item list-group-item-action <?= $data['active_menu'] == 'transactions' ? 'active' : '' ?>"><?= __('Transactions') ?></a>
                    <a href="<?= url('/admin/form-inputs.php') ?>" class="list-group-item list-group-item-action <?= $data['active_menu'] == 'form-inputs' ? 'active' : '' ?>"><?= __('Form Inputs') ?></a>
                    <a href="<?= url('/admin/payment-providers.php') ?>" class="list-group-item list-group-item-action <?= $data['active_menu'] == 'payment-providers' ? 'active' : '' ?>"><?= __('Payment Providers') ?></a>
                    <a href="<?= url('/admin/site-settings.php') ?>" class="list-group-item list-group-item-action <?= $data['active_menu'] == 'site-settings' ? 'active' : '' ?>"><?= __('Site Settings') ?></a>
                    <a href="<?= url('/admin/security-settings.php') ?>" class="list-group-item list-group-item-action <?= $data['active_menu'] == 'security-settings' ? 'active' : '' ?>"><?= __('Security Settings') ?></a>
                    <a href="<?= url('/admin/update.php') ?>" class="list-group-item list-group-item-action <?= $data['active_menu'] == 'update' ? 'active' : '' ?>"><?= __('Update') ?></a>
                </div>
                <br>
                <div class="text-center">
                    <a href="https://ezform.ir" target="_blank">Powered By EZForm</a>
                </div>
            </div>
