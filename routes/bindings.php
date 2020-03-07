<?php

use Illuminate\Support\Facades\Route;
use Orchid\Platform\Dashboard;
use Orchid\Press\Models\Category;
use Orchid\Press\Models\Page;
use Orchid\Press\Models\Post;

Route::bind('category', function ($value) {
    $category = Dashboard::modelClass(Category::class);

    return $category->where('id', $value)->firstOrFail();
});

Route::bind('type', function ($value) {
    $post = Dashboard::modelClass(Post::class);

    return $post->getEntity($value)->getEntityObject();
});

Route::bind('page', function ($value) {
    $model = Dashboard::modelClass(Page::class);

    $page = $model->where('id', $value)
        ->orWhere('slug', $value)
        ->first();

    if ($page === null) {
        $model->slug = $value;
        $page = $model;
    }

    return $page;
});

Route::bind('post', function ($value) {
    $post = Dashboard::modelClass(Post::class);

    return $post->where('id', $value)
        ->orWhere('slug', $value)
        ->firstOrFail();
});
