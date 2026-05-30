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
        'description' => [
            ['validator' => 'isFilled', 'error' => 'Напишите описание лота'],
        ],
        'lot-img' => [
            ['validator' => 'isUploadedImageValid', 'error' => 'Загрузите изображение в формате PNG или JPEG'],
        ],
        'lot-rate' => [
            ['validator' => 'isFilled', 'error' => 'Введите начальную цену'],
            ['validator' => 'isPositiveNumber', 'error' => 'Некорректное значение начальной цены'],
        ],
        'lot-step' => [
            ['validator' => 'isFilled', 'error' => 'Введите шаг ставки'],
            ['validator' => 'isPositiveInteger', 'error' => 'Некорректное значение шага ставки'],
        ],
        'lot-date' => [
            ['validator' => 'isFilled', 'error' => 'Введите дату завершения торгов'],
            ['validator' => 'isLotDateFormatValid', 'error' => 'Введите дату в формате ГГГГ-ММ-ДД'],
            ['validator' => 'isLotEndDateMinValid', 'error' => 'Укажите дату не раньше чем через сутки'],
        ],
    ],
];
