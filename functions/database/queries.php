<?php

declare(strict_types=1);

/**
 * Возвращает все категории для главной навигации.
 *
 * @param mysqli $connection Подключение к базе данных.
 *
 * @return array<int, array{id:int, name:string, slug:string}>
 */
function getCategories(mysqli $connection): array
{
    $sqlCategories = 'SELECT id, name, slug FROM categories ORDER BY id';
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
 * @return array<int, array{id:int, name:string, category:string, price:string, image:string, expires_at:string}>
 */
function getActiveLots(mysqli $connection): array
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
function getLotById(mysqli $connection, int $lotId): ?array
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

    $stmt = dbGetPrepareStmt($connection, $sqlLot, [$lotId]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $lot = mysqli_fetch_assoc($result);

    if ($lot === false || $lot === null) {
        return null;
    }

    return $lot;
}

/**
 * Добавляет новый лот в БД.
 *
 * @param mysqli              $connection   Подключение к БД.
 * @param array<string,mixed> $lotData      Данные лота для вставки.
 *
 * @return int Идентификатор созданного лота.
 */
function createLot(mysqli $connection, array $lotData): int
{
    $sqlInsertLot = <<<SQL
    INSERT INTO lots (
        name,
        description,
        image_url,
        initial_price,
        expires_at,
        bet_step,
        author_id,
        category_id
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    SQL;

    $stmt = dbGetPrepareStmt($connection, $sqlInsertLot, [
        $lotData['name'],
        $lotData['description'],
        $lotData['image_url'],
        $lotData['initial_price'],
        $lotData['expires_at'],
        $lotData['bet_step'],
        $lotData['author_id'],
        $lotData['category_id'],
    ]);

    if (!mysqli_stmt_execute($stmt)) {
        die('Ошибка добавления лота: ' . mysqli_error($connection));
    }

    return (int) mysqli_insert_id($connection);
}
