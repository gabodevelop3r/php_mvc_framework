<?php

use Lib\Route;

Route::get('/', function (){
    echo 'hello world from index';
});

Route::get('/contact', function (){
    echo 'hello world from contact';
});

Route::get('/about', function (){
    echo 'hello world from about';
});

Route::dispatch();
