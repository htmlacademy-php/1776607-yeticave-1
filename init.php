<?php

declare(strict_types=1);

require_once __DIR__ . '/util/constants.php';
require_once __DIR__ . '/functions/helpers.php';
require_once __DIR__ . '/functions/view.php';
require_once __DIR__ . '/functions/database.php';
require_once __DIR__ . '/functions/queries.php';
require_once __DIR__ . '/functions/bootstrap.php';

$con = db_connect();
