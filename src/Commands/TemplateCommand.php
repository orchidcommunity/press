<?php

declare(strict_types=1);

namespace Orchid\Press\Commands;

use Orchid\Platform\Dashboard;
use Illuminate\Console\Command;
use Orchid\Press\Providers\PressServiceProvider;

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
        $this->setValueEnv('PRESS_TEMPLATE','clean-blog');

        $this->call('vendor:publish', [
            '--provider' => PressServiceProvider::class,
            '--force'    => true,
            ]);
    }

    /**
     * @param string $constant
     * @param string $value
     *
     * @return \Orchid\Platform\Commands\InstallCommand
     */
    private function setValueEnv($constant, $value = 'null'): self
    {
        $str = $this->fileGetContent(app_path('../.env'));

        if ($str !== false && strpos($str, $constant) === false) {
            file_put_contents(app_path('../.env'), $str.PHP_EOL.$constant.'='.$value.PHP_EOL);
        }

        return $this;
    }

    /**
     * @param string $file
     *
     * @return false|string
     */
    private function fileGetContent(string $file)
    {
        if (! is_file($file)) {
            return '';
        }

        return file_get_contents($file);
    }
}