<?php

declare(strict_types=1);

require_once 'constants.php';

/**
 * Formats a numeric price for display in rubles.
 *
 * @param int $price Source price value.
 *
 * @return string Formatted price string with the ruble sign.
 */
function format_price(int $price): string {
    $price = (int) ceil($price);
    $formatted_price = (string) $price;

    if ($price >= PRICE_FORMAT_THOUSAND_THRESHOLD) {
        $formatted_price = number_format($price, 0, '.', ' ');
    }

    return $formatted_price . ' ₽';
}

/**
 * Escapes a string for safe HTML output.
 *
 * @param mixed $value Source value that should be rendered in HTML.
 *
 * @return string Safe escaped string.
 */
function esc($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

/**
 * Calculates remaining time until the specified date.
 *
 * @param string $date Date in YYYY-MM-DD format.
 *
 * @return array{0:int,1:int,2:int} Remaining hours, minutes and seconds.
 */
function getDateTimeRange(string $date): array
{
    try {
        $targetDate = new DateTimeImmutable($date);
    } catch (Exception $e) {
        return [0, 0, 0];
    }

    $now = new DateTimeImmutable('now');
    $secondsLeft = max(0, $targetDate->getTimestamp() - $now->getTimestamp());

    $hoursLeft = intdiv($secondsLeft, 3600);
    $minutesLeft = intdiv($secondsLeft % 3600, 60);
    $secondsLeftRemainder = $secondsLeft % 60;

    return [$hoursLeft, $minutesLeft, $secondsLeftRemainder];
}


