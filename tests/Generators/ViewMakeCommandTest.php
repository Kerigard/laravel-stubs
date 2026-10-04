<?php

namespace Kerigard\LaravelStubs\Tests\Generators;

use Kerigard\LaravelStubs\Tests\TestCase;

class ViewMakeCommandTest extends TestCase
{
    protected array $files = [
        'resources/views/foo.blade.php',
        'tests/Feature/View/FooTest.php',
    ];

    public function test_it_can_generate_view_file(): void
    {
        $this->artisan('make:view', ['name' => 'foo'])
            ->assertExitCode(0);

        $this->assertFileContains([
            '<div>',
            '</div>',
        ], 'resources/views/foo.blade.php');
    }

    public function test_it_can_generate_view_file_with_phpunit_test(): void
    {
        $this->artisan('make:view', ['name' => 'foo', '--test' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            '<div>',
            '</div>',
        ], 'resources/views/foo.blade.php');

        $this->assertFileContains([
            'class FooTest extends TestCase',
            "view('foo', [",
        ], 'tests/Feature/View/FooTest.php');

        $this->assertFileNotContains([
            'A basic view test example.',
        ], 'tests/Feature/View/FooTest.php');
    }
}
