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
                <?php foreach ($data['configs'] as $config): ?>
                    <form action="<?= url('/admin/site-settings.php?action=edit&id=' . $config->id) ?>" method="post">
                        <div class="row">
                            <div class="col-9">
                                <div class="form-group">
                                    <label for="input-<?= $config->key ?>"><?= $config->title ?></label>
                                    <input type="hidden" name="key" value="<?= $config->key ?>">
                                    <input type="text" class="form-control" id="input-<?= $config->key ?>" name="value" value="<?= $config->value ?>">
                                </div>
                            </div>
                            <div class="col-3">
                                <button type="submit" class="btn btn-primary btn-block" style="margin-top: 31px;"><?= __('Save') ?></button>
                            </div>
                        </div>
                    </form>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php require(ADMIN_PATH . '/templates/admin-footer.php') ?>