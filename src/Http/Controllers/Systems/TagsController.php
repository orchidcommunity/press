<?php

declare(strict_types=1);

namespace Orchid\Press\Http\Controllers\Systems;

use Orchid\Platform\Http\Controllers\Controller;
use Orchid\Press\Models\Tag;

/**
 * Class TagsController.
 */
class TagsController extends Controller
{
    /**
     * @param string $tag
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $tag)
    {
        $tags = Tag::latest('count')
            ->where('name', 'like', '%'.$tag.'%')
            ->limit(10)
            ->get()
            ->map(function ($item) {
                return [
                    'id'    => $item['name'],
                    'text'  => $item['name'],
                    'count' => $item['count'],
                ];
            })
            ->toArray();

        return response()->json($tags);
    }
}
