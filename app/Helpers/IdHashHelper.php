<?php

namespace App\Helpers;

class IdHashHelper
{
    private static $salt = 'your-salt-string';

    public static function encode($id)
    {
        return base64_encode($id . self::$salt);
    }

    public static function decode($hash)
    {
        $decoded = base64_decode($hash);
        return str_replace(self::$salt, '', $decoded);
    }
}
