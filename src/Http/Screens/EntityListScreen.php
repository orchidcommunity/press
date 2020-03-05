<?php

declare(strict_types=1);

namespace Orchid\Press\Http\Screens;

use Illuminate\Http\RedirectResponse;
use Orchid\Press\Entities\EntityContract;
use Orchid\Press\Entities\Many;
use Orchid\Press\Http\Layouts\EntitiesLayout;
use Orchid\Press\Http\Layouts\EntitiesSelection;
use Orchid\Press\Models\Post;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

class EntityListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name;

    /**
     * Display header description.
     *
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $permission;

    /**
     * @var array
     */
    protected $grid = [];

    /**
     * @var array
     */
    protected $filters = [];

    /**
     * @var Many
     */
    protected $entity;

    /**
     * Query data.
     *
     * @param Many $type
     *
     * @return array
     */
    public function query(Many $type): array
    {
        $this->name = $type->name;
        $this->description = $type->description;
        $this->entity = $type;

        $this->checkPermission(Post::POST_PERMISSION_PREFIX.$type->slug);

        $this->grid = $type->grid();
        $this->filters = $type->filters();

        return [
            'data' => $type->get(),
        ];
    }

    /**
     * @return array
     */
    public function commandBar(): array
    {
        return [
            Link::make(__('Create'))
                ->icon('icon-check')
                ->href(route('platform.entities.type.create', $this->entity->slug)),
        ];
    }

    /**
     * Views.
     *
     * @return array
     */
    public function layout(): array
    {
        return [
            Layout::view('press::container.posts.restore'),
            new EntitiesSelection($this->filters),
            new EntitiesLayout($this->grid),
        ];
    }

    /**
     * @param EntityContract $type
     * @param int            $id
     *
     * @return RedirectResponse
     */
    public function restore(EntityContract $type, int $id): RedirectResponse
    {
        Post::onlyTrashed()->findOrFail($id)->restore();

        Alert::success(__('Operation completed successfully.'));

        return redirect()->route('platform.entities.type', [
            'type' => $type->slug,
        ]);
    }
}
