<?php

namespace Kerigard\LaravelStubs\Tests\Generators;

use Kerigard\LaravelStubs\Tests\TestCase;

class FactoryMakeCommandTest extends TestCase
{
    protected array $files = [
        'database/factories/FooFactory.php',
    ];

    public function test_it_can_generate_factory_file(): void
    {
        $this->artisan('make:factory', ['name' => 'FooFactory'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace Database\Factories;',
            'use Illuminate\Database\Eloquent\Factories\Factory;',
            'class FooFactory extends Factory',
            'public function definition()',
        ], 'database/factories/FooFactory.php');

        $this->assertFileNotContains([
            "Define the model's default state.",
            '@return array<string, mixed>',
        ], 'database/factories/FooFactory.php');
    }
}
