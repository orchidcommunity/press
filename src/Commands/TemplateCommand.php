<?php

declare(strict_types=1);

namespace Orchid\Press\Commands;

use Orchid\Platform\Dashboard;
use Illuminate\Console\Command;
use Orchid\Press\Providers\WebServiceProvider;

class TemplateCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'orchid:template';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copy route and view to app';

    /**
     * Execute the console command.
     *
     * @param \Orchid\Platform\Dashboard $dashboard
     *
     * @return void
     */
    public function handle(Dashboard $dashboard)
    {
        //$this->call($command, $parameters);
        $this->call('vendor:publish', [
            '--provider' => WebServiceProvider::class,
            ]);
    }

}