<?php

namespace Kerigard\LaravelStubs\Tests\Generators;

use Kerigard\LaravelStubs\Tests\TestCase;

class MiddlewareMakeCommandTest extends TestCase
{
    protected array $files = [
        'app/Http/Middleware/Foo.php',
        'tests/Feature/Http/Middleware/FooTest.php',
    ];

    public function test_it_can_generate_middleware_file(): void
    {
        $this->artisan('make:middleware', ['name' => 'Foo'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Http\Middleware;',
            'use Closure;',
            'use Illuminate\Http\Request;',
            'class Foo',
            'public function handle(Request $request, Closure $next): Response',
            'return $next($request);',
        ], 'app/Http/Middleware/Foo.php');

        $this->assertFileNotContains([
            'Handle an incoming request.',
        ], 'app/Http/Middleware/Foo.php');

        $this->assertFilenameNotExists('tests/Feature/Http/Middleware/FooTest.php');
    }

    public function test_it_can_generate_middleware_file_with_test(): void
    {
        $this->artisan('make:middleware', ['name' => 'Foo', '--test' => true])
            ->assertExitCode(0);

        $this->assertFileNotContains([
            'A basic feature test example.',
        ], 'tests/Feature/Http/Middleware/FooTest.php');

        $this->assertFilenameExists('app/Http/Middleware/Foo.php');
    }
}
