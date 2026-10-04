<?php

namespace Kerigard\LaravelStubs\Tests;

use Kerigard\LaravelStubs\StubsServiceProvider;
use Orchestra\Testbench\Concerns\InteractsWithPublishedFiles;

class TestCase extends \Orchestra\Testbench\TestCase
{
    use InteractsWithPublishedFiles;

    /**
     * @var list<string>
     */
    protected array $files = [];

    /**
     * @return list<class-string>
     */
    protected function getPackageProviders($app): array
    {
        return [StubsServiceProvider::class];
    }
}
