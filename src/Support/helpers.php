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


if (!function_exists('phone_number')) {
    /**
     * Helper function to send an alert.
     *
     * @param  $img
     * @param string $level
     *
     * @return Alert
     */

    function phone_number($phone, $variant = 1)
    {
        $phone = trim($phone);

        if ($variant==2) {
            return preg_replace(
                array(
                    '/[\+]?([7|8])[-|\s]?\([-|\s]?(\d{3})[-|\s]?\)[-|\s]?(\d{3})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
                    '/[\+]?([7|8])[-|\s]?(\d{3})[-|\s]?(\d{3})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
                    '/[\+]?([7|8])[-|\s]?\([-|\s]?(\d{4})[-|\s]?\)[-|\s]?(\d{2})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
                    '/[\+]?([7|8])[-|\s]?(\d{4})[-|\s]?(\d{2})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
                    '/[\+]?([7|8])[-|\s]?\([-|\s]?(\d{4})[-|\s]?\)[-|\s]?(\d{3})[-|\s]?(\d{3})/',
                    '/[\+]?([7|8])[-|\s]?(\d{4})[-|\s]?(\d{3})[-|\s]?(\d{3})/',
                ),
                array(
                    '+7 $2 $3-$4-$5',
                    '+7 $2 $3-$4-$5',
                    '+7 $2 $3-$4-$5',
                    '+7 $2 $3-$4-$5',
                    '+7 $2 $3-$4',
                    '+7 $2 $3-$4',
                ),
                $phone
            );
        }

        return preg_replace(
            array(
                '/[\+]?([7|8])[-|\s]?\([-|\s]?(\d{4})[-|\s]?\)[-|\s]?(\d{2})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
                '/[\+]?([7|8])[-|\s]?(\d{4})[-|\s]?(\d{2})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
                '/[\+]?([7|8])[-|\s]?\([-|\s]?(\d{4})[-|\s]?\)[-|\s]?(\d{2})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
                '/[\+]?([7|8])[-|\s]?(\d{4})[-|\s]?(\d{2})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
                '/[\+]?([7|8])[-|\s]?\([-|\s]?(\d{4})[-|\s]?\)[-|\s]?(\d{3})[-|\s]?(\d{3})/',
                '/[\+]?([7|8])[-|\s]?(\d{4})[-|\s]?(\d{3})[-|\s]?(\d{3})/',
            ),
            array(
                '+7 ($2) $3-$4-$5',
                '+7 ($2) $3-$4-$5',
                '+7 ($2) $3-$4-$5',
                '+7 ($2) $3-$4-$5',
                '+7 ($2) $3-$4',
                '+7 ($2) $3-$4',
            ),
            $phone
        );

    }

}