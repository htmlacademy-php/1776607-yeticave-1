<?php

declare(strict_types=1);

require_once __DIR__ . '/init.php';

/**
 * @var mysqli $con
 * @var array  $categories
 * @var bool   $isAuth
 * @var string $userName
 */

$lots = get_active_lots($con);

echo include_template('layout/_layout.php', [
    'title' => 'YetiCave',
    'mainContent' => include_template('main.php', compact('categories', 'lots')),
    'categories' => $categories,
    'isAuth' => $isAuth,
    'userName' => $userName,
    'isMainContainer' => true,
]);
