<?php

namespace Kerigard\LaravelStubs\Tests\Generators;

use Kerigard\LaravelStubs\Tests\TestCase;

class ObserverMakeCommandTest extends TestCase
{
    protected array $files = [
        'app/Observers/FooObserver.php',
    ];

    public function test_it_can_generate_observer_file(): void
    {
        $this->artisan('make:observer', ['name' => 'FooObserver'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Observers;',
            'class FooObserver',
        ], 'app/Observers/FooObserver.php');
    }

    public function test_it_can_generate_observer_file_with_model(): void
    {
        $this->artisan('make:observer', ['name' => 'FooObserver', '--model' => 'Foo'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Observers;',
            'use App\Models\Foo;',
            'class FooObserver',
            'public function created(Foo $foo)',
            'public function updated(Foo $foo)',
            'public function deleted(Foo $foo)',
            'public function restored(Foo $foo)',
            'public function forceDeleted(Foo $foo)',
        ], 'app/Observers/FooObserver.php');

        $this->assertFileNotContains([
            'Handle the Foo "created" event.',
            'Handle the Foo "updated" event.',
            'Handle the Foo "deleted" event.',
            'Handle the Foo "restored" event.',
            'Handle the Foo "force deleted" event.',
        ], 'app/Observers/FooObserver.php');
    }
}
