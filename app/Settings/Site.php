<?php

namespace App\Settings;

class Site
{
    public static function reservedUsernames(): array
    {
        return ["penlumen", "writer", "pgwriter", "adminer"];
    }
}
