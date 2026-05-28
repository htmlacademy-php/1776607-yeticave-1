<?php

declare(strict_types=1);

/**
 * Проверяет валидацию для указанной формы.
 *
 * @param string $formName Имя формы из константы VALIDATION_RULES.
 *
 * @return array<string, string> Ассоциативный массив ошибок по полям.
 */
function validateForm(string $formName): array
{
    $errors = [];
    $formValidationRules = VALIDATION_RULES[$formName] ?? [];

    foreach ($formValidationRules as $fieldName => $fieldRules) {
        foreach ($fieldRules as $rule) {
            $validatorName = $rule['validator'];

            if (!function_exists($validatorName)) {
                continue;
            }

            $validatorArgs = array_merge([$fieldName], $rule['params'] ?? []);
            $error = $validatorName(...$validatorArgs);

            if ($error !== null) {
                $errors[$fieldName] = $rule['error'] ?? $error;
                break;
            }
        }
    }

    return $errors;
}
