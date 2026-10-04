<?php

namespace Kerigard\LaravelStubs\Tests\Generators;

use Kerigard\LaravelStubs\Tests\TestCase;

class ListenerMakeCommandTest extends TestCase
{
    protected array $files = [
        'app/Listeners/FooListener.php',
        'tests/Feature/Listeners/FooListenerTest.php',
    ];

    public function test_it_can_generate_listener_file(): void
    {
        $this->artisan('make:listener', ['name' => 'FooListener'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Listeners;',
            'use Illuminate\Contracts\Queue\ShouldQueue;',
            'use Illuminate\Queue\InteractsWithQueue;',
            'class FooListener',
            'public function handle(object $event): void',
        ], 'app/Listeners/FooListener.php');

        $this->assertFileNotContains([
            'class FooListener implements ShouldQueue',
            'Create the event listener.',
            'Handle the event.',
        ], 'app/Listeners/FooListener.php');
    }

    public function test_it_can_generate_listener_file_for_event(): void
    {
        $this->artisan('make:listener', ['name' => 'FooListener', '--event' => 'FooListenerCreated'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Listeners;',
            'use App\Events\FooListenerCreated;',
            'use Illuminate\Contracts\Queue\ShouldQueue;',
            'use Illuminate\Queue\InteractsWithQueue;',
            'class FooListener',
            'public function handle(FooListenerCreated $event): void',
        ], 'app/Listeners/FooListener.php');

        $this->assertFileNotContains([
            'Create the event listener.',
            'Handle the event.',
        ], 'app/Listeners/FooListener.php');
    }

    public function test_it_can_generate_listener_file_for_illuminate_event(): void
    {
        $this->artisan('make:listener', ['name' => 'FooListener', '--event' => \Illuminate\Auth\Events\Login::class])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Listeners;',
            'use Illuminate\Auth\Events\Login;',
            'use Illuminate\Contracts\Queue\ShouldQueue;',
            'use Illuminate\Queue\InteractsWithQueue;',
            'class FooListener',
            'public function handle(Login $event): void',
        ], 'app/Listeners/FooListener.php');

        $this->assertFileNotContains([
            'Create the event listener.',
            'Handle the event.',
        ], 'app/Listeners/FooListener.php');
    }

    public function test_it_can_generate_queued_listener_file(): void
    {
        $this->artisan('make:listener', ['name' => 'FooListener', '--queued' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Listeners;',
            'use Illuminate\Contracts\Queue\ShouldQueue;',
            'use Illuminate\Queue\InteractsWithQueue;',
            'class FooListener implements ShouldQueue',
            'public function handle(object $event): void',
        ], 'app/Listeners/FooListener.php');

        $this->assertFileNotContains([
            'Create the event listener.',
            'Handle the event.',
        ], 'app/Listeners/FooListener.php');
    }

    public function test_it_can_generate_queued_listener_file_for_illuminate_event(): void
    {
        $this->artisan('make:listener', [
            'name' => 'FooListener',
            '--event' => \Illuminate\Auth\Events\Login::class,
            '--queued' => true,
        ])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Listeners;',
            'use Illuminate\Auth\Events\Login;',
            'use Illuminate\Contracts\Queue\ShouldQueue;',
            'use Illuminate\Queue\InteractsWithQueue;',
            'class FooListener implements ShouldQueue',
            'public function handle(Login $event): void',
        ], 'app/Listeners/FooListener.php');

        $this->assertFileNotContains([
            'Create the event listener.',
            'Handle the event.',
        ], 'app/Listeners/FooListener.php');
    }

    public function test_it_can_generate_listener_file_with_test(): void
    {
        $this->artisan('make:listener', ['name' => 'FooListener', '--test' => true])
            ->assertExitCode(0);

        $this->assertFileNotContains([
            'A basic feature test example.',
        ], 'tests/Feature/Listeners/FooListenerTest.php');

        $this->assertFilenameExists('app/Listeners/FooListener.php');
    }
}
