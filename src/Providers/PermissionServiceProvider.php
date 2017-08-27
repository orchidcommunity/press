<?php

namespace Orchid\CMS\Providers;

use Illuminate\Support\ServiceProvider;
use Orchid\Platform\Kernel\Dashboard;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * @var
     */
    protected $dashboard;

    /**
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard)
    {
        $this->dashboard = $dashboard;

        $dashboard->permission->registerPermissions($this->registerPermissionsMain());
        $dashboard->permission->registerPermissions($this->registerPermissionsPages());
        $dashboard->permission->registerPermissions($this->registerPermissionsPost());
        $dashboard->permission->registerPermissions($this->registerPermissionsTools());
        $dashboard->permission->registerPermissions($this->registerPermissionsSystems());
        $dashboard->permission->registerPermissions($this->registerPermissionsMarketing());
    }

    /**
     * @return array
     */
    protected function registerPermissionsMain(): array
    {
        return [
            'Main' => [
                [
                    'slug'        => 'dashboard.index',
                    'description' => trans('cms::permission.main.main'),
                ],
                [
                    'slug'        => 'dashboard.pages',
                    'description' => trans('cms::permission.main.pages'),
                ],
                [
                    'slug'        => 'dashboard.posts',
                    'description' => trans('cms::permission.main.posts'),
                ],
                [
                    'slug'        => 'dashboard.tools',
                    'description' => trans('cms::permission.main.tools'),
                ],
                [
                    'slug'        => 'dashboard.marketing',
                    'description' => trans('cms::permission.main.marketing'),
                ],
            ],

        ];
    }

    /**
     * @return array
     */
    protected function registerPermissionsPages(): array
    {
        $allPage = $this->dashboard->getStorage('pages')->all();

        $showPost = collect();
        foreach ($allPage as $page) {
            $showPost->push([
                'slug'        => 'dashboard.posts.type.' . $page->slug,
                'description' => $page->name,
            ]);
        }

        return [
            'Pages' => $showPost->toArray(),
        ];
    }

    /**
     * @return array
     */
    protected function registerPermissionsPost(): array
    {
        $allPost = $this->dashboard->getStorage('posts')->all();

        $showPost = collect();
        foreach ($allPost as $page) {
            if ($page->display) {
                $showPost->push([
                    'slug'        => 'dashboard.posts.type.' . $page->slug,
                    'description' => $page->name,
                ]);
            }
        }

        return [
            'Posts' => $showPost->toArray(),
        ];
    }

    /**
     * @return array
     */
    protected function registerPermissionsTools(): array
    {
        return [
            'Tools' => [
                [
                    'slug'        => 'dashboard.tools.menu',
                    'description' => trans('cms::permission.tools.menu'),
                ],
                [
                    'slug'        => 'dashboard.tools.category',
                    'description' => trans('cms::permission.tools.category'),
                ],
                [
                    'slug'        => 'dashboard.tools.attachment',
                    'description' => trans('cms::permission.tools.attachment'),
                ],
                [
                    'slug'        => 'dashboard.tools.media',
                    'description' => trans('cms::permission.tools.media'),
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    protected function registerPermissionsSystems(): array
    {
        return [
            'Systems' => [
                [
                    'slug'        => 'superuser',
                    'description' => trans('cms::permission.systems.superuser'),
                ],
                [
                    'slug'        => 'dashboard.systems.backup',
                    'description' => trans('cms::permission.systems.backup'),
                ],
                [
                    'slug'        => 'dashboard.systems.defender',
                    'description' => trans('cms::permission.systems.defender'),
                ],
                [
                    'slug'        => 'dashboard.systems.monitor',
                    'description' => trans('cms::permission.systems.monitor'),
                ],
                [
                    'slug'        => 'dashboard.systems.logs',
                    'description' => trans('cms::permission.systems.logs'),
                ],
                [
                    'slug'        => 'dashboard.systems.schema',
                    'description' => trans('cms::permission.systems.schema'),
                ],
                [
                    'slug'        => 'dashboard.systems.settings',
                    'description' => trans('cms::permission.systems.settings'),
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    protected function registerPermissionsMarketing(): array
    {
        return [

            'Marketing' => [
                [
                    'slug'        => 'dashboard.marketing.comment',
                    'description' => trans('cms::permission.marketing.comment'),
                ],
                [
                    'slug'        => 'dashboard.marketing.advertising',
                    'description' => trans('cms::permission.marketing.advertising'),
                ],
                [
                    'slug'        => 'dashboard.marketing.utm',
                    'description' => trans('cms::permission.marketing.utm'),
                ],
                [
                    'slug'        => 'dashboard.marketing.robots',
                    'description' => trans('cms::permission.marketing.robots'),
                ],
            ],

        ];
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
