<?php
if (!defined('BASE_PATH')) {
    echo "<h1>404 Not Found</h1>";
    exit;
}
?>
<?php
if (!defined('BASE_PATH')) {
    echo "<h1>404 Not Found</h1>";
    exit;
}
?>
<?php require(ADMIN_PATH . '/templates/admin-header.php') ?>
<?php require(ADMIN_PATH . '/templates/admin-sidebar.php') ?>
    <div class="col-md-9">
        <div class="card">
            <div class="card-header"><?= $data['page_title'] ?></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table text-center table-hover table-striped">
                        <thead>
                            <tr>
                                <th><?= __('ID') ?></th>
                                <th><?= __('Transaction ID') ?></th>
                                <th><?= __('Amount') ?></th>
                                <th><?= __('Date') ?></th>
                                <th><?= __('Status') ?></th>
                                <th><?= __('Actions') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['transactions']['data'] as $transaction) : ?>
                                <tr>
                                    <td><?= $transaction->id ?></td>
                                    <td><?= $transaction->transaction_id ?></td>
                                    <td><?= custom_money_format($transaction->amount) ?></td>
                                    <td style="direction: ltr">
                                        <span><?= jdate('Y/n/j H:i:s', strtotime($transaction->created_at)) ?></span>
                                    </td>
                                    <td>
                                        <span class="<?= $transaction->status ? 'text-success' : 'text-danger' ?>"><?= $transaction->status ? __('Success') : __('Failed') ?></span>
                                    </td>
                                    <td>
                                        <a href="<?= url('/admin/transactions.php?action=details&id=' . $transaction->id) ?>" class="btn-popup"><?= __('Details') ?></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if ($data['transactions']['total_pages'] > 1): ?>
                    <nav>
                        <ul class="pagination">
                            <?php for ($i = 1; $i <= $data['transactions']['total_pages']; $i++) : ?>
                                <li class="page-item <?= $data['transactions']['current_page'] == $i ? 'active' : '' ?>"><a class="page-link" href="<?= url('/admin/transactions.php?page=' . $i) ?>"><?= $i ?></a></li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php require(ADMIN_PATH . '/templates/admin-footer.php') ?>