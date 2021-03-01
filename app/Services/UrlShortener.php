<?php

namespace App\Services;

class UrlShortener
{
    public static function create()
    {
        return substr(md5(microtime()), rand(0, 20), 8);
    }
}
