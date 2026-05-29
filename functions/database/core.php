<?php

declare(strict_types=1);

/**
 * Создает подключение к MySQL для приложения.
 *
 * @return mysqli
 */
function dbConnect(): mysqli
{
    $config = require __DIR__ . '/../../config/db.php';

    $connection = mysqli_connect(
        $config['host'],
        $config['user'],
        $config['password'],
        $config['database']
    );

    if ($connection === false) {
        die('Ошибка подключения: ' . mysqli_connect_error());
    }

    mysqli_set_charset($connection, $config['charset']);

    return $connection;
}
