<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Available fields to form templates
    |--------------------------------------------------------------------------
    |
    | Declared fields for user filling.
    | Be shy and add to what you need
    |
    */

    'fields' => [
        'textarea' => Orchid\CMS\Fields\TextAreaField::class,
        'input'    => Orchid\CMS\Fields\InputField::class,
        'list'     => Orchid\CMS\Fields\ListField::class,
        'tags'     => Orchid\CMS\Fields\TagsField::class,
        'robot'    => Orchid\CMS\Fields\RobotField::class,
        'place'    => Orchid\CMS\Fields\PlaceField::class,
        'picture'  => Orchid\CMS\Fields\PictureField::class,
        'datetime' => Orchid\CMS\Fields\DateTimerField::class,
        'checkbox' => Orchid\CMS\Fields\CheckBoxField::class,
        'code'     => Orchid\CMS\Fields\CodeField::class,
        'wysiwyg'  => Orchid\CMS\Fields\MediumField::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Single Behaviors
    |--------------------------------------------------------------------------
    |
    | Static pages
    |
    */

    'single' => [
        //App\Core\Behaviors\Single\DemoPage::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Many Behaviors
    |--------------------------------------------------------------------------
    |
    | An abstract pattern of behavior record
    |
    */

    'many' => [
        //App\Core\Behaviors\Many\DemoPost::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Available menu
    |--------------------------------------------------------------------------
    |
    | Marked menu areas
    |
    */

    'menu' => [
        'header'  => 'Top Menu',
        'sidebar' => 'Sidebar Menu',
        'footer'  => 'Footer Menu',
    ],

    /*
    |--------------------------------------------------------------------------
    | Images
    |--------------------------------------------------------------------------
    |
    | Image processing 100x150x75
    | 100 - integer width
    | 150 - integer height
    | 75  - integer quality
    |
    */

    'images' => [
        'low'    => [
            'width'   => '50',
            'height'  => '50',
            'quality' => '50',
        ],
        'medium' => [
            'width'   => '600',
            'height'  => '300',
            'quality' => '75',
        ],
        'high'   => [
            'width'   => '1000',
            'height'  => '500',
            'quality' => '95',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Available locales
    |--------------------------------------------------------------------------
    |
    | Localization of records
    |
    */

    'locales'     => [
        'en' => [
            'name'     => 'English',
            'script'   => 'Latn',
            'dir'      => 'ltr',
            'native'   => 'English',
            'regional' => 'en_GB',
        ],
    ],


    /*
    |--------------------------------------------------------------------------
    | Advertising areas
    |--------------------------------------------------------------------------
    |
    | Starred areas for ad units
    |
    */
    'advertising' => [
        'top'    => 'Top banner',
        'side'   => 'Side banner',
        'footer' => 'Banner cellar',
    ],


    /*
    |--------------------------------------------------------------------------
    | Attachment types
    |--------------------------------------------------------------------------
    |
    | ...
    |
    */
    'attachment'  => [
        'image' => [
            'png',
            'jpg',
            'jpeg',
            'gif',
        ],
        'video' => [
            'mp4',
            'mkv',
        ],
        'docs'  => [
            'doc',
            'docx',
            'pdf',
            'xls',
            'xlsx',
            'xml',
            'txt',
            'zip',
            'rar',
            'svg',
            'ppt',
            'pptx',
        ],
    ],

];
