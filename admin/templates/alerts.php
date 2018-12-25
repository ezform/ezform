<?php
if (!defined('BASE_PATH')) {
    echo "<h1>404 Not Found</h1>";
    exit;
}
?>
<?php if (isset($_SESSION['alerts'])) { ?>
    <div class="row">
        <div class="col">
            <div class="form-group">
                <?php foreach ($_SESSION['alerts'] as $alert) { ?>
                    <div class="alert alert-<?= $alert['type'] ?>">
                        <?= $alert['message'] . "</br>" ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>