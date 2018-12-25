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
            <div class="card-header"><?= __('Add Field') ?></div>
            <div class="card-body">
                <form action="<?= url('/admin/form-inputs.php?action=add') ?>" method="post">
                    <div class="form-group">
                        <label for="txt-title"><?= __('Title') ?></label>
                        <input type="text" class="form-control" id="txt-title" name="title">
                    </div>
                    <div class="form-group">
                        <input type="checkbox" id="input-required" name="required">
                        <label for="input-required"><?= __('Is Required') ?></label>
                    </div>
                    <button type="submit" class="btn btn-success"><?= __('Add') ?></button>
                </form>
            </div>
        </div>
        <br>
        <div class="card">
            <div class="card-header"><?= $data['page_title'] ?></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table text-center table-hover table-striped">
                        <thead>
                            <tr>
                                <th><?= __('Title') ?></th>
                                <th><?= __('Is Required') ?></th>
                                <th><?= __('Actions') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($data['form_inputs'] as $input) : ?>
                            <tr>
                                <td><?= $input->title ?></td>
                                <td><?= $input->required ? __('Required') : __('Optional') ?></td>
                                <td>
                                    <a href="<?= url('/admin/form-inputs.php?action=show_edit&id=' . $input->id) ?>"><?= __('Edit') ?></a> -
                                    <a href="<?= url('/admin/form-inputs.php?action=delete&id=' . $input->id) ?>"><?= __('Delete') ?></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php require(ADMIN_PATH . '/templates/admin-footer.php') ?>