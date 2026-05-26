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

$lots = get_active_lots($con);

render_layout(
    'YetiCave',
    include_template('main.php', compact('categories', 'lots')),
    $categories,
    $isAuth,
    $userName
);
