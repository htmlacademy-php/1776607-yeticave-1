<?php

declare(strict_types=1);

require_once 'helpers.php';
require_once 'functions.php';
require_once 'data.php';

/**
 * @var array $categories
 * @var array $lots
 */

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
