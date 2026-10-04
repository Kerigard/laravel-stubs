<?php

namespace Kerigard\LaravelStubs\Tests\Generators;

use Kerigard\LaravelStubs\Tests\TestCase;

class JobMiddlewareMakeCommandTest extends TestCase
{
    protected array $files = [
        'app/Jobs/Middleware/Foo.php',
        'tests/Feature/Jobs/Middleware/FooTest.php',
    ];

    public function test_it_can_generate_job_file(): void
    {
        $this->artisan('make:job-middleware', ['name' => 'Foo'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Jobs\Middleware;',
            'class Foo',
        ], 'app/Jobs/Middleware/Foo.php');

        $this->assertFileNotContains([
            'Process the queued job.',
        ], 'app/Jobs/Middleware/Foo.php');

        $this->assertFilenameNotExists('tests/Feature/Jobs/Middleware/FooTest.php');
    }

    public function test_it_can_generate_job_file_with_test(): void
    {
        $this->artisan('make:job-middleware', ['name' => 'Foo', '--test' => true])
            ->assertExitCode(0);

        $this->assertFileNotContains([
            'A basic feature test example.',
        ], 'tests/Feature/Jobs/Middleware/FooTest.php');

        $this->assertFilenameExists('app/Jobs/Middleware/Foo.php');
    }
}
