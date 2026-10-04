<?php

namespace Kerigard\LaravelStubs\Tests\Generators;

use Kerigard\LaravelStubs\Tests\TestCase;

class ClassMakeCommandTest extends TestCase
{
    protected array $files = [
        'app/Reverb.php',
        'app/Notification.php',
    ];

    public function test_it_can_generate_class_file(): void
    {
        $this->artisan('make:class', ['name' => 'Reverb'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App;',
            'class Reverb',
            'public function __construct()',
        ], 'app/Reverb.php');

        $this->assertFileNotContains([
            'Create a new class instance.',
        ], 'app/Reverb.php');
    }

    public function test_it_can_generate_invokable_class_file(): void
    {
        $this->artisan('make:class', ['name' => 'Notification', '--invokable' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App;',
            'class Notification',
            'public function __construct()',
            'public function __invoke()',
        ], 'app/Notification.php');

        $this->assertFileNotContains([
            'Create a new class instance.',
            'Invoke the class instance.',
        ], 'app/Notification.php');
    }
}
