<?php

namespace App\Repositories;

use App\Models\Url;
use App\Repositories\Interfaces\UrlRepositoryInterface;
use App\Services\UrlShortener;
use Illuminate\Support\Facades\Auth;

class UrlRepository implements UrlRepositoryInterface
{
    public function all()
    {
        return Url::with('user')->get()->each(function ($item) {
            $item->short_url = url('/') . '/go/' . $item->short_url;
        });
    }

    public function findForUser($user)
    {
        return $user->urls()->get()->each(function ($item) {
            $item->short_url = url('/') . '/go/' . $item->short_url;
        });
    }

    public function store(array $attributes)
    {
        Url::create([
            'title' => $attributes['title'],
            'url' => $attributes['url'],
            'short_url' => UrlShortener::create(),
            'user_id' => Auth::user()->id
        ]);
    }

    public function update(array $attributes, Url $url)
    {
        $url->update([
            'title' => $attributes['title'],
            'url' => $attributes['url'],
            'short_url' => UrlShortener::create()
        ]);
    }

}
