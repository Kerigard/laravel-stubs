<?php

namespace Kerigard\LaravelStubs\Console;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Foundation\Events\PublishingStubs;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use SplFileInfo;

class StubPublishCommand extends \Illuminate\Foundation\Console\StubPublishCommand
{
    public function handle(): void
    {
        if ($this->option('laravel')) {
            parent::handle();

            return;
        }

        File::ensureDirectoryExists($stubsPath = $this->laravel->basePath('stubs'));

        $stubs = Arr::mapWithKeys(
            File::allFiles(__DIR__.'/../../stubs'),
            fn (SplFileInfo $file) => [$file->getRealPath() => $file->getFilename()]
        );

        /** @var Dispatcher */
        $events = $this->laravel->get('events');
        $events->dispatch($event = new PublishingStubs($stubs));

        foreach ($event->stubs as $from => $to) {
            $to = $stubsPath.DIRECTORY_SEPARATOR.ltrim($to, DIRECTORY_SEPARATOR);

            if (
                (! $this->option('existing') && (! file_exists($to) || $this->option('force'))) ||
                ($this->option('existing') && file_exists($to))
            ) {
                file_put_contents($to, file_get_contents($from));
            }
        }

        $this->components->info('Stubs published successfully.');
    }

    protected function configure(): void
    {
        $this->addOption('laravel', null, null, 'Publish original Laravel framework stubs');
    }
}
