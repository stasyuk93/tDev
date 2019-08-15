<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['image_id','created_at'];

    public $timestamps = false;

    public $with = [
        'articleData',
        'image'
    ];

    /**
     * @var array
     */
    static protected $order = ['date','title'];

    /**
     * @var int
     */
    static protected $count = 5;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function articleData()
    {
        $lang = Language::where('slug',app()->getLocale())->first();
        return $this->hasOne(ArticleData::class)->where('language_id',$lang->id);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    static public function getArticles()
    {
        $lang = Language::where('slug',app()->getLocale())->first();
        $articles = self::query()
            ->select(['articles.*'])
            ->join('article_data','article_data.article_id','=','articles.id')
            ->where('article_data.language_id', $lang->id)
            ;
        self::queryOrder($articles);

        return $articles->paginate(self::$count);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $articles
     */
    static protected function queryOrder(\Illuminate\Database\Eloquent\Builder $articles)
    {
        $order= request()->get('sort');
        if($order){
            foreach ($order as $key => $value) {
                if (self::validateOrder($key, $value)) {
                    if($key == 'date') $key = 'created_at';
                    $articles->orderBy($key, $value);
                }
            }
        }
    }

    /**
     * @param $column
     * @param $value
     * @return bool
     */
    static protected function validateOrder($column, $value)
    {
            if(in_array($column, self::$order)){
                if(mb_strtolower($value) == 'asc' || mb_strtolower($value) == 'desc'){
                    return true;
                }
            }
            return false;
    }


}
