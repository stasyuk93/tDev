<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleService extends Model
{
    protected $fillable = [
        'name', 'url', 'language_id',
    ];

    public $timestamps = false;
}
