<?php

namespace Kerigard\LaravelStubs\Tests\Generators;

use Kerigard\LaravelStubs\Tests\TestCase;

class TraitMakeCommandTest extends TestCase
{
    protected array $files = [
        'app/FooTrait.php',
    ];

    public function test_it_can_generate_trait_file(): void
    {
        $this->artisan('make:trait', ['name' => 'FooTrait'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App;',
            'trait FooTrait',
        ], 'app/FooTrait.php');
    }
}
