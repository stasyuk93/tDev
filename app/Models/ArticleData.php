<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleData extends Model
{
    protected $fillable = ['url','language_id','title','description', 'article_id'];

    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function language()
    {
        return $this->hasOne(Language::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
