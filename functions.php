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
