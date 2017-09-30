<?php

namespace Orchid\CMS\Listeners\Tools\Comment;

use Orchid\CMS\Http\Forms\Tools\Comment\BaseCommentForm;

class CommentBaseListener
{
    /**
     * Handle the event.
     *
     * @return string
     *
     * @internal param CommentEvent $event
     */
    public function handle()
    {
        return BaseCommentForm::class;
    }
}
