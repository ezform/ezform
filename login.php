<?php require('config.php'); ?>
<?php
if (isset($_SESSION['user_id'])) {
    header('location: ' . url('/admin'));
    exit;
}
?>
    <html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title><?= __('Login') ?></title>
        <link rel="stylesheet" href="<?= url('/includes/css/styles.css') ?>">
    </head>
    <body>
        <div id="app">
            <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
                <div class="container">
                    <a class="navbar-brand" href="<?= url('/') ?>">
                        <?= site_config('site_title') ?>
                    </a>
                    <div class="collapse navbar-collapse">
                        <ul class="navbar-nav mr-auto">
                        </ul>
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="<?= url('/login.php') ?>"><?= __('Login') ?></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <main class="py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header"><?= __('Login') ?></div>

                                <div class="card-body">
                                    <form method="POST" action="<?= url('/?action=login') ?>">
                                        <div class="form-group row">
                                            <label for="email" class="col-md-4 col-form-label text-md-right"><?= __('E-Mail Address') ?></label>
                                            <div class="col-md-6">
                                                <input id="email" type="email" name="email" class="form-control" required autofocus>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="password" class="col-md-4 col-form-label text-md-right"><?= __('Password') ?></label>

                                            <div class="col-md-6">
                                                <input id="password" type="password" class="form-control" name="password" required>
                                            </div>
                                        </div>

                                        <?php if (isset($_SESSION['alerts'])) { ?>
                                            <div class="row">
                                                <div class="col-8 offset-2">
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

                                        <div class="form-group row mb-0">
                                            <div class="col-md-8 offset-md-4">
                                                <button type="submit" class="btn btn-primary">
                                                    <?= __('Login') ?>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <script src="<?= url('/includes/libs/jquery/jquery-3.3.1.min.js') ?>"></script>
        <script src="<?= url('/includes/libs/bootstrap/js/bootstrap.min.js') ?>"></script>
        <script src="<?= url('/includes/js/scripts.js') ?>"></script>
    </body>
    </html>

<?php $_SESSION['alerts'] = null; ?>