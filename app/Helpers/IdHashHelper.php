<?php

namespace App\Helpers;

class IdHashHelper
{
    private static $salt = 'your-unique-salt-string';

    public static function encode($id)
    {
        $stringToEncode = $id . self::$salt;
        return base64_encode($stringToEncode);
    }

    public static function decode($hash)
    {
        $decoded = base64_decode($hash);
        return str_replace(self::$salt, '', $decoded);
    }
}
