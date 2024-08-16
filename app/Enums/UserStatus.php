<?php

namespace App\Enums;


enum UserStatus: int
{
    case ACTIVE = 3;
    case SUSPENDED = 6;
    case BANNED = 9;
}
