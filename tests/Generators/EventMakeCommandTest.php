<?php

namespace Kerigard\LaravelStubs\Tests\Generators;

use Kerigard\LaravelStubs\Tests\TestCase;

class EventMakeCommandTest extends TestCase
{
    protected array $files = [
        'app/Events/FooCreated.php',
    ];

    public function test_it_can_generate_event_file(): void
    {
        $this->artisan('make:event', ['name' => 'FooCreated'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Events;',
            'class FooCreated',
            'use InteractsWithSockets;',
            'use SerializesModels;',
        ], 'app/Events/FooCreated.php');

        $this->assertFileNotContains([
            'use Illuminate\Foundation\Events\Dispatchable;',
            'Create a new event instance.',
            'Get the channels the event should broadcast on.',
        ], 'app/Events/FooCreated.php');
    }
}
