<?php

namespace Kerigard\LaravelStubs\Tests\Generators;

use Kerigard\LaravelStubs\Tests\TestCase;

class ConsoleMakeCommandTest extends TestCase
{
    protected array $files = [
        'app/Console/Commands/FooCommand.php',
    ];

    public function test_it_can_generate_console_file(): void
    {
        $this->artisan('make:command', ['name' => 'FooCommand'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Console\Commands;',
            'use Illuminate\Console\Attributes\Description;',
            'use Illuminate\Console\Attributes\Signature;',
            'use Illuminate\Console\Command;',
            "#[Signature('app:foo-command')]",
            "#[Description('Command description')]",
            'class FooCommand extends Command',
        ], 'app/Console/Commands/FooCommand.php');

        $this->assertFileNotContains([
            'Execute the console command.',
        ], 'app/Console/Commands/FooCommand.php');
    }

    public function test_it_can_generate_console_file_with_command_option(): void
    {
        $this->artisan('make:command', ['name' => 'FooCommand', '--command' => 'foo:bar'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Console\Commands;',
            'use Illuminate\Console\Attributes\Description;',
            'use Illuminate\Console\Attributes\Signature;',
            'use Illuminate\Console\Command;',
            "#[Signature('foo:bar')]",
            "#[Description('Command description')]",
            'class FooCommand extends Command',
        ], 'app/Console/Commands/FooCommand.php');

        $this->assertFileNotContains([
            'Execute the console command.',
        ], 'app/Console/Commands/FooCommand.php');
    }
}
