<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'title', 'url', 'short_url', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
