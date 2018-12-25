<?php
if (!defined('BASE_PATH')) {
    echo "<h1>404 Not Found</h1>";
    exit;
}
?>
</div>
</div>
</main>
<script src="<?= url('/includes/libs/jquery/jquery-3.3.1.min.js') ?>"></script>
<script src="<?= url('/includes/libs/bootstrap/js/bootstrap.min.js') ?>"></script>
<script src="<?= url('/includes/js/scripts.js') ?>"></script>
<script>
    $('.btn-popup').click(function (e) {
        e.preventDefault();
        popup($(this).attr('href'), '', 900, 800);
    });
</script>
</body>
</html>
