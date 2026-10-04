<?php

namespace Kerigard\LaravelStubs\Tests\Generators;

use Kerigard\LaravelStubs\Tests\TestCase;

class SeederMakeCommandTest extends TestCase
{
    protected array $files = [
        'database/seeders/FooSeeder.php',
    ];

    public function test_it_can_generate_seeder_file(): void
    {
        $this->artisan('make:seeder', ['name' => 'FooSeeder'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace Database\Seeders;',
            'use Illuminate\Database\Seeder;',
            'class FooSeeder extends Seeder',
            'public function run(): void',
        ], 'database/seeders/FooSeeder.php');

        $this->assertFileNotContains([
            'Run the database seeds.',
        ], 'database/seeders/FooSeeder.php');
    }
}
