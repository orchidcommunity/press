<?php

declare(strict_types=1);

namespace Orchid\Press\Entities;

use Illuminate\Contracts\Routing\UrlRoutable;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Select;

abstract class Single implements EntityContract, UrlRoutable
{
    use Structure, Actions;

    /**
     * Registered fields for main.
     *
     * @throws \Throwable
     *
     * @return array
     */
    public function main(): array
    {
        return [
            DateTimer::make('publish_at')
                ->title(__('Time of Publication')),

            Select::make('status')
                ->options($this->status())
                ->title(__('Status')),
        ];
    }
}
