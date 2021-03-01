<?php

namespace App\Http\Controllers;

use App\Models\Url;;

class RedirectController extends Controller
{
    public function __invoke($shortUrl)
    {
        $url = Url::where('short_url', $shortUrl)->firstOrFail();
        if($url) {
            return redirect($url->url);
        }
    }
}
