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
            <div class="card-header"><?= __('Edit') ?></div>
            <div class="card-body">
                <form action="<?= url('/admin/form-inputs.php?action=edit&id=' . $data['form_input']->id) ?>" method="post">
                    <div class="form-group">
                        <label for="txt-title"><?= __('Title') ?></label>
                        <input type="text" class="form-control" id="txt-title" name="title" value="<?= $data['form_input']->title ?>">
                    </div>
                    <div class="form-group">
                        <input type="checkbox" id="input-required" name="required" <?= $data['form_input']->required ? 'checked' : '' ?>>
                        <label for="input-required"><?= __('Is Required') ?></label>
                    </div>
                    <button type="submit" class="btn btn-success"><?= __('Edit') ?></button>
                </form>
            </div>
        </div>
    </div>
<?php include(ADMIN_PATH . '/templates/admin-footer.php') ?>