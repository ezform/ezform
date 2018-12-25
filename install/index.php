<!DOCTYPE html>
<html>

<head>
    <title>EZForm Installer</title>
    <link rel="stylesheet" type="text/css" href="../includes/css/styles.css">
</head>

<body>
    <div id="wrapper" class="container">
        <div class="row">
            <div class="col">
                <h1>نصب EZForm</h1>
            </div>
        </div>
        <hr>
        <br>
        <form method="post">
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="site_url">آدرس سایت</label>
                        <input type="text" id="site_url" name="site_url" class="form-control ltr" value="<?= isset($_POST['site_url']) ? $_POST['site_url'] : 'http://localhost' ?>" required/>
                    </div>
                    <div class="form-group">
                        <label for="site_title">عنوان سایت</label>
                        <input type="text" id="site_title" name="site_title" class="form-control" value="<?= isset($_POST['site_title']) ? $_POST['site_title'] : 'فرم پرداخت' ?>" required/>
                    </div>
                    <div class="form-group">
                        <label for="site_description">توضیحات سایت</label>
                        <input type="text" id="site_description" name="site_description" class="form-control" value="<?= isset($_POST['site_description']) ? $_POST['site_description'] : 'توضیحات فرم پرداخت' ?>" required/>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="db_host">آدرس دیتابیس</label>
                        <input type="text" id="db_host" name="db_host" class="form-control ltr" value="<?= isset($_POST['db_host']) ? $_POST['db_host'] : 'localhost' ?>" required/>
                    </div>
                    <div class="form-group">
                        <label for="db_name">نام دیتابیس</label>
                        <input type="text" id="db_name" name="db_name" class="form-control ltr" value="<?= isset($_POST['db_name']) ? $_POST['db_name'] : 'ezform' ?>" required/>
                    </div>
                    <div class="form-group">
                        <label for="db_username">نام کاربری دیتابیس</label>
                        <input type="text" id="db_username" name="db_username" class="form-control ltr" value="<?= isset($_POST['db_username']) ? $_POST['db_username'] : '' ?>"/>
                    </div>
                    <div class="form-group">
                        <label for="db_password">کلمه عبور دیتابیس</label>
                        <input type="text" id="db_password" name="db_password" class="form-control ltr" value="<?= isset($_POST['db_password']) ? $_POST['db_password'] : '' ?>"/>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="admin_email">ایمیل مدیر</label>
                        <input type="text" id="admin_email" name="admin_email" class="form-control ltr" value="<?= isset($_POST['admin_email']) ? $_POST['admin_email'] : '' ?>"/>
                    </div>
                    <div class="form-group">
                        <label for="admin_password">کلمه عبور مدیر</label>
                        <input type="text" id="admin_password" name="admin_password" class="form-control ltr" value="<?= isset($_POST['admin_password']) ? $_POST['admin_password'] : '' ?>"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <?php
                    if (isset($_POST['submit'])) {
                        $conn = new mysqli($_POST['db_host'], $_POST['db_username'], $_POST['db_password']);
                        if ($conn->connect_error) {
                            echo "<div class='alert alert-danger ltr'><b>" . $conn->connect_error . "</b></div>";
                        } else {
                            $dbName = $_POST['db_name'];
                            $query = "CREATE DATABASE IF NOT EXISTS $dbName character set UTF8mb4 collate utf8mb4_bin;";
                            if ($conn->query($query)) {
                                $conn->close();
                                $conn = new mysqli($_POST['db_host'], $_POST['db_username'], $_POST['db_password'], $_POST['db_name']);

                                $sql = "CREATE TABLE `configs` (
                                    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                    `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                    `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                    `value` longtext COLLATE utf8mb4_unicode_ci,
                                    PRIMARY KEY (`id`),
                                    UNIQUE KEY `configs_key_unique` (`key`)
                                  ) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

                                $sql .= "INSERT INTO `configs` VALUES
                                    (1,'site_url',N'آدرس سایت',N'" . $_POST['site_url'] . "'),
                                    (2,'site_title',N'عنوان سایت',N'" . $_POST['site_title'] . "'),
                                    (3,'site_theme',N'پوسته سایت','default'),
                                    (4,'site_description',N'توضیحات سایت',N'" . $_POST['site_description'] . "'),
                                    (5,'time_zone',N'منطقه زمانی','Asia/Tehran'),
                                    (6,'locale',N'زبان','fa'),
                                    (7,'payment_amount',N'مبلغ فرم به ریال (برای مبلغ دلخواه این فیلد را 0 یا خالی بگذارید)','1000');";

                                $sql .= "CREATE TABLE `form_inputs` (
                                    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                    `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
                                    `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                    `required` tinyint(1) NOT NULL DEFAULT '0',
                                    `options` longtext COLLATE utf8mb4_unicode_ci,
                                    `created_at` timestamp NULL DEFAULT NULL,
                                    `updated_at` timestamp NULL DEFAULT NULL,
                                    PRIMARY KEY (`id`)
                                  ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
                                  ";

                                $sql .= "INSERT INTO `form_inputs` VALUES (1,'text',N'نام',1,NULL,'2018-12-22 01:36:41','2018-12-22 01:36:41'),(2,'text',N'توضیحات',0,NULL,'2018-12-22 01:36:41','2018-12-22 01:36:41');";

                                $sql .= "CREATE TABLE `password_resets` (
                                    `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                    `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                    `created_at` timestamp NULL DEFAULT NULL,
                                    KEY `password_resets_email_index` (`email`)
                                  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

                                $sql .= "CREATE TABLE `payment_providers` (
                                    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                    `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                    `display_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                    `configs` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
                                    PRIMARY KEY (`id`),
                                    UNIQUE KEY `payment_providers_name_unique` (`name`)
                                  ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

                                $sql .= "INSERT INTO `payment_providers` VALUES (1,'payir',N'شبکه پرداخت پِی','{\"api_key\":\"test\"}');";

                                $sql .= "CREATE TABLE `transactions` (
                                    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                    `transaction_id` bigint(20) unsigned DEFAULT NULL,
                                    `amount` bigint(20) unsigned NOT NULL,
                                    `token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                    `card_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                    `mobile` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                    `description` longtext COLLATE utf8mb4_unicode_ci,
                                    `status` tinyint(1) NOT NULL DEFAULT '0',
                                    `paid_at` datetime DEFAULT NULL,
                                    `created_at` timestamp NULL DEFAULT NULL,
                                    `updated_at` timestamp NULL DEFAULT NULL,
                                    PRIMARY KEY (`id`),
                                    UNIQUE KEY `transactions_token_unique` (`token`),
                                    UNIQUE KEY `transactions_transaction_id_unique` (`transaction_id`)
                                  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

                                $sql .= "CREATE TABLE `users` (
                                    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                    `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                    `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                    `email_verified_at` timestamp NULL DEFAULT NULL,
                                    `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                    `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                    `created_at` timestamp NULL DEFAULT NULL,
                                    `updated_at` timestamp NULL DEFAULT NULL,
                                    PRIMARY KEY (`id`),
                                    UNIQUE KEY `users_email_unique` (`email`)
                                  ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

                                $sql .= "INSERT INTO `users` VALUES (1,N'مدیر سیستم','" . $_POST['admin_email'] . "','2018-12-22 01:36:41','" . password_hash($_POST['admin_password'], PASSWORD_DEFAULT) . "','Jlli1CzXMk','2018-12-22 01:36:41','2018-12-22 01:36:41');";

                                if (mysqli_multi_query($conn, $sql)) {
                                    $conn->close();
                                    $config = file_get_contents('../config-sample.php');
                                    $config = str_replace('{SITE_URL}', $_POST['site_url'], $config);
                                    $config = str_replace('{DB_HOST}', $_POST['db_host'], $config);
                                    $config = str_replace('{DB_NAME}', $_POST['db_name'], $config);
                                    $config = str_replace('{DB_USERNAME}', $_POST['db_username'], $config);
                                    $config = str_replace('{DB_PASSWORD}', $_POST['db_password'], $config);

                                    file_put_contents('../config.php', $config);

                                    header('location: ' . $_POST['site_url'] . '/?action=installation_completed');
                                } else {
                                    echo $conn->error;
                                }
                            }
                        }
                    }
                    ?>
                </div>
            </div>
            <br>
            <button type="submit" class="btn btn-success" name="submit">نصب</button>
        </form>
    </div>
</body>

</html>