<?php

declare(strict_types=1);

namespace Orchid\Press\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Menu extends Model
{
    /**
     * @var string
     */
    protected $table = 'menu';

    /**
     * @var array
     */
    protected $fillable = [
        'label',
        'title',
        'slug',
        'robot',
        'style',
        'target',
        'auth',
        'lang',
        'parent',
        'type',
        'sort',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'type'   => 'string',
        'parent' => 'integer',
        'sort'   => 'integer',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(static::class, 'parent')->orderBy('sort');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function parent(): HasOne
    {
        return $this->hasOne(static::class, 'id', 'parent');
    }

    /**
     * @return string
     */
    public function getRoute() :string
    {
        if ((strpos($this->slug, ',') > 0) && (is_array($routearray = explode(',', $this->slug)))) {
            $routearray = array_filter($routearray, function ($element) {
                return !empty($element);
            });
            $path = route(array_shift($routearray), $routearray ?? []);
        } else {
            $path = url($this->slug);
        }

        return $path;
    }
}
