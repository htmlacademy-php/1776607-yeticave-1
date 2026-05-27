<?php

declare(strict_types=1);

enum HttpCode: int
{
    case Ok = 200;
    case NotFound = 404;
}
