<?php

namespace Kerigard\LaravelStubs\Console;

class ViewMakeCommand extends \Illuminate\Foundation\Console\ViewMakeCommand
{
    protected function getTestStub(): string
    {
        $stubName = 'view.'.($this->usingPest() ? 'pest' : 'test').'.stub';

        return file_exists($customPath = $this->laravel->basePath("stubs/{$stubName}"))
            ? $customPath
            : __DIR__."/../../stubs/{$stubName}";
    }
}
