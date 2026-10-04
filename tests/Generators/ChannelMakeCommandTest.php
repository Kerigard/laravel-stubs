<?php

namespace Kerigard\LaravelStubs\Tests\Generators;

use Kerigard\LaravelStubs\Tests\TestCase;

class ChannelMakeCommandTest extends TestCase
{
    protected array $files = [
        'app/Broadcasting/FooChannel.php',
    ];

    public function test_it_can_generate_channel_file(): void
    {
        $this->artisan('make:channel', ['name' => 'FooChannel'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Broadcasting;',
            'use Illuminate\Foundation\Auth\User;',
            'class FooChannel',
            '@return array<array-key, mixed>|bool',
        ], 'app/Broadcasting/FooChannel.php');

        $this->assertFileNotContains([
            'Create a new channel instance.',
            "Authenticate the user's access to the channel.",
        ], 'app/Broadcasting/FooChannel.php');
    }
}
