<?php

declare(strict_types=1);

/**
 * Проверяет одно поле по списку правил.
 *
 * @param string $fieldName Имя поля
 * @param array<int, array<string, mixed>> $fieldRules Правила валидации поля
 *
 * @return string|null Текст ошибки или null, если все проверки пройдены
 */
function getFieldValidationError(string $fieldName, array $fieldRules): ?string
{
    foreach ($fieldRules as $rule) {
        $validatorName = $rule['validator'];

        if (!function_exists($validatorName)) {
            continue;
        }

        $isValid = $validatorName($fieldName);

        if (!$isValid) {
            return $rule['error'];
        }
    }

    return null;
}

/**
 * Проверяет валидацию для указанной формы.
 *
 * @param string $formName Имя формы из константы VALIDATION_RULES
 *
 * @return array<string, string> Ассоциативный массив ошибок по полям
 */
function validateForm(string $formName): array
{
    $errors = [];
    $formValidationRules = VALIDATION_RULES[$formName] ?? [];

    foreach ($formValidationRules as $fieldName => $fieldRules) {
        $error = getFieldValidationError($fieldName, $fieldRules);

        if ($error !== null) {
            $errors[$fieldName] = $error;
        }
    }

    return $errors;
}
