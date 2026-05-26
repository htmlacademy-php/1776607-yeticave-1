<?php

declare(strict_types=1);

/**
 * Форматирует числовую цену для отображения в рублях.
 *
 * @param int $price Исходное значение цены.
 *
 * @return string Отформатированная строка цены со знаком рубля.
 */
function formatPrice(int $price): string {
    $price = (int) ceil($price);
    $formatted_price = (string) $price;

    if ($price >= PRICE_FORMAT_THOUSAND_THRESHOLD) {
        $formatted_price = number_format($price, 0, '.', ' ');
    }

    return $formatted_price . ' ₽';
}

/**
 * Экранирует строку для безопасного вывода в HTML.
 *
 * @param mixed $value Исходное значение, которое нужно вывести в HTML.
 *
 * @return string Безопасная экранированная строка.
 */
function esc($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

/**
 * Рассчитывает оставшееся время до указанной даты.
 *
 * @param string $date Дата в формате YYYY-MM-DD.
 *
 * @return array{0:int,1:int,2:int} Оставшиеся часы, минуты и секунды.
 */
function getDateTimeRange(string $date): array
{
    $hoursLeft = 0;
    $minutesLeft = 0;
    $secondsLeftRemainder = 0;

    // если вдруг будет передана некорректная дата
    try {
        $targetDate = new DateTimeImmutable($date);
        $now = new DateTimeImmutable('now');
        $secondsLeft = max(0, $targetDate->getTimestamp() - $now->getTimestamp());

        $hoursLeft = intdiv($secondsLeft, SECONDS_IN_HOUR);
        $minutesLeft = intdiv($secondsLeft % SECONDS_IN_HOUR, SECONDS_IN_MINUTE);
        $secondsLeftRemainder = $secondsLeft % SECONDS_IN_MINUTE;
    } catch (Exception $e) {
    }

    return [$hoursLeft, $minutesLeft, $secondsLeftRemainder];
}

/**
 * Выводит страницу с общим layout.
 *
 * @param string               $title       Заголовок страницы.
 * @param string               $mainContent HTML-контент основной области.
 * @param array<int, array>    $categories  Список категорий для навигации.
 * @param bool                 $isAuth      Авторизован ли пользователь.
 * @param string               $userName        Имя авторизованного пользователя.
 * @param bool                 $isMainContainer Добавлять ли класс container на main.
 */
function render_layout(
    string $title,
    string $mainContent,
    array $categories,
    bool $isAuth,
    string $userName,
    bool $isMainContainer = true
): void {
    print(include_template('layout.php', compact(
        'title',
        'mainContent',
        'categories',
        'isAuth',
        'userName',
        'isMainContainer'
    )));
}

/**
 * Отправляет ответ 404 и выводит страницу «не найдено».
 *
 * @param array<int, array> $categories Список категорий для навигации.
 * @param bool              $isAuth     Авторизован ли пользователь.
 * @param string            $userName   Имя авторизованного пользователя.
 */
function render_not_found(array $categories, bool $isAuth, string $userName): void
{
    http_response_code(404);

    render_layout(
        'Страница не найдена',
        include_template('404.php', compact('categories')),
        $categories,
        $isAuth,
        $userName,
        false
    );
}
