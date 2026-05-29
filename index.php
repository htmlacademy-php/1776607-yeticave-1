<?php

declare(strict_types=1);

require_once __DIR__ . '/init.php';

/**
 * @var mysqli $con
 * @var array  $categories
 * @var bool   $isAuth
 * @var string $userName
 */

$lots = getActiveLots($con);

echo includeTemplate('layout/layout.php', [
    'title' => 'YetiCave',
    'mainContent' => includeTemplate('main.php', compact('categories', 'lots')),
    'categories' => $categories,
    'isAuth' => $isAuth,
    'userName' => $userName,
    'isMainContainer' => true,
]);
