<?php

declare(strict_types=1);

/**
 * Создает подключение к MySQL для приложения.
 *
 * @return mysqli
 */
function db_connect(): mysqli
{
    $dbHost = getenv('MYSQL_HOST') ?: 'mysql';
    $dbUser = getenv('MYSQL_USER') ?: 'teacat';
    $dbPassword = getenv('MYSQL_PASSWORD') ?: '1612';
    $dbName = getenv('MYSQL_DATABASE') ?: 'yeticave';

    $connection = mysqli_connect($dbHost, $dbUser, $dbPassword, $dbName);

    if ($connection === false) {
        die('Ошибка подключения: ' . mysqli_connect_error());
    }

    mysqli_set_charset($connection, 'utf8');

    return $connection;
}

/**
 * Возвращает все категории для главной навигации.
 *
 * @param mysqli $connection Подключение к базе данных.
 *
 * @return array<int, array{name:string, slug:string}>
 */
function get_categories(mysqli $connection): array
{
    $sqlCategories = 'SELECT name, slug FROM categories ORDER BY id';
    $resultCategories = mysqli_query($connection, $sqlCategories);

    if ($resultCategories === false) {
        die('Ошибка запроса категорий: ' . mysqli_error($connection));
    }

    return mysqli_fetch_all($resultCategories, MYSQLI_ASSOC);
}

/**
 * Возвращает активные лоты для главной страницы.
 *
 * @param mysqli $connection Подключение к базе данных.
 *
 * @return array<int, array{name:string, category:string, price:string, image:string, expires_at:string}>
 */
function get_active_lots(mysqli $connection): array
{
    $sqlLots = <<<SQL
    SELECT
        l.id,
        l.name,
        c.name AS category,
        l.initial_price AS price,
        l.image_url AS image,
        l.expires_at
    FROM lots AS l
    JOIN categories AS c ON c.id = l.category_id
    WHERE l.expires_at > NOW()
    ORDER BY l.created_at DESC
    LIMIT 9
    SQL;

    $resultLots = mysqli_query($connection, $sqlLots);

    if ($resultLots === false) {
        die('Ошибка запроса лотов: ' . mysqli_error($connection));
    }

    return mysqli_fetch_all($resultLots, MYSQLI_ASSOC);
}

/**
 * Возвращает лот по идентификатору вместе с названием категории и текущей ценой.
 *
 * @param mysqli $connection Подключение к базе данных.
 * @param int    $lotId      Идентификатор лота.
 *
 * @return array<string, mixed>|null Данные лота или null, если запись не найдена.
 */
function get_lot_by_id(mysqli $connection, int $lotId): ?array
{
    $sqlLot = <<<SQL
    SELECT
        l.*,
        c.name AS category_name,
        COALESCE(MAX(b.price), l.initial_price) AS current_price
    FROM lots AS l
    JOIN categories AS c ON c.id = l.category_id
    LEFT JOIN bets AS b ON b.lot_id = l.id
    WHERE l.id = ?
    GROUP BY l.id
    SQL;

    $stmt = db_get_prepare_stmt($connection, $sqlLot, [$lotId]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $lot = mysqli_fetch_assoc($result);

    if ($lot === false || $lot === null) {
        return null;
    }

    return $lot;
}
