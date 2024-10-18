<?php

namespace App\Helpers;

class ImageHelper
{
    public static function getBase64Image($path)
    {
        if (file_exists($path)) {
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            return 'data:image/' . $type . ';base64,' . base64_encode($data);
        } else {
            return null;
        }
    }
}