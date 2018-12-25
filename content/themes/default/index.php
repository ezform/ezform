<?php
if (!defined('BASE_PATH')) {
    echo "<h1>404 Not Found</h1>";
    exit;
}
?>
<?php require('header.php'); ?>
    <div class="center-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="box">
                        <form method="post" action="/?action=pay">
                            <div class="title">
                                <h1><?= site_config('site_title') ?></h1>
                                <p><?= site_config('site_description') ?></p>
                            </div>
                            <div class="content">
                                <?php foreach ($data['form_inputs'] as $input) { ?>
                                    <div class="row">
                                        <div class="col-8 offset-2">
                                            <div class="form-group">
                                                <label for="input-<?= $input->id ?>" class="label"><?= $input->title ?></label>
                                                <?php
                                                switch ($input->type) {
                                                    case 'text':
                                                        ?>
                                                        <input type="text" id="input-<?= $input->id ?>" class="form-control" name="input_<?= $input->id ?>" <?= $input->required ? 'required' : '' ?>/>
                                                        <?php
                                                        break;
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if (site_config('payment_amount')) { ?>
                                    <div class="row">
                                        <div class="col-8 offset-2">
                                            <div class="form-group">
                                                <label for="input-amount" class="label"><?= __('Amount') ?></label>
                                                <input type="text" id="input-amount" class="form-control ltr" name="amount" disabled value="<?= custom_money_format(site_config('payment_amount')) ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="row">
                                        <div class="col-8 offset-2">
                                            <div class="form-group">
                                                <label for="input-amount" class="label"><?= __('Amount') ?></label>
                                                <input type="text" id="input-amount" class="form-control ltr" name="amount" required/>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php require(__DIR__ . './alerts.php') ?>
                            </div>
                            <div class="footer">
                                <button class="button purple"><?= __('Pay') ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php require('footer.php'); ?>