<?php

namespace Kerigard\LaravelStubs\Tests\Generators;

use Kerigard\LaravelStubs\Tests\TestCase;

class InterfaceMakeCommandTest extends TestCase
{
    protected array $files = [
        'app/Gateway.php',
    ];

    public function test_it_can_generate_interface_file(): void
    {
        $this->artisan('make:interface', ['name' => 'Gateway'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App;',
            'interface Gateway',
        ], 'app/Gateway.php');
    }
}
