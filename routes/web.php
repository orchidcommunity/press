<?php

declare(strict_types=1);

use Orchid\Press\Http\Controllers\PressController;

$this->router->get('/',[PressController::class, 'index'])->name('home');


$this->router->get('tag/{tag}',[PressController::class, 'tagsPosts'])
    ->name('tag.posts');
/*
$this->router->get('/{blogcat}/{prefpost}/{subpost}',[PressController::class, 'subpost'])
    //->where('cat','^(?!dashboard).*$')
    ->name('blog.subpost');
*/
$this->router->get('/{term}/{post}',[PressController::class, 'post'])
    //->where('cat','^(?!dashboard).*$')
    ->name('post');


$this->router->get('{term}',[PressController::class, 'category'])
    ->name('category');



