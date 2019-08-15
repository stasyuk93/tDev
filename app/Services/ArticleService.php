<?php

namespace App\Services;

use \GuzzleHttp\Client;
use App\Models\ArticleService as ArticleServiceModel;
use App\Models\Article;
use App\Models\Image;
use App\Models\ArticleData;

class ArticleService
{
    /**
     * @var ArticleServiceModel[]|\Illuminate\Database\Eloquent\Collection
     */
    protected $services;

    /**
     * @var Client
     */
    protected $client;

    public function __construct()
    {
        $this->services = ArticleServiceModel::all();
        $this->client = new Client();
    }

    /**
     * @return $this
     */
    public function handle()
    {
        foreach ($this->services as $service) {
            $response = $this->getGuzzleRequest($service);
            $data = ArticleParser::parse($response);
            $this->saveData($data,$service->language_id);
        }

        return $this;
    }

    /**
     * @param ArticleServiceModel $service
     * @return string
     */
    public function getGuzzleRequest(ArticleServiceModel $service)
    {
        $request = $this->client->get($service->url);

        return $request->getBody()->getContents();
    }

    /**
     * @param array $data
     * @param int $language
     */
    public function saveData(array $data, int $language)
    {
        foreach ($data as $item){
            $image =  new Image(['url' => $item['image']]);
            $image->save();
            $article = new Article([
                'image_id' => $image->id,
                'created_at' => $item['date'],
            ]);
            $article->save();
            $articleData = new ArticleData([
                'title' => $item['title'],
                'description' => $item['description'],
                'url' => $item['url'],
                'article_id' => $article->id,
                'language_id' => $language
            ]);
            $articleData->save();
        }


    }
}