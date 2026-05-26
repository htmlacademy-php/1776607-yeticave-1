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
    render_not_found($categories, $isAuth, $userName);
    return;
}

$lot = get_lot_by_id($con, $lotId);

if ($lot === null) {
    render_not_found($categories, $isAuth, $userName);
    return;
}

render_layout(
    (string) ($lot['name'] ?? 'YetiCave'),
    include_template('lot.php', compact('lot', 'categories')),
    $categories,
    $isAuth,
    $userName,
    false
);
