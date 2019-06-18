<?php

declare(strict_types=1);

namespace Orchid\Press\Screen;

use Orchid\Screen\TD as BaseTD;

class TD extends BaseTD
{
    /**
     * @param string|null $text
     *
     * @return TD
     */
    public function linkPost(string $text = null): self
    {
        return $this->link('platform.entities.type.edit', ['type', 'slug'], $text);
    }

    /**
     * @param string|null $column
     *
     * @return TD
     */
    public function column(string $column = null): self
    {
        if (!is_null($column)) {
            $this->column = $column;
        }

        if ($this->locale && !is_null($column)) {
            $locale = '.'.app()->getLocale().'.';
            $this->column = preg_replace('/'.preg_quote('.', '/').'/', $locale, $column);
        }

        return $this;
    }
}
