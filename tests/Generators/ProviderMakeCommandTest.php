<?php

namespace Kerigard\LaravelStubs\Tests\Generators;

use Kerigard\LaravelStubs\Tests\TestCase;

class ProviderMakeCommandTest extends TestCase
{
    protected array $files = [
        'app/Providers/FooServiceProvider.php',
    ];

    public function test_it_can_generate_service_provider_file(): void
    {
        $this->artisan('make:provider', ['name' => 'FooServiceProvider'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Providers;',
            'use Illuminate\Support\ServiceProvider;',
            'class FooServiceProvider extends ServiceProvider',
            'public function register(): void',
            'public function boot(): void',
        ], 'app/Providers/FooServiceProvider.php');

        $this->assertFileNotContains([
            'Register services.',
            'Bootstrap services.',
        ], 'app/Providers/FooServiceProvider.php');

        $this->assertEquals([
            'App\Providers\FooServiceProvider',
        ], require $this->app->getBootstrapProvidersPath());
    }
}
