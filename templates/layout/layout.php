<?php

/**
 * @var string $title
 * @var bool   $isAuth
 * @var string $userName
 * @var string $mainContent
 * @var array  $categories
 * @var bool   $isMainContainer
 * @var bool   $useFlatpickr
 */
$isMainContainer = $isMainContainer ?? true;
$useFlatpickr = $useFlatpickr ?? false;
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= esc($title); ?></title>
    <link href="assets/css/normalize.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <?php if ($useFlatpickr): ?>
    <link href="assets/css/flatpickr.min.css" rel="stylesheet">
    <?php endif; ?>
</head>
<body>
    <div class="page-wrapper">

        <?= includeTemplate('layout/_header.php', compact('isAuth', 'userName')) ?>

        <main<?= $isMainContainer ? ' class="container"' : '' ?>>
            <?= $mainContent; ?>
        </main>
    </div>

    <?= includeTemplate('layout/_footer.php', compact('categories')) ?>

<script src="assets/js/flatpickr.js"></script>
<script src="assets/js/script.js"></script>
</body>
</html>
