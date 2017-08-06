<?php

namespace Orchid\CMS\Http\Forms\Marketing\Comment;

use Illuminate\Contracts\View\View;
use Orchid\CMS\Core\Models\Comment;
use Orchid\CMS\Events\Marketing\CommentEvent;
use Orchid\Platform\Forms\FormGroup;

class CommentFormGroup extends FormGroup
{
    /**
     * @var
     */
    public $event = CommentEvent::class;

    /**
     * Description Attributes for group.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'name'        => trans('cms::marketing/comment.title'),
            'description' => trans('cms::marketing/comment.description'),
        ];
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|View|\Illuminate\View\View
     */
    public function main(): View
    {
        $comments = (new Comment())->with([
            'post' => function ($query) {
                $query->select('id', 'type', 'slug');
            },
        ])->orderBy('id', 'desc')->paginate();

        return view('cms::container.marketing.comment.grid', [
            'comments' => $comments,
        ]);
    }
}
