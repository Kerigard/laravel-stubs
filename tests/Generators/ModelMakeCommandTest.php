<?php

namespace Kerigard\LaravelStubs\Tests\Generators;

use Kerigard\LaravelStubs\Tests\TestCase;

class ModelMakeCommandTest extends TestCase
{
    protected array $files = [
        'app/Models/Foo.php',
        'app/Models/Foo/Bar.php',
        'app/Http/Controllers/FooController.php',
        'database/factories/FooFactory.php',
        'database/factories/Foo/BarFactory.php',
        'database/seeders/FooSeeder.php',
        'tests/Feature/Models/FooTest.php',
    ];

    public function test_it_can_generate_model_file(): void
    {
        $this->artisan('make:model', ['name' => 'Foo'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Models;',
            'use Illuminate\Database\Eloquent\Model;',
            'class Foo extends Model',
        ], 'app/Models/Foo.php');

        $this->assertFileDoesNotContains([
            '{{ factoryImport }}',
            'use Illuminate\Database\Eloquent\Factories\HasFactory;',
            '{{ factory }}',
            '/** @use HasFactory<\Database\Factories\FooFactory> */',
            'use HasFactory;',
        ], 'app/Models/Foo.php');

        $this->assertFilenameNotExists('app/Http/Controllers/FooController.php');
        $this->assertFilenameNotExists('database/factories/FooFactory.php');
        $this->assertFilenameNotExists('database/seeders/FooSeeder.php');
        $this->assertFilenameNotExists('tests/Feature/Models/FooTest.php');
    }

    public function test_it_can_generate_model_file_with_pivot_option(): void
    {
        $this->artisan('make:model', ['name' => 'Foo', '--pivot' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Models;',
            'use Illuminate\Database\Eloquent\Relations\Pivot;',
            'class Foo extends Pivot',
        ], 'app/Models/Foo.php');
    }

    public function test_it_can_generate_model_file_with_morph_pivot_option(): void
    {
        $this->artisan('make:model', ['name' => 'Foo', '--morph-pivot' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Models;',
            'use Illuminate\Database\Eloquent\Relations\MorphPivot;',
            'class Foo extends MorphPivot',
        ], 'app/Models/Foo.php');
    }

    public function test_it_can_generate_model_file_with_controller_option(): void
    {
        $this->artisan('make:model', ['name' => 'Foo', '--controller' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Models;',
            'use Illuminate\Database\Eloquent\Model;',
            'class Foo extends Model',
        ], 'app/Models/Foo.php');

        $this->assertFileContains([
            'namespace App\Http\Controllers;',
            'use Illuminate\Http\Request;',
            'class FooController',
        ], 'app/Http/Controllers/FooController.php');

        $this->assertFileNotContains([
            'use App\Models\Foo;',
            'public function index()',
            'public function create()',
            'public function store(Request $request)',
            'public function show(Foo $foo)',
            'public function edit(Foo $foo)',
            'public function update(Request $request, Foo $foo)',
            'public function destroy(Foo $foo)',
        ], 'app/Http/Controllers/FooController.php');

        $this->assertFilenameNotExists('database/factories/FooFactory.php');
        $this->assertFilenameNotExists('database/seeders/FooSeeder.php');
    }

    public function test_it_can_generate_model_file_with_factory_option(): void
    {
        $this->artisan('make:model', ['name' => 'Foo', '--factory' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Models;',
            'use Illuminate\Database\Eloquent\Factories\HasFactory;',
            'use Illuminate\Database\Eloquent\Model;',
            'class Foo extends Model',
            '/** @use HasFactory<\Database\Factories\FooFactory> */',
            'use HasFactory;',
        ], 'app/Models/Foo.php');

        $this->assertFileNotContains([
            '{{ factoryImport }}',
            '{{ factory }}',
        ], 'app/Models/Foo.php');

        $this->assertFileNotContains([
            "Define the model's default state.",
            '@return array<string, mixed>',
        ], 'database/factories/FooFactory.php');

        $this->assertFilenameNotExists('app/Http/Controllers/FooController.php');
        $this->assertFilenameNotExists('database/seeders/FooSeeder.php');
    }

