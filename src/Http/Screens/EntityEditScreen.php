<?php

declare(strict_types=1);

namespace Orchid\Press\Http\Screens;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Press\Entities\EntityContract;
use Orchid\Press\Entities\Many;
use Orchid\Press\Models\Post;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

class EntityEditScreen extends Screen
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
     * @var EntityContract
     */
    protected $entity;

    /**
     * @var bool
     */
    protected $exist = false;

    protected $locales = false;

    /**
     * Query data.
     *
     * @param EntityContract $type
     * @param Post           $post
     *
     * @return array
     */
    public function query(EntityContract $type, Post $post): array
    {
        $this->name = $type->name;
        $this->description = $type->description;
        $this->entity = $type;
        $this->exist = $post->exists;
        $this->locales = collect($type->locale());

        $this->checkPermission(Post::POST_PERMISSION_PREFIX.$type->slug);

        return [
            'locales' => collect($type->locale()),
            'type'    => $type,
            'post'    => $type->create($post),
        ];
    }

    /**
     * @return array
     */
    public function commandBar(): array
    {
        return [
            Button::make(__('Create'))
                ->icon('icon-check')
                ->method('save')
                ->canSee(!$this->exist),

            Button::make(__('Remove'))
                ->icon('icon-trash')
                ->method('destroy')
                ->canSee($this->exist && is_a($this->entity, Many::class)),

            Button::make(__('Save'))
                ->icon('icon-check')
                ->method('save')
                ->canSee($this->exist),
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
            Layout::view('press::container.posts.edit'),
        ];
    }

    /**
     * @param EntityContract $type
     * @param Post           $post
     * @param Request        $request
     *
     * @throws \Illuminate\Validation\ValidationException
     *
     * @return RedirectResponse
     */
    public function save(EntityContract $type, Post $post, Request $request): RedirectResponse
    {
        $this->checkPermission(Post::POST_PERMISSION_PREFIX.$type->slug);
        $type->isValid();

        $post->fill($request->all())->fill([
            'type'    => $type->slug,
            'user_id' => $request->user()->id,
            'options' => $post->getOptions(),
        ]);

        $type->save($post);

        Alert::success(__('Operation completed successfully.'));

        $route = is_a($type, Many::class)
            ? 'platform.entities.type.edit'
            : 'platform.entities.type.page';

        return redirect()->route($route, [$post->type, $post->slug]);
    }

    /**
     * @param EntityContract $type
     * @param Post           $post
     *
     * @throws \Exception
     *
     * @return RedirectResponse
     *
     * @internal param Request $request
     * @internal param Post $type
     */
    public function destroy(EntityContract $type, Post $post): RedirectResponse
    {
        $this->checkPermission(Post::POST_PERMISSION_PREFIX.$type->slug);

        $type->delete($post);

        Alert::success(__('Operation completed successfully.'));

        return redirect()->route('platform.entities.type', [
            'type' => $type->slug,
        ])->with([
            'restore' => route('platform.entities.type', [
                'type' => $type->slug,
                $post->id,
                'restore',
            ]),
        ]);
    }
}
