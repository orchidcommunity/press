<?php

declare(strict_types=1);

namespace Orchid\Press\Http\Layouts\Comment;

use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class CommentEditLayout extends Rows
{
    /**
     * Views.
     *
     * @throws \Throwable
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            TextArea::make('comment.content')
                ->max(255)
                ->rows(10)
                ->required()
                ->title(__('Content'))
                ->help(__('User comment')),

            CheckBox::make('comment.approved')
                ->title(__('Checking'))
                ->help(__('Show comment'))
                ->sendTrueOrFalse(),
        ];
    }
}
