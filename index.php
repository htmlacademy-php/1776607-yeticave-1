<?php

declare(strict_types=1);

require_once __DIR__ . '/init.php';

/**
 * @var array $categories
 * @var array $lots
 */

$con = db_connect();
$categories = get_categories($con);
$lots = get_active_lots($con);

$isAuth = rand(0, 1);

$userName = 'Stepan Kormilin';

$title = 'YetiCave';

$mainContent = include_template('main.php', compact(
    'categories',
    'lots'
));

$layoutContent = include_template('layout.php', compact(
    'title',
    'isAuth',
    'userName',
    'mainContent',
    'categories'
));

print($layoutContent);
