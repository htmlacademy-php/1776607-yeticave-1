<?php

declare(strict_types=1);

/**
 * Подготавливает общие данные для страниц приложения.
 *
 * @return array{
 *     con: mysqli,
 *     categories: array<int, array{name: string, slug: string}>,
 *     isAuth: bool,
 *     userName: string
 * }
 */
function bootstrap(): array
{
    $con = db_connect();
    $categories = get_categories($con);

    return [
        'con' => $con,
        'categories' => $categories,
        'isAuth' => (bool) rand(0, 1),
        'userName' => 'Stepan Kormilin',
    ];
}
