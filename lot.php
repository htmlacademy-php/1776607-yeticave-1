<?php

declare(strict_types=1);

require_once __DIR__ . '/init.php';

/**
 * @var mysqli $con
 * @var array  $categories
 * @var bool   $isAuth
 * @var string $userName
 */

extract(bootstrap());

$lotId = filter_input(INPUT_GET, 'lot_id', FILTER_VALIDATE_INT);

if ($lotId === null || $lotId === false) {
    http_response_code(404);

    echo include_template('layout/layout.php', [
        'title' => 'Страница не найдена',
        'mainContent' => include_template('404.php', compact('categories')),
        'categories' => $categories,
        'isAuth' => $isAuth,
        'userName' => $userName,
        'isMainContainer' => false,
    ]);

    return;
}

$lot = get_lot_by_id($con, $lotId);

if ($lot === null) {
    http_response_code(404);

    echo include_template('layout/layout.php', [
        'title' => 'Страница не найдена',
        'mainContent' => include_template('404.php', compact('categories')),
        'categories' => $categories,
        'isAuth' => $isAuth,
        'userName' => $userName,
        'isMainContainer' => false,
    ]);

    return;
}

echo include_template('layout/layout.php', [
    'title' => (string) ($lot['name'] ?? 'YetiCave'),
    'mainContent' => include_template('lot.php', compact('lot', 'categories')),
    'categories' => $categories,
    'isAuth' => $isAuth,
    'userName' => $userName,
    'isMainContainer' => false,
]);
