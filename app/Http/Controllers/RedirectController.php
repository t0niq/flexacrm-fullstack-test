<?php

namespace App\Http\Controllers;

use App\Models\Url;;

class RedirectController extends Controller
{
    public function __invoke($slug)
    {
        $url = Url::where('short_url', $slug)->firstOrFail();
        if($url) {
            return redirect($url->url);
        }
    }
}
