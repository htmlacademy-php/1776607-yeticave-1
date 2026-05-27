<?php

declare(strict_types=1);

require_once __DIR__ . '/util/constants.php';
require_once __DIR__ . '/enum/HttpCode.php';
require_once __DIR__ . '/functions/helpers.php';
require_once __DIR__ . '/functions/view.php';
require_once __DIR__ . '/functions/database/core.php';
require_once __DIR__ . '/functions/database/queries.php';

$con = db_connect();
$categories = get_categories($con);
$isAuth = (bool) rand(0, 1);
$userName = 'Stepan Kormilin';
