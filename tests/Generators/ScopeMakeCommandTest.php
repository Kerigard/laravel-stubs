<?php

namespace Kerigard\LaravelStubs\Tests\Generators;

use Kerigard\LaravelStubs\Tests\TestCase;

class ScopeMakeCommandTest extends TestCase
{
    protected array $files = [
        'app/Models/Scopes/Foo.php',
    ];

    public function test_it_can_generate_scope_file(): void
    {
        $this->artisan('make:scope', ['name' => 'Foo'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Models\Scopes;',
            'use Illuminate\Database\Eloquent\Builder;',
            'use Illuminate\Database\Eloquent\Model;',
            'use Illuminate\Database\Eloquent\Scope;',
            '@implements Scope<Model>',
            'class Foo implements Scope',
            'public function apply(Builder $builder, Model $model): void',
        ], 'app/Models/Scopes/Foo.php');

        $this->assertFileNotContains([
            'Apply the scope to a given Eloquent query builder.',
        ], 'app/Models/Scopes/Foo.php');
    }
}
