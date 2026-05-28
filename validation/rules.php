<?php

declare(strict_types=1);

const VALIDATION_RULES = [
    'add-lot' => [
        'lot-name' => [
            ['validator' => 'isFilled', 'error' => 'Введите наименование лота'],
        ],
        'category' => [
            ['validator' => 'isFilled', 'error' => 'Выберите категорию'],
        ],
        'message' => [
            ['validator' => 'isFilled', 'error' => 'Напишите описание лота'],
        ],
        'lot-img' => [
            ['validator' => 'isUploadedImageValid'],
        ],
        'lot-rate' => [
            ['validator' => 'isFilled', 'error' => 'Введите начальную цену'],
            ['validator' => 'isPositiveNumber', 'params' => ['Введите начальную цену']],
        ],
        'lot-step' => [
            ['validator' => 'isFilled', 'error' => 'Введите шаг ставки'],
            ['validator' => 'isPositiveInteger', 'params' => ['Введите шаг ставки']],
        ],
        'lot-date' => [
            ['validator' => 'isFilled', 'error' => 'Введите дату завершения торгов'],
            ['validator' => 'isLotEndDateValid'],
        ],
    ],
];
