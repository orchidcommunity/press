<?php

declare(strict_types=1);

namespace Orchid\Tests\Console;

use Orchid\Tests\TestConsoleCase;

class ArtisanTest extends TestConsoleCase
{
    public function testArtisanOrchidEntityMany(): void
    {
        $this->artisan('orchid:entity-many', ['name' => $this->generateNameFromMethod()])
            ->expectsOutput('Behavior created successfully.')
            ->assertExitCode(0);
    }

    public function testArtisanOrchidEntitySingle(): void
    {
        $this->artisan('orchid:entity-single', ['name' => $this->generateNameFromMethod()])
            ->expectsOutput('Behavior created successfully.')
            ->assertExitCode(0);
    }
}
