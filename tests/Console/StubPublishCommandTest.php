<?php

namespace Kerigard\LaravelStubs\Tests\Console;

use Kerigard\LaravelStubs\Tests\TestCase;

class StubPublishCommandTest extends TestCase
{
    private const int LARAVEL_STUB_COUNT = 54;

    protected array $files = [
        'stubs/*',
    ];

    public function test_it_publishes_every_package_stub(): void
    {
        $this->artisan('stub:publish')
            ->assertExitCode(0);

        $expectedStubNames = $this->stubNames(__DIR__.'/../../stubs');
        $publishedStubNames = $this->stubNames($this->app->basePath('stubs'));

        $this->assertCount(count($expectedStubNames), $publishedStubNames);
        $this->assertSame($expectedStubNames, $publishedStubNames);

        $this->assertFileContains([
            'namespace {{ namespace }};',
            'use Illuminate\Http\Resources\Json\JsonResource;',
            'class {{ class }} extends JsonResource',
        ], 'stubs/resource.stub');

        $this->assertFileNotContains([
            'Transform the resource into an array.',
        ], 'stubs/resource.stub');
    }

    public function test_it_publishes_original_laravel_stubs(): void
    {
        $this->artisan('stub:publish', ['--laravel' => true])
            ->assertExitCode(0);

        $publishedStubNames = $this->stubNames($this->app->basePath('stubs'));

        $this->assertCount(self::LARAVEL_STUB_COUNT, $publishedStubNames);

        $this->assertFileContains([
            'namespace {{ namespace }};',
            'use Illuminate\Http\Resources\Json\JsonResource;',
            'class {{ class }} extends JsonResource',
            'Transform the resource into an array.',
        ], 'stubs/resource.stub');
    }

    /**
     * @return list<string>
     */
    protected function stubNames(string $directory): array
    {
        $files = glob($directory.DIRECTORY_SEPARATOR.'*') ?: [];
        $names = array_map(basename(...), $files);
        sort($names);

        return $names;
    }
}
