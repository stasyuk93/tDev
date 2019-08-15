<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('languages')->insert([
            [
                'name' => 'Украинский',
                'slug' => 'ua',
            ],
            [
                'name' => 'Русский',
                'slug' => 'ru',
            ],
        ]);
    }
}
