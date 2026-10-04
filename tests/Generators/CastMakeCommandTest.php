<?php

namespace Kerigard\LaravelStubs\Tests\Generators;

use Kerigard\LaravelStubs\Tests\TestCase;

class CastMakeCommandTest extends TestCase
{
    protected array $files = [
        'app/Casts/Foo.php',
    ];

    public function test_it_can_generate_cast_file(): void
    {
        $this->artisan('make:cast', ['name' => 'Foo'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Casts;',
            'use Illuminate\Contracts\Database\Eloquent\CastsAttributes;',
            'class Foo implements CastsAttributes',
            'public function get(Model $model, string $key, mixed $value, array $attributes): mixed',
            'public function set(Model $model, string $key, mixed $value, array $attributes): mixed',
            '@implements CastsAttributes<mixed, mixed>',
        ], 'app/Casts/Foo.php');

        $this->assertFileNotContains([
            'Cast the given value.',
            'Prepare the given value for storage.',
            '@param  array<string, mixed>  $attributes',
        ], 'app/Casts/Foo.php');
    }

    public function test_it_can_generate_inbound_cast_file(): void
    {
        $this->artisan('make:cast', ['name' => 'Foo', '--inbound' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Casts;',
            'use Illuminate\Contracts\Database\Eloquent\CastsInboundAttributes;',
            'class Foo implements CastsInboundAttributes',
            'public function set(Model $model, string $key, mixed $value, array $attributes): mixed',
        ], 'app/Casts/Foo.php');

        $this->assertFileNotContains([
            'Prepare the given value for storage.',
            '@param  array<string, mixed>  $attributes',
        ], 'app/Casts/Foo.php');
    }
}
