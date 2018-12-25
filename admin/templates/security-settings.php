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
            <div class="card-header"><?= $data['page_title'] ?></div>
            <div class="card-body">
                <form action="<?= url('/admin/security-settings.php?action=change_password') ?>" method="post">
                    <div class="form-group">
                        <label for="txt-current-password"><?= __('Current Password') ?></label>
                        <input type="password" class="form-control ltr" id="txt-current-password" name="current_password">
                    </div>
                    <div class="form-group">
                        <label for="txt-password"><?= __('New Password') ?></label>
                        <input type="password" class="form-control ltr" id="txt-password" name="password">
                    </div>
                    <div class="form-group">
                        <label for="txt-confirm-password"><?= __('Confirm Password') ?></label>
                        <input type="password" class="form-control ltr" id="txt-confirm-password" name="password_confirmation">
                    </div>
                    <button type="submit" class="btn btn-primary"><?= __('Save') ?></button>
                </form>
            </div>
        </div>
    </div>
<?php include(ADMIN_PATH . '/templates/admin-footer.php') ?>