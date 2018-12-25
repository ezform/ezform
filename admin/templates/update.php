<?php
if (!defined('BASE_PATH')) {
    echo "<h1>404 Not Found</h1>";
    exit;
}
?>
<?php require(ADMIN_PATH . '/templates/admin-header.php') ?>
<?php require(ADMIN_PATH . '/templates/admin-sidebar.php') ?>
    <div class="col-md-9">
        <?php require(__DIR__ . './alerts.php') ?>
        <div class="card">
            <div class="card-header"><?= $data['page_title'] ?></div>
            <div class="card-body">
                <p><?= __('Current Version') ?> : <b><?= APP_VERSION ?></b></p>
                <?php if (isset($data['release'])): ?>
                    <p><?= __('There is new release') ?> : <b><?= $data['release']->tag_name ?></b></p>
                    <a href="<?= url('/admin/update.php?action=install&release=' . $data['release']->tag_name) ?>" class="btn btn-success" id="btn-update" data-loading-text="<?= __('Updating...') ?>"><?= __('Install Update') ?></a>
                    <script>
                        $('#btn-update').on('click', function () {
                            $(this).text($(this).data('loading-text'));
                        });
                    </script>
                <?php else: ?>
                    <p><?= __('You are using latest version') ?></p>
                <?php endif; ?>
                <a href="" class="btn btn-primary"><?= __('Check') ?></a>
            </div>
        </div>
    </div>
<?php require(ADMIN_PATH . '/templates/admin-footer.php') ?>