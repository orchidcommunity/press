<?php

namespace Orchid\CMS\Core\Builders;

use Illuminate\Database\Eloquent\Builder;

class CommentBuilder extends Builder
{
    /**
     * Where clause for only approved comments.
     *
     * @return \Orchid\CMS\Core\Builders\CommentBuilder
     */
    public function approved(): CommentBuilder
    {
        return $this->where('approved', 1);
    }
}
