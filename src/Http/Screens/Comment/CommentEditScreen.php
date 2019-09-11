<?php

declare(strict_types=1);

namespace Orchid\Press\Http\Screens\Comment;

use Illuminate\Http\Request;
use Orchid\Press\Http\Layouts\Comment\CommentEditLayout;
use Orchid\Press\Models\Comment;
use Orchid\Screen\Layout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

class CommentEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Comments';
    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'User Comments';

    /**
     * Query data.
     *
     * @param \Orchid\Press\Models\Comment $comment
     *
     * @return array
     */
    public function query(Comment $comment): array
    {
        return [
            'comment' => $comment,
        ];
    }

    /**
     * Button commands.
     *
     * @return Link[]
     */
    public function commandBar(): array
    {
        return [
            Link::make(__('Save'))
                ->icon('icon-check')
                ->method('save'),

            Link::make(__('Remove'))
                ->icon('icon-trash')
                ->method('remove'),
        ];
    }

    /**
     * Views.
     *
     * @return Layout[]
     */
    public function layout(): array
    {
        return [
            Layout::columns([
                'CommentEdit' => [
                    CommentEditLayout::class,
                ],
            ]),
        ];
    }

    /**
     * @param Comment $comment
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Comment $comment, Request $request)
    {
        $comment
            ->fill($request->get('comment'))
            ->save();

        Alert::info(__('Comment was saved'));

        return redirect()->route('platform.systems.comments');
    }

    /**
     * @param Comment $comment
     *
     * @throws \Exception
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Comment $comment)
    {
        $comment->delete();

        Alert::info(__('Comment was removed'));

        return redirect()->route('platform.systems.comments');
    }
}
