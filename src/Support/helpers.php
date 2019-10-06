<?php

declare(strict_types=1);

use Orchid\Alert\Alert;
use Orchid\Screen\Builder;
use Orchid\Screen\Repository;

if (!function_exists('generate_form')) {
    /**
     * Generate a ready-made html form for display to the user.
     *
     * @param array                 $fields
     * @param array|Repository|null $data
     * @param string|null           $language
     * @param string|null           $prefix
     *
     *@throws \Throwable
     *
     * @return string
     */
    function generate_form(array $fields, $data = [], string $language = null, string $prefix = null)
    {
        if (is_array($data)) {
            $data = new Repository($data);
        }

        return (new Builder($fields, $data))
            ->setLanguage($language)
            ->setPrefix($prefix)
            ->generateForm();
    }
}

if (!function_exists('theme_path')) {
    /**
     * Helper function to send an alert.
     *
     * @param  $img
     * @param string $level
     *
     * @return Alert
     */
    function theme_path($path = '')
    {
        return '/dashboard/resources/press/'.config('press.theme').'/'.$path;
    }
}
