<?php

namespace Kerigard\LaravelStubs;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Foundation\Console\StubPublishCommand as IlluminateStubPublishCommand;
use Illuminate\Foundation\Console\ViewMakeCommand as IlluminateViewMakeCommand;
use Illuminate\Support\ServiceProvider;
use Kerigard\LaravelStubs\Console\StubPublishCommand;
use Kerigard\LaravelStubs\Console\ViewMakeCommand;

class StubsServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * @var list<class-string>
     */
    protected array $commands = [
        StubPublishCommand::class,
        ViewMakeCommand::class,
    ];

    public function register(): void
    {
        $this->app->singleton(IlluminateStubPublishCommand::class, StubPublishCommand::class);
        $this->app->singleton(IlluminateViewMakeCommand::class, ViewMakeCommand::class);

        Stubs::resolveUsing($this->app);
    }

    /**
     * @return list<class-string>
     */
    public function provides(): array
    {
        return $this->commands;
    }
}
