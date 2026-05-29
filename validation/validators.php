<?php

declare(strict_types=1);

/**
 * Проверяет, что поле заполнено.
 *
 * @param string $name Имя поля в $_POST
 *
 * @return bool true, если поле не пустое
 */
function isFilled(string $name): bool
{
    return isset($_POST[$name]) && trim((string) $_POST[$name]) !== '';
}

/**
 * Проверяет переданную дату на соответствие формату 'ГГГГ-ММ-ДД'
 *
 * Примеры использования:
 * isDateValid('2019-01-01'); // true
 * isDateValid('2016-02-29'); // true
 * isDateValid('2019-04-31'); // false
 * isDateValid('10.10.2010'); // false
 * isDateValid('10/10/2010'); // false
 *
 * @param string $date Дата в виде строки
 *
 * @return bool true при совпадении с форматом 'ГГГГ-ММ-ДД', иначе false
 */
function isDateValid(string $date): bool
{
    $formatToCheck = 'Y-m-d';
    $dateTimeObj = date_create_from_format($formatToCheck, $date);

    if ($dateTimeObj === false) {
        return false;
    }

    $lastErrors = date_get_last_errors();

    if ($lastErrors === false) {
        return true;
    }

    return array_sum($lastErrors) === 0;
}

/**
 * Проверяет загруженное изображение лота.
 *
 * @param string $name Имя поля в $_FILES
 *
 * @return bool true, если файл загружен и имеет допустимый формат
 */
function isUploadedImageValid(string $name): bool
{
    if (!isset($_FILES[$name])) {
        return false;
    }

    $file = $_FILES[$name];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }

    $temporaryPath = $file['tmp_name'];

    if (!is_uploaded_file($temporaryPath)) {
        return false;
    }

    $mimeType = mime_content_type($temporaryPath);
    $allowedMimeTypes = ['image/png', 'image/jpeg'];

    return in_array($mimeType, $allowedMimeTypes, true);
}

/**
 * Проверяет, что значение поля — число больше нуля.
 *
 * @param string $name Имя поля в $_POST
 *
 * @return bool true, если значение корректно
 */
function isPositiveNumber(string $name): bool
{
    if (!isset($_POST[$name]) || trim((string) $_POST[$name]) === '') {
        return true;
    }

    $value = str_replace(',', '.', trim((string) $_POST[$name]));

    return is_numeric($value) && (float) $value > 0;
}

/**
 * Проверяет, что значение поля — целое число больше нуля.
 *
 * @param string $name Имя поля в $_POST
 *
 * @return bool true, если значение корректно
 */
function isPositiveInteger(string $name): bool
{
    if (!isset($_POST[$name]) || trim((string) $_POST[$name]) === '') {
        return true;
    }

    $value = filter_var(trim((string) $_POST[$name]), FILTER_VALIDATE_INT);

    return $value !== false && $value > 0;
}

/**
 * Проверяет формат даты окончания торгов.
 *
 * @param string $name Имя поля в $_POST
 *
 * @return bool true, если дата указана в формате «ГГГГ-ММ-ДД»
 */
function isLotDateFormatValid(string $name): bool
{
    if (!isset($_POST[$name]) || trim((string) $_POST[$name]) === '') {
        return true;
    }

    return isDateValid(trim((string) $_POST[$name]));
}

/**
 * Проверяет, что дата окончания торгов не раньше чем через сутки.
 *
 * @param string $name Имя поля в $_POST
 *
 * @return bool true, если дата не раньше чем через сутки
 */
function isLotEndDateMinValid(string $name): bool
{
    if (!isset($_POST[$name]) || trim((string) $_POST[$name]) === '') {
        return true;
    }

    $date = trim((string) $_POST[$name]);
    $endDate = DateTimeImmutable::createFromFormat('Y-m-d', $date);
    $minDate = (new DateTimeImmutable('today'))->modify('+1 day');

    return $endDate !== false && $endDate >= $minDate;
}
