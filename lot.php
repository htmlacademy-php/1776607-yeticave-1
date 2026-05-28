<?php

declare(strict_types=1);

require_once __DIR__ . '/init.php';

/**
 * @var mysqli $con
 * @var array  $categories
 * @var bool   $isAuth
 * @var string $userName
 */

$lotId = filter_input(INPUT_GET, 'lot_id', FILTER_VALIDATE_INT);
$lot = ($lotId !== null && $lotId !== false) ? getLotById($con, $lotId) : null;
$isNotFound = $lot === null;

if ($isNotFound) {
    http_response_code(HttpCode::NotFound->value);
}

echo includeTemplate('layout/layout.php', [
    'title' => $isNotFound ? 'Страница не найдена' : (string) ($lot['name'] ?? 'YetiCave'),
    'mainContent' => includeTemplate(
        $isNotFound ? '404.php' : 'lot.php',
        $isNotFound ? compact('categories') : compact('lot', 'categories')
    ),
    'categories' => $categories,
    'isAuth' => $isAuth,
    'userName' => $userName,
    'isMainContainer' => false,
]);