    public function test_it_can_generate_model_file_with_factory_option_for_deep_folder(): void
    {
        $this->artisan('make:model', ['name' => 'Foo/Bar', '--factory' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Models\Foo;',
            'use Illuminate\Database\Eloquent\Factories\HasFactory;',
            'use Illuminate\Database\Eloquent\Model;',
            'class Bar extends Model',
            '/** @use HasFactory<\Database\Factories\Foo\BarFactory> */',
            'use HasFactory;',
        ], 'app/Models/Foo/Bar.php');

        $this->assertFileNotContains([
            '{{ factoryImport }}',
            '{{ factory }}',
        ], 'app/Models/Foo/Bar.php');

        $this->assertFileNotContains([
            "Define the model's default state.",
            '@return array<string, mixed>',
        ], 'database/factories/Foo/BarFactory.php');

        $this->assertFilenameNotExists('app/Http/Controllers/Foo/BarController.php');
        $this->assertFilenameNotExists('database/seeders/Foo/BarSeeder.php');
    }

    public function test_it_can_generate_model_file_with_migration_option(): void
    {
        $this->artisan('make:model', ['name' => 'Foo', '--migration' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Models;',
            'use Illuminate\Database\Eloquent\Model;',
            'class Foo extends Model',
        ], 'app/Models/Foo.php');

        $this->assertMigrationFileContains([
            'use Illuminate\Database\Migrations\Migration;',
            'return new class extends Migration',
            'Schema::create(\'foos\', function (Blueprint $table) {',
            "Schema::dropIfExists('foos');",
        ], 'create_foos_table.php');

        $this->assertMigrationFileDoesNotContains([
            'Run the migrations.',
            'Reverse the migrations.',
        ], 'create_foos_table.php');

        $this->assertFilenameNotExists('app/Http/Controllers/FooController.php');
        $this->assertFilenameNotExists('database/factories/FooFactory.php');
        $this->assertFilenameNotExists('database/seeders/FooSeeder.php');
    }

    public function test_it_can_generate_model_file_with_seeder_option(): void
    {
        $this->artisan('make:model', ['name' => 'Foo', '--seed' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Models;',
            'use Illuminate\Database\Eloquent\Model;',
            'class Foo extends Model',
        ], 'app/Models/Foo.php');

        $this->assertFileNotContains([
            'Run the database seeds.',
        ], 'database/seeders/FooSeeder.php');

        $this->assertFilenameNotExists('app/Http/Controllers/FooController.php');
        $this->assertFilenameNotExists('database/factories/FooFactory.php');
    }

    public function test_it_can_generate_model_file_with_test_option(): void
    {
        $this->artisan('make:model', ['name' => 'Foo', '--test' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Models;',
            'use Illuminate\Database\Eloquent\Model;',
            'class Foo extends Model',
        ], 'app/Models/Foo.php');

        $this->assertFileNotContains([
            'A basic feature test example.',
        ], 'tests/Feature/Models/FooTest.php');

        $this->assertFilenameNotExists('app/Http/Controllers/FooController.php');
        $this->assertFilenameNotExists('database/factories/FooFactory.php');
        $this->assertFilenameNotExists('database/seeders/FooSeeder.php');
    }

    public function test_it_generates_model_with_has_factory_trait_when_using_all_option(): void
    {
        $this->artisan('make:model', ['name' => 'Foo', '--all' => true])
            ->expectsQuestion('A App\Models\Foo model does not exist. Do you want to generate it?', false)
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Models;',
            'use Illuminate\Database\Eloquent\Factories\HasFactory;',
            'use Illuminate\Database\Eloquent\Model;',
            'class Foo extends Model',
            '/** @use HasFactory<\Database\Factories\FooFactory> */',
            'use HasFactory;',
        ], 'app/Models/Foo.php');

        $this->assertFileNotContains([
            '{{ factoryImport }}',
            '{{ factory }}',
        ], 'app/Models/Foo.php');

        $this->assertFilenameExists('app/Http/Controllers/FooController.php');
        $this->assertFilenameExists('database/factories/FooFactory.php');
        $this->assertFilenameExists('database/seeders/FooSeeder.php');
        $this->assertMigrationFileExists('create_foos_table.php');
    }
}
