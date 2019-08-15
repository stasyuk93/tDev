<?php

if (!function_exists('routeSort')) {
    function routeSort($routeName, $param){
        $sortQuery = null;
        $orderBy = 'asc';
        if(request()->has('sort')){
            $sortQuery = request()->get('sort');
            if(is_array($sortQuery) && array_key_exists($param, $sortQuery)){
                $orderBy = ($sortQuery[$param] == $orderBy)? 'desc':null;

            }
        }
        $sortQuery[$param] = $orderBy;
        $query = request()->query();
        if($sortQuery) {
            if($orderBy == null) unset( $sortQuery[$param]);
            $query['sort'] = $sortQuery;
        }
        $query['locale'] = app()->getLocale();

        return route($routeName,$query);
    }
}

if (!function_exists('routeLocale')) {
    function routeLocale($locale){
        $segments = request()->segments();
        $queryString = request()->getQueryString();
        $segments[0] = $locale;
        $segments = implode('/', $segments);
        return "/$segments?$queryString";
    }
}
