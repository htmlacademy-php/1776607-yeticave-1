<?php

declare(strict_types=1);

enum HttpCode: int
{
    case Ok = 200;
    case Forbidden = 403;
    case NotFound = 404;
}
