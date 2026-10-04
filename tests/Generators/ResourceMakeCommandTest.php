<?php

namespace Kerigard\LaravelStubs\Tests\Generators;

use Kerigard\LaravelStubs\Tests\TestCase;

class ResourceMakeCommandTest extends TestCase
{
    protected array $files = [
        'app/Http/Resources/FooResource.php',
        'app/Http/Resources/FooResourceCollection.php',
    ];

    public function test_it_can_generate_resource_file(): void
    {
        $this->artisan('make:resource', ['name' => 'FooResource'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Http\Resources;',
            'use Illuminate\Http\Resources\Json\JsonResource;',
            'class FooResource extends JsonResource',
        ], 'app/Http/Resources/FooResource.php');

        $this->assertFileNotContains([
            'Transform the resource into an array.',
        ], 'app/Http/Resources/FooResource.php');
    }

    public function test_it_can_generate_resource_collection_file(): void
    {
        $this->artisan('make:resource', ['name' => 'FooResourceCollection', '--collection' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Http\Resources;',
            'use Illuminate\Http\Resources\Json\ResourceCollection;',
            'class FooResourceCollection extends ResourceCollection',
        ], 'app/Http/Resources/FooResourceCollection.php');

        $this->assertFileNotContains([
            'Transform the resource collection into an array.',
        ], 'app/Http/Resources/FooResourceCollection.php');
    }

    public function test_it_can_generate_json_api_resource_file(): void
    {
        $this->artisan('make:resource', ['name' => 'FooResource', '--json-api' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Http\Resources;',
            'use Illuminate\Http\Resources\JsonApi\JsonApiResource;',
            'class FooResource extends JsonApiResource',
            '@var array<array-key, string>',
            'public array $attributes',
            'public array $relationships',
        ], 'app/Http/Resources/FooResource.php');

        $this->assertFileNotContains([
            'use Illuminate\Http\Request;',
            "The resource's attributes.",
            "The resource's relationships.",
        ], 'app/Http/Resources/FooResource.php');
    }
}
