<?php

declare(strict_types=1);

/**
 * Проверяет, что поле заполнено.
 *
 * @param string $name Имя поля в $_POST
 *
 * @return string|null Текст ошибки или null, если поле не пустое
 */
function isFilled(string $name): ?string
{
    if (!isset($_POST[$name]) || trim((string) $_POST[$name]) === '') {
        return 'Это поле должно быть заполнено';
    }

    return null;
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
 * @return string|null Текст ошибки или null, если файл корректен
 */
function isUploadedImageValid(string $name): ?string
{
    if (!isset($_FILES[$name])) {
        return 'Загрузите изображение';
    }

    $file = $_FILES[$name];

    if ($file['error'] === UPLOAD_ERR_NO_FILE) {
        return 'Загрузите изображение';
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        return 'Не удалось загрузить файл';
    }

    $temporaryPath = $file['tmp_name'];

    if (!is_uploaded_file($temporaryPath)) {
        return 'Загрузите изображение';
    }

    $mimeType = mime_content_type($temporaryPath);
    $allowedMimeTypes = ['image/png', 'image/jpeg'];

    if (!in_array($mimeType, $allowedMimeTypes, true)) {
        return 'Загрузите изображение в формате PNG или JPEG';
    }

    return null;
}

/**
 * Проверяет, что значение поля — число больше нуля.
 *
 * @param string $name Имя поля в $_POST
 * @param string $errorMessage Текст ошибки при некорректном значении
 *
 * @return string|null Текст ошибки или null, если значение корректно
 */
function isPositiveNumber(string $name, string $errorMessage): ?string
{
    if (!isset($_POST[$name]) || trim((string) $_POST[$name]) === '') {
        return null;
    }

    $value = str_replace(',', '.', trim((string) $_POST[$name]));

    if (!is_numeric($value) || (float) $value <= 0) {
        return $errorMessage;
    }

    return null;
}

/**
 * Проверяет, что значение поля — целое число больше нуля.
 *
 * @param string $name Имя поля в $_POST
 * @param string $errorMessage Текст ошибки при некорректном значении
 *
 * @return string|null Текст ошибки или null, если значение корректно
 */
function isPositiveInteger(string $name, string $errorMessage): ?string
{
    if (!isset($_POST[$name]) || trim((string) $_POST[$name]) === '') {
        return null;
    }

    $value = filter_var(trim((string) $_POST[$name]), FILTER_VALIDATE_INT);

    if ($value === false || $value <= 0) {
        return $errorMessage;
    }

    return null;
}

/**
 * Проверяет дату окончания торгов в формате «ГГГГ-ММ-ДД».
 *
 * @param string $name Имя поля в $_POST
 *
 * @return string|null Текст ошибки или null, если дата корректна
 */
function isLotEndDateValid(string $name): ?string
{
    if (!isset($_POST[$name]) || trim((string) $_POST[$name]) === '') {
        return null;
    }

    $date = trim((string) $_POST[$name]);

    if (!isDateValid($date)) {
        return 'Введите дату в формате ГГГГ-ММ-ДД';
    }

    $endDate = DateTimeImmutable::createFromFormat('Y-m-d', $date);
    $minDate = (new DateTimeImmutable('today'))->modify('+1 day');

    if ($endDate === false || $endDate < $minDate) {
        return 'Укажите дату не раньше чем через сутки';
    }

    return null;
}
