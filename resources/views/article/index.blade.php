@extends('app')
@section('content')
    <div class="container fixed-top text-center border-bottom border-success mb-3 bg-light text-secondary" style="top: 56px">
        <div class="row">
            <div class="col-md-2 col-sm-4 col-6">
                <a class="h5 text-secondary" href="{{routeSort('article','date')}}" style="text-decoration: none">@lang('article.date') <i class="fa fa-sort"></i></a>
            </div>
            <div class="col-md-4 col-sm-8 col-6">
                <a class="h5 text-secondary" href="{{routeSort('article', 'title')}}" style="text-decoration: none">@lang('article.title') <i class="fa fa-sort"></i></a>
            </div>
            <div class="col-md-6 d-none d-sm-none d-md-block">
                <h5>@lang('article.description')</h5>
            </div>
        </div>
    </div>
    <div class="mb-3 position-relative" style="top:50px">
        @foreach($articles as $article)
        <div class=" row border-bottom border-primary" style="margin-bottom: 3em">
            <div class="col-md-2 col-sm-4 col-12 text-center">{{$article->created_at}}</div>
            <div class="col-md-4 col-sm-8 col-12">
                <img class="mx-auto rounded d-block" src="{{$article->image->url}}" alt="">
                <p>
                    <a href="{{$article->articleData->url}}">{{$article->articleData->title}}</a>
                </p>
            </div>
            <div class="col-md-6 col-sm-12 col-12">{{$article->articleData->description}}</div>
        </div>
        @endforeach
    </div>
    <div class="container fixed-bottom bg-light" style="height: 3em">
        {{$articles->appends(request()->query())->links()}}
    </div>
@endsection