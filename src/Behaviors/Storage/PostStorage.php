<?php

namespace Orchid\CMS\Behaviors\Storage;

use Orchid\Platform\Kernel\Storage;

class PostStorage extends Storage
{
    /**
     * @var string
     */
    protected $configField = 'content.types';
}
