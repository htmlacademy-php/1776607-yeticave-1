<?php

declare(strict_types=1);

require_once __DIR__ . '/init.php';

/**
 * @var mysqli $con
 * @var array  $categories
 * @var bool   $isAuth
 * @var string $userName
 */

if (!$isAuth) {
    http_response_code(403);
    header('Location: index.php');
    exit;
}

$formData = [
    'lot-name' => '',
    'category' => '',
    'message' => '',
    'lot-rate' => '',
    'lot-step' => '',
    'lot-date' => '',
];
$errors = [];
$hasErrors = false;
$categoryIds = array_map('intval', array_column($categories, 'id'));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formData = [
        'lot-name' => trim((string) ($_POST['lot-name'] ?? '')),
        'category' => trim((string) ($_POST['category'] ?? '')),
        'message' => trim((string) ($_POST['message'] ?? '')),
        'lot-rate' => trim((string) ($_POST['lot-rate'] ?? '')),
        'lot-step' => trim((string) ($_POST['lot-step'] ?? '')),
        'lot-date' => trim((string) ($_POST['lot-date'] ?? '')),
    ];

    $errors = validateForm('add-lot');

    if (!isset($errors['category'])) {
        $categoryId = filter_var($formData['category'], FILTER_VALIDATE_INT);

        if ($categoryId === false || !in_array((int) $categoryId, $categoryIds, true)) {
            $errors['category'] = 'Выберите категорию';
        }
    }

    $hasErrors = $errors !== [];

    if (!$hasErrors) {
        $imagePath = saveUploadedLotImage('lot-img');

        if ($imagePath === null) {
            $errors['lot-img'] = 'Не удалось сохранить изображение';
            $hasErrors = true;
        } else {
            $initialPrice = (int) ceil((float) str_replace(',', '.', $formData['lot-rate']));
            $betStep = (int) $formData['lot-step'];
            $expiresAt = $formData['lot-date'] . ' 23:59:59';

            $newLotId = createLot($con, [
                'name' => $formData['lot-name'],
                'description' => $formData['message'],
                'image_url' => $imagePath,
                'initial_price' => $initialPrice,
                'expires_at' => $expiresAt,
                'bet_step' => $betStep,
                'author_id' => LOT_AUTHOR_ID_PLACEHOLDER,
                'category_id' => (int) $formData['category'],
            ]);

            header('Location: lot.php?lot_id=' . $newLotId);
            exit;
        }
    }
}

echo includeTemplate('layout/layout.php', [
    'title' => 'Добавление лота',
    'mainContent' => includeTemplate('add-lot.php', compact('categories', 'errors', 'formData', 'hasErrors')),
    'categories' => $categories,
    'isAuth' => $isAuth,
    'userName' => $userName,
    'isMainContainer' => false,
    'useFlatpickr' => true, // assets/css/flatpickr.min.css условное подключение
]);
