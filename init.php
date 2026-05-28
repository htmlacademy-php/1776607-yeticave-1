<?php

declare(strict_types=1);

require_once __DIR__ . '/util/constants.php';
require_once __DIR__ . '/enum/HttpCode.php';
require_once __DIR__ . '/functions/helpers.php';
require_once __DIR__ . '/functions/view.php';
require_once __DIR__ . '/functions/database/core.php';
require_once __DIR__ . '/functions/database/queries.php';
require_once __DIR__ . '/validation/validators.php';
require_once __DIR__ . '/validation/rules.php';
require_once __DIR__ . '/validation/index.php';

$con = dbConnect();
$categories = getCategories($con);
$isAuth = true;
$userName = 'Stepan Kormilin';
