<?php
if (!defined('BASE_PATH')) {
    echo "<h1>404 Not Found</h1>";
    exit;
}
?>
<?php include(ADMIN_PATH . '/templates/admin-header.php') ?>
<?php include(ADMIN_PATH . '/templates/admin-sidebar.php') ?>
    <div class="col-md-9">
        <?php include(__DIR__ . './alerts.php') ?>
        <div class="card">
            <div class="card-header"><?= $data['payir']->display_name ?></div>
            <div class="card-body">
                <form action="<?= url('/admin/payment-providers.php?action=payir') ?>" method="post">
                    <div class="form-group">
                        <label for="txt-payir-api-key">API Key</label>
                        <input type="text" class="form-control ltr" id="txt-payir-api-key" name="api_key" value="<?= json_decode($data['payir']->configs, true)['api_key'] ?>">
                    </div>
                    <button type="submit" class="btn btn-primary"><?= __('Save') ?></button>
                </form>
            </div>
        </div>
    </div>
<?php include(ADMIN_PATH . '/templates/admin-footer.php') ?>