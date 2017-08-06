<?php

namespace Orchid\CMS\Behaviors\Storage;

use Orchid\Platform\Kernel\Storage;

class PageStorage extends Storage
{
    /**
     * @var string
     */
    protected $configField = 'content.pages';
}
