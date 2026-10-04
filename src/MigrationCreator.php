<?php

namespace Kerigard\LaravelStubs;

class MigrationCreator extends \Illuminate\Database\Migrations\MigrationCreator
{
    public function stubPath(): string
    {
        return __DIR__.'/../stubs';
    }
}
