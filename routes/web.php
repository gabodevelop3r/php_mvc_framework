<?php

use Lib\Route;

Route::get('/', function (){
    return [
        'title' => 'titulo',
        'content' => 'content'
    ];
});

Route::get('/contact', function (){
    return 'hello world from contact';
});

Route::get('/about', function (){
    return 'hello world from about';
});

Route::get('/courses/:slug', function ($slug){
    return "el curso es : $slug";
});

Route::dispatch();
