<?php
declare(strict_types=1);

/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return mysqli_stmt Подготовленное выражение
 */
function dbGetPrepareStmt($link, $sql, $data = []) {
    $stmt = mysqli_prepare($link, $sql);

    if ($stmt === false) {
        $errorMsg = 'Не удалось инициализировать подготовленное выражение: ' . mysqli_error($link);
        die($errorMsg);
    }

    if ($data) {
        $types = '';
        $stmtData = [];

        foreach ($data as $value) {
            $type = 's';

            if (is_int($value)) {
                $type = 'i';
            }
            else if (is_string($value)) {
                $type = 's';
            }
            else if (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmtData[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmtData);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);

        if (mysqli_errno($link) > 0) {
            $errorMsg = 'Не удалось связать подготовленное выражение с параметрами: ' . mysqli_error($link);
            die($errorMsg);
        }
    }

    return $stmt;
}

/**
 * Возвращает корректную форму множественного числа
 * Ограничения: только для целых чисел
 *
 * Пример использования:
 * $remainingMinutes = 5;
 * echo "Я поставил таймер на {$remainingMinutes} " .
 *     getNounPluralForm(
 *         $remainingMinutes,
 *         'минута',
 *         'минуты',
 *         'минут'
 *     );
 * Результат: "Я поставил таймер на 5 минут"
 *
 * @param int $number Число, по которому вычисляем форму множественного числа
 * @param string $one Форма единственного числа: яблоко, час, минута
 * @param string $two Форма множественного числа для 2, 3, 4: яблока, часа, минуты
 * @param string $many Форма множественного числа для остальных чисел
 *
 * @return string Рассчитанная форма множественнго числа
 */
function getNounPluralForm(int $number, string $one, string $two, string $many): string
{
    $number = (int) $number;
    $mod10 = $number % 10;
    $mod100 = $number % 100;

    switch (true) {
        case ($mod100 >= 11 && $mod100 <= 20):
            return $many;

        case ($mod10 > 5):
            return $many;

        case ($mod10 === 1):
            return $one;

        case ($mod10 >= 2 && $mod10 <= 4):
            return $two;

        default:
            return $many;
    }
}

/**
 * Подключает шаблон, передает туда данные и возвращает итоговый HTML контент
 * @param string $name Путь к шаблону относительно templates (например, main.php, layout/layout.php)
 * @param array $data Ассоциативный массив с данными для шаблона
 * @return string Итоговый HTML
 */
function includeTemplate($name, array $data = []) {
    $name = __DIR__ . '/../templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}

/**
 * Переносит загруженное изображение лота в публичную директорию.
 *
 * @param string $fieldName Имя поля в $_FILES.
 *
 * @return string|null Относительный путь к файлу или null при ошибке сохранения.
 */
function saveUploadedLotImage(string $fieldName): ?string
{
    if (!isset($_FILES[$fieldName]) || $_FILES[$fieldName]['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    $temporaryPath = $_FILES[$fieldName]['tmp_name'];
    $mimeType = mime_content_type($temporaryPath);
    $extension = $mimeType === 'image/png' ? 'png' : 'jpg';
    $uploadsPath = __DIR__ . '/../' . UPLOADS_DIR;

    // создаем директорию для загрузки изображений, если она не существует
    if (!is_dir($uploadsPath)) {
        mkdir($uploadsPath, 0755, true);
    }

    $fileName = uniqid('lot_', true) . '.' . $extension;
    $destinationPath = $uploadsPath . '/' . $fileName;

    if (!move_uploaded_file($temporaryPath, $destinationPath)) {
        return null;
    }

    return UPLOADS_DIR . '/' . $fileName;
}
