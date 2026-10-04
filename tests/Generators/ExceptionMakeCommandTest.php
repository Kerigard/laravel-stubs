<?php

namespace Kerigard\LaravelStubs\Tests\Generators;

use Kerigard\LaravelStubs\Tests\TestCase;

class ExceptionMakeCommandTest extends TestCase
{
    protected array $files = [
        'app/Exceptions/FooException.php',
    ];

    public function test_it_can_generate_exception_file(): void
    {
        $this->artisan('make:exception', ['name' => 'FooException'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Exceptions;',
            'use Exception;',
            'class FooException extends Exception',
        ], 'app/Exceptions/FooException.php');

        $this->assertFileNotContains([
            'public function report()',
            'public function render($request)',
        ], 'app/Exceptions/FooException.php');
    }

    public function test_it_can_generate_exception_file_with_report_option(): void
    {
        $this->artisan('make:exception', ['name' => 'FooException', '--report' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Exceptions;',
            'use Exception;',
            'class FooException extends Exception',
            'public function report(): void',
        ], 'app/Exceptions/FooException.php');

        $this->assertFileNotContains([
            'Report the exception.',
            'public function render($request)',
        ], 'app/Exceptions/FooException.php');
    }

    public function test_it_can_generate_exception_file_with_render_option(): void
    {
        $this->artisan('make:exception', ['name' => 'FooException', '--render' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Exceptions;',
            'use Exception;',
            'class FooException extends Exception',
            'public function render(Request $request): Response',
        ], 'app/Exceptions/FooException.php');

        $this->assertFileNotContains([
            'Render the exception as an HTTP response.',
            'public function report()',
        ], 'app/Exceptions/FooException.php');
    }

    public function test_it_can_generate_exception_file_with_report_and_render_option(): void
    {
        $this->artisan('make:exception', ['name' => 'FooException', '--render' => true, '--report' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Exceptions;',
            'use Exception;',
            'class FooException extends Exception',
            'public function render(Request $request): Response',
            'public function report(): void',
        ], 'app/Exceptions/FooException.php');

        $this->assertFileNotContains([
            'Report the exception.',
            'Render the exception as an HTTP response.',
        ], 'app/Exceptions/FooException.php');
    }
}
