<?php

namespace Kerigard\LaravelStubs;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Filesystem\Filesystem;
use ReflectionClass;

class Stubs
{
    public static function resolveUsing(Application $app): void
    {
        $app->resolving(GeneratorCommand::class, function (GeneratorCommand $command, Application $app) {
            $reflection = new ReflectionClass($command);

            if ($reflection->hasProperty('files')) {
                $property = $reflection->getProperty('files');
                $property->setValue($command, static::getFilesystem($app));
            }
        });

        $app->singleton(
            'migration.creator',
            fn (Application $app) => new MigrationCreator($app['files'], $app->basePath('stubs'))
        );
    }

    protected static function getFilesystem(Application $app): Filesystem
    {
        $basePath = $app->basePath('stubs');
        $customPath = static::getStubsPath();

        return new class($basePath, $customPath) extends Filesystem
        {
            public function __construct(protected string $basePath, protected string $customPath) {}

            public function get($path, $lock = false): string
            {
                if (str_ends_with($path, '.stub')) {
                    $basename = basename($path);
                    $basePath = "{$this->basePath}/{$basename}";
                    $customPath = "{$this->customPath}/{$basename}";

                    if ($path !== $basePath && $this->exists($customPath)) {
                        $path = $customPath;
                    }
                }

                return parent::get($path, $lock);
            }
        };
    }

    protected static function getStubsPath(): string
    {
        return __DIR__.'/../stubs';
    }
}
