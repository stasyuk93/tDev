<?php

namespace App\Composers;
use App\Models\Language;
use Illuminate\Contracts\View\View;

class LanguageComposer
{

    public function compose(View $view)
    {
        return $view->with('languages', Language::all())->with( 'current_language', app()->getLocale());
    }
}