<?php

declare(strict_types=1);

use Orchid\Press\Http\Screens\EntityEditScreen;
use Orchid\Press\Http\Screens\EntityListScreen;
use Orchid\Press\Http\Controllers\MenuController;
use Orchid\Press\Http\Screens\Comment\CommentEditScreen;
use Orchid\Press\Http\Screens\Comment\CommentListScreen;
use Orchid\Press\Http\Screens\Category\CategoryEditScreen;
use Orchid\Press\Http\Screens\Category\CategoryListScreen;
use Orchid\Press\Http\Controllers\Systems\TagsController;

/*
|--------------------------------------------------------------------------
| Press Web Routes
|--------------------------------------------------------------------------
|
| Base route
|
*/

// Comments...
$this->router->screen('comments/{comments}/edit', CommentEditScreen::class)->name('systems.comments.edit');
$this->router->screen('comments/create', CommentEditScreen::class)->name('systems.comments.create');
$this->router->screen('comments', CommentListScreen::class)->name('systems.comments');

// Categories...
$this->router->screen('category/{category}/edit', CategoryEditScreen::class)->name('systems.category.edit');
$this->router->screen('category/create', CategoryEditScreen::class)->name('systems.category.create');
$this->router->screen('category', CategoryListScreen::class)->name('systems.category');

// Entities...
$this->router->screen('entities/{type}/{post?}/edit', EntityEditScreen::class)->name('entities.type.edit');
$this->router->screen('entities/{type}/create', EntityEditScreen::class)->name('entities.type.create');
$this->router->screen('entities/{type}/{page?}/page', EntityEditScreen::class)->name('entities.type.page');
$this->router->screen('entities/{type}', EntityListScreen::class)->name('entities.type');

// Menu...
$this->router->resource('menu', MenuController::class, [
    'only'  => [
        'index', 'show', 'update', 'store', 'destroy',
    ],
    'names' => [
        'index'   => 'systems.menu.index',
        'show'    => 'systems.menu.show',
        'update'  => 'systems.menu.update',
        'store'   => 'systems.menu.store',
        'destroy' => 'systems.menu.destroy',
    ],
]);

$this->router->get('tags/{tags?}', [TagsController::class, 'show'])
    ->name('systems.tag.search');
