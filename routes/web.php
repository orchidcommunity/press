<?php

declare(strict_types=1);

use Orchid\Press\Http\Controllers\PressController;

$this->router->get('/', [PressController::class, 'index'])->name('home');

$this->router->get('tag/{tag}', [PressController::class, 'tagsPosts'])
    ->name('tag.posts');

$this->router->get('/{term}', [PressController::class, 'category'])
    //->where('cat','^(?!dashboard).*$')
    ->name('posts');

$this->router->get('/{term}/{post}', [PressController::class, 'post'])
    //->where('cat','^(?!dashboard).*$')
    ->name('post');

/*
$this->router->get('/category/{term}/{post}',[PressController::class, 'post'])
    //->where('cat','^(?!dashboard).*$')
    ->name('category.post');


$this->router->get('/category/{term}',[PressController::class, 'category'])
    ->name('category');
*/
