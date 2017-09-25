<?php

namespace Orchid\CMS\Core\Models;

use Orchid\CMS\Core\Traits\Attachment;

class Category extends TermTaxonomy
{
    use Attachment;

    /**
     * Used to set the post's type.
     */
    protected $taxonomy = 'category';
}
