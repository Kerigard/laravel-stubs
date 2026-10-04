<?php

namespace Kerigard\LaravelStubs\Tests\Generators;

use Kerigard\LaravelStubs\Tests\TestCase;

class JobMakeCommandTest extends TestCase
{
    protected array $files = [
        'app/Jobs/FooCreated.php',
        'tests/Feature/Jobs/FooCreatedTest.php',
    ];

    public function test_it_can_generate_job_file(): void
    {
        $this->artisan('make:job', ['name' => 'FooCreated'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Jobs;',
            'use Illuminate\Contracts\Queue\ShouldQueue;',
            'use Illuminate\Foundation\Queue\Queueable;',
            'class FooCreated implements ShouldQueue',
            'use Queueable;',
        ], 'app/Jobs/FooCreated.php');

        $this->assertFileNotContains([
            'Create a new job instance.',
            'Execute the job.',
        ], 'app/Jobs/FooCreated.php');

        $this->assertFilenameNotExists('tests/Feature/Jobs/FooCreatedTest.php');
    }

    public function test_it_can_generate_sync_job_file(): void
    {
        $this->artisan('make:job', ['name' => 'FooCreated', '--sync' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Jobs;',
            'class FooCreated',
            'public function handle(): void',
        ], 'app/Jobs/FooCreated.php');

        $this->assertFileNotContains([
            'use Illuminate\Foundation\Bus\Dispatchable;',
            'use Dispatchable;',
            'Create a new job instance.',
            'Execute the job.',
        ], 'app/Jobs/FooCreated.php');
    }

    public function test_it_can_generate_batched_queued_job_file(): void
    {
        $this->artisan('make:job', ['name' => 'FooCreated', '--batched' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Jobs;',
            'use Illuminate\Bus\Batchable;',
            'use Illuminate\Contracts\Queue\ShouldQueue;',
            'use Illuminate\Foundation\Queue\Queueable;',
            'class FooCreated implements ShouldQueue',
            'use Batchable;',
            'use Queueable;',
            'if ($this->batch()?->cancelled())',
        ], 'app/Jobs/FooCreated.php');

        $this->assertFileNotContains([
            'Create a new job instance.',
            'Execute the job.',
            'The batch has been cancelled...',
        ], 'app/Jobs/FooCreated.php');
    }

    public function test_it_can_generate_job_file_with_test(): void
    {
        $this->artisan('make:job', ['name' => 'FooCreated', '--test' => true])
            ->assertExitCode(0);

        $this->assertFileNotContains([
            'A basic feature test example.',
        ], 'tests/Feature/Jobs/FooCreatedTest.php');

        $this->assertFilenameExists('app/Jobs/FooCreated.php');
    }
}
