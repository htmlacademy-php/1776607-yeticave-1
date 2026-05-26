<?php

/**
 * @var string $title
 * @var bool   $isAuth
 * @var string $userName
 * @var string $mainContent
 * @var array  $categories
 * @var bool   $isMainContainer
 */
$isMainContainer = $isMainContainer ?? true;
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= esc($title); ?></title>
    <link href="assets/css/normalize.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="page-wrapper">

        <?= include_template('layout/header.php', compact('isAuth', 'userName')) ?>

        <main<?= $isMainContainer ? ' class="container"' : '' ?>>
            <?= $mainContent; ?>
        </main>
    </div>

    <?= include_template('layout/footer.php', compact('categories')) ?>

<script src="assets/js/flatpickr.js"></script>
<script src="assets/js/script.js"></script>
</body>
</html>
