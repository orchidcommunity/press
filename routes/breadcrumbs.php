<?php

// Platform > System > Menu
Breadcrumbs::for('platform.systems.menu.index', function ($trail) {
    $trail->parent('platform.systems.index');
    $trail->push(__('Menu'), route('platform.systems.menu.index'));
});

// Platform > System > Menu > Editing
Breadcrumbs::for('platform.systems.menu.show', function ($trail, $menu) {
    $trail->parent('platform.systems.menu.index');
    $trail->push(__('Editing'), route('platform.systems.menu.show', $menu));
});

// Platform > System > Category
Breadcrumbs::for('platform.systems.category', function ($trail) {
    $trail->parent('platform.systems.index');
    $trail->push(__('Categories'), route('platform.systems.category'));
});

// Platform > System > Categories > Create
Breadcrumbs::for('platform.systems.category.create', function ($trail) {
    $trail->parent('platform.systems.category');
    $trail->push(__('Create'), route('platform.systems.category.create'));
});

// Platform > Categories > Category
Breadcrumbs::for('platform.systems.category.edit', function ($trail, $category) {
    $trail->parent('platform.systems.category');
    $trail->push(__('Category'), route('platform.systems.category.edit', $category));
});

// Platform > System > Comments
Breadcrumbs::for('platform.systems.comments', function ($trail) {
    $trail->parent('platform.systems.index');
    $trail->push(__('Comments'), route('platform.systems.comments'));
});

// Platform > System > Comments > Comment
Breadcrumbs::for('platform.systems.comments.edit', function ($trail, $comment) {
    $trail->parent('platform.systems.comments');
    $trail->push(__('Comment'), route('platform.systems.comments.edit', $comment));
});

//Posts

// Platform > Posts
Breadcrumbs::for('platform.entities.type', function ($trail, $type) {
    $trail->parent('platform.index');
    $trail->push(__('Posts'), route('platform.entities.type', $type->slug));
});

// Platform > Posts > Create
Breadcrumbs::for('platform.entities.type.create', function ($trail, $type) {
    $trail->parent('platform.entities.type', $type);
    $trail->push(__('Create'), route('platform.entities.type', $type->slug));
});

// Platform > Posts > Edit
Breadcrumbs::for('platform.entities.type.edit', function ($trail, $type, $post) {
    $trail->parent('platform.entities.type', $type);
    $trail->push($post->getContent($type->slugFields) ?? '—', route('platform.entities.type.edit', [$type->slug, $post->slug]));
});

// Platform > Pages
Breadcrumbs::for('platform.entities.type.page', function ($trail, $page) {
    $trail->parent('platform.index');
    $trail->push(__('Pages'), route('platform.entities.type.page', $page));
});


// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Home', route('home'));
});

// Home > About
Breadcrumbs::for('about', function ($trail) {
    $trail->parent('home');
    $trail->push('About', route('about'));
});

// Home > Blog
Breadcrumbs::for('blog', function ($trail) {
    $trail->parent('home');
    $trail->push('Blog', route('blog'));
});

// Home > Blog > [Category]
Breadcrumbs::for('category', function ($trail, $category) {
    $trail->parent('blog');
    $trail->push($category->title, route('category', $category->id));
});

// Home > Blog > [Category] > [Post]
Breadcrumbs::for('post', function ($trail, $post) {
    $trail->parent('category', $post->category);
    $trail->push($post->title, route('post', $post->id));
});