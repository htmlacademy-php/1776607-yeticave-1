<?php

declare(strict_types=1);

return [
    'host' => getenv('MYSQL_HOST') ?: 'mysql',
    'user' => getenv('MYSQL_USER') ?: 'teacat',
    'password' => getenv('MYSQL_PASSWORD') ?: '1612',
    'database' => getenv('MYSQL_DATABASE') ?: 'yeticave',
    'charset' => 'utf8',
];
