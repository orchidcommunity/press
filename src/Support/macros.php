<?php

use Orchid\Platform\Dashboard;
use Orchid\Press\Models\Post;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\TD;

TD::macro('linkPost', function (string $text = '') {
    $this->render(static function (Post $post) use ($text) {
        return (string) Link::make($text)
            ->href(route('platform.entities.type.edit', [
                'type' => $post->type,
                'post' => $post,
            ]));
    });

    return $this;
});

TD::macro('column', function (string $column = null) {
    if ($column !== null) {
        $this->column = $column;
    }
    if ($this->locale && $column !== null) {
        $locale = '.'.app()->getLocale().'.';
        $this->column = preg_replace('/'.preg_quote('.', '/').'/', $locale, $column);
    }

    return $this;
});

Dashboard::macro('getEntities', function () {
    return collect($this->getResource('entities'))->transform(function ($value) {
        return is_object($value) ? $value : new $value();
    });
});
