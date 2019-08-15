<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ArticleServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('article_services')->insert([
            [
                'name' => 'Корреспондент - информационно-новостной портал',
                'url' => 'http://k.img.com.ua/rss/ua/ukraine.xml',
                'language_id' => 1,
            ],
            [
                'name' => 'Корреспондент - информационно-новостной портал',
                'url' => 'http://k.img.com.ua/rss/ru/ukraine.xml',
                'language_id' => 2,
            ],
        ]);
    }
}
