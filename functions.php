<?php

declare(strict_types=1);

require_once 'constants.php';

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
