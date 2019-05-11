<?php

declare(strict_types=1);

namespace Orchid\Tests\Console;

use Orchid\Tests\TestConsoleCase;
use Illuminate\Support\Facades\File;

class ArtisanTest extends TestConsoleCase
{
    /**
     * debug: php vendor/bin/phpunit  --filter= ArtisanTest tests\\Feature\\ArtisanTest --debug.
     *
     * @var
     */
    public function testArtisanOrchidEntityMany()
    {
        $this->artisan('orchid:entity-many', ['name' => $this->generateNameFromMethod()])
            ->expectsOutput('Behavior created successfully.')
            ->assertExitCode(0);
    }

    public function testArtisanOrchidEntitySingle()
    {
        $this->artisan('orchid:entity-single', ['name' => $this->generateNameFromMethod()])
            ->expectsOutput('Behavior created successfully.')
            ->assertExitCode(0);
    }
}
