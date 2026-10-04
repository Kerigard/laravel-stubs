<?php

namespace Kerigard\LaravelStubs\Tests\Generators;

use Kerigard\LaravelStubs\Tests\TestCase;

class ControllerMakeCommandTest extends TestCase
{
    protected array $files = [
        'app/Http/Controllers/Controller.php',
        'app/Http/Controllers/FooController.php',
        'app/Models/Bar.php',
        'app/Models/Foo.php',
        'tests/Feature/Http/Controllers/FooControllerTest.php',
    ];

    public function test_it_can_generate_controller_file(): void
    {
        $this->artisan('make:controller', ['name' => 'FooController'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Http\Controllers;',
            'use Illuminate\Http\Request;',
            'class FooController',
        ], 'app/Http/Controllers/FooController.php');

        $this->assertFileNotContains([
            'class FooController extends Controller',
            'public function __invoke(Request $request)',
        ], 'app/Http/Controllers/FooController.php');

        $this->assertFilenameNotExists('tests/Feature/Http/Controllers/FooControllerTest.php');
    }

    public function test_it_can_generate_controller_file_when_base_controller_exists(): void
    {
        $this->artisan('make:controller', ['name' => 'Controller'])
            ->assertExitCode(0);

        $this->artisan('make:controller', ['name' => 'FooController'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Http\Controllers;',
            'use Illuminate\Http\Request;',
            'class Controller',
        ], 'app/Http/Controllers/Controller.php');

        $this->assertFileContains([
            'namespace App\Http\Controllers;',
            'use Illuminate\Http\Request;',
            'class FooController extends Controller',
        ], 'app/Http/Controllers/FooController.php');

        $this->assertFilenameNotExists('tests/Feature/Http/Controllers/FooControllerTest.php');
    }

    public function test_it_can_generate_controller_file_with_invokable_type_option(): void
    {
        $this->artisan('make:controller', ['name' => 'FooController', '--type' => 'invokable'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Http\Controllers;',
            'use Illuminate\Http\Request;',
            'class FooController',
            'public function __invoke(Request $request)',
        ], 'app/Http/Controllers/FooController.php');

        $this->assertFileNotContains([
            'Handle the incoming request.',
        ], 'app/Http/Controllers/FooController.php');
    }

    public function test_it_can_generate_controller_file_with_invokable_option(): void
    {
        $this->artisan('make:controller', ['name' => 'FooController', '--invokable' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Http\Controllers;',
            'use Illuminate\Http\Request;',
            'class FooController',
            'public function __invoke(Request $request)',
        ], 'app/Http/Controllers/FooController.php');

        $this->assertFileNotContains([
            'Handle the incoming request.',
        ], 'app/Http/Controllers/FooController.php');
    }

    public function test_it_can_generate_controller_file_with_model_option(): void
    {
        $this->artisan('make:controller', ['name' => 'FooController', '--model' => 'Foo'])
            ->expectsQuestion('A App\Models\Foo model does not exist. Do you want to generate it?', false)
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Http\Controllers;',
            'use App\Models\Foo;',
            'public function index()',
            'public function create()',
            'public function store(Request $request)',
            'public function show(Foo $foo)',
            'public function edit(Foo $foo)',
            'public function update(Request $request, Foo $foo)',
            'public function destroy(Foo $foo)',
        ], 'app/Http/Controllers/FooController.php');

        $this->assertFileNotContains([
            'Display a listing of the resource.',
            'Show the form for creating a new resource.',
            'Store a newly created resource in storage.',
            'Display the specified resource.',
            'Show the form for editing the specified resource.',
            'Update the specified resource in storage.',
            'Remove the specified resource from storage.',
        ], 'app/Http/Controllers/FooController.php');
    }

    public function test_it_can_generate_controller_file_with_model_and_parent_option(): void
    {
        $this->artisan('make:controller', ['name' => 'FooController', '--model' => 'Bar', '--parent' => 'Foo'])
            ->expectsQuestion('A App\Models\Foo model does not exist. Do you want to generate it?', false)
            ->expectsQuestion('A App\Models\Bar model does not exist. Do you want to generate it?', false)
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Http\Controllers;',
            'use App\Models\Bar;',
            'use App\Models\Foo;',
            'public function index(Foo $foo)',
            'public function create(Foo $foo)',
            'public function store(Request $request, Foo $foo)',
            'public function show(Foo $foo, Bar $bar)',
            'public function edit(Foo $foo, Bar $bar)',
            'public function update(Request $request, Foo $foo, Bar $bar)',
            'public function destroy(Foo $foo, Bar $bar)',
        ], 'app/Http/Controllers/FooController.php');

        $this->assertFileNotContains([
            'Display a listing of the resource.',
            'Show the form for creating a new resource.',
            'Store a newly created resource in storage.',
            'Display the specified resource.',
            'Show the form for editing the specified resource.',
            'Update the specified resource in storage.',
            'Remove the specified resource from storage.',
        ], 'app/Http/Controllers/FooController.php');
    }

    public function test_it_can_generate_controller_file_with_api_option(): void
    {
        $this->artisan('make:controller', ['name' => 'FooController', '--api' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Http\Controllers;',
            'use Illuminate\Http\Request;',
            'class FooController',
            'public function index()',
            'public function store(Request $request)',
            'public function update(Request $request, string $id)',
            'public function destroy(string $id)',
        ], 'app/Http/Controllers/FooController.php');

        $this->assertFileNotContains([
            'Display a listing of the resource.',
            'Store a newly created resource in storage.',
            'Display the specified resource.',
            'Update the specified resource in storage.',
            'Remove the specified resource from storage.',
            'public function create()',
            'public function edit($id)',
        ], 'app/Http/Controllers/FooController.php');
    }

    public function test_it_can_generate_controller_file_with_invokable_ignores_api_option(): void
    {
        $this->artisan('make:controller', ['name' => 'FooController', '--api' => true, '--invokable' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Http\Controllers;',
            'use Illuminate\Http\Request;',
            'class FooController',
            'public function __invoke(Request $request)',
        ], 'app/Http/Controllers/FooController.php');

        $this->assertFileNotContains([
            'Handle the incoming request.',
            'public function index()',
            'public function store(Request $request)',
            'public function update(Request $request, $id)',
            'public function destroy($id)',
        ], 'app/Http/Controllers/FooController.php');
    }

    public function test_it_can_generate_controller_file_with_api_and_model_option(): void
    {
        $this->artisan('make:controller', ['name' => 'FooController', '--model' => 'Foo', '--api' => true])
            ->expectsQuestion('A App\Models\Foo model does not exist. Do you want to generate it?', false)
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Http\Controllers;',
            'use App\Models\Foo;',
            'public function index()',
            'public function store(Request $request)',
            'public function show(Foo $foo)',
            'public function update(Request $request, Foo $foo)',
            'public function destroy(Foo $foo)',
        ], 'app/Http/Controllers/FooController.php');

        $this->assertFileNotContains([
            'Display a listing of the resource.',
            'Store a newly created resource in storage.',
            'Display the specified resource.',
            'Update the specified resource in storage.',
            'Remove the specified resource from storage.',
            'public function create()',
            'public function edit(Foo $foo)',
        ], 'app/Http/Controllers/FooController.php');
    }

    public function test_it_can_generate_nested_api_controller_file(): void
    {
        $this->artisan('make:controller', [
            'name' => 'FooController',
            '--model' => 'Bar',
            '--parent' => 'Foo',
            '--api' => true,
        ])
            ->expectsQuestion('A App\Models\Foo model does not exist. Do you want to generate it?', false)
            ->expectsQuestion('A App\Models\Bar model does not exist. Do you want to generate it?', false)
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Http\Controllers;',
            'use App\Models\Bar;',
            'use App\Models\Foo;',
            'public function index(Foo $foo)',
            'public function store(Request $request, Foo $foo)',
            'public function show(Foo $foo, Bar $bar)',
            'public function update(Request $request, Foo $foo, Bar $bar)',
            'public function destroy(Foo $foo, Bar $bar)',
        ], 'app/Http/Controllers/FooController.php');

        $this->assertFileNotContains([
            'Display a listing of the resource.',
            'Store a newly created resource in storage.',
            'Display the specified resource.',
            'Update the specified resource in storage.',
            'Remove the specified resource from storage.',
            'public function create()',
            'public function edit(Foo $foo)',
        ], 'app/Http/Controllers/FooController.php');
    }

    public function test_it_can_generate_controller_file_with_resource_option(): void
    {
        $this->artisan('make:controller', ['name' => 'FooController', '--resource' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Http\Controllers;',
            'public function index()',
            'public function create()',
            'public function store(Request $request)',
            'public function show(string $id)',
            'public function edit(string $id)',
            'public function update(Request $request, string $id)',
            'public function destroy(string $id)',
        ], 'app/Http/Controllers/FooController.php');

        $this->assertFileNotContains([
            'Display a listing of the resource.',
            'Show the form for creating a new resource.',
            'Store a newly created resource in storage.',
            'Display the specified resource.',
            'Show the form for editing the specified resource.',
            'Update the specified resource in storage.',
            'Remove the specified resource from storage.',
        ], 'app/Http/Controllers/FooController.php');
    }

    public function test_it_can_generate_singleton_controller_file(): void
    {
        $this->artisan('make:controller', ['name' => 'FooController', '--singleton' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Http\Controllers;',
            'class FooController',
            'public function create(): never',
            'public function store(Request $request): never',
            'public function show()',
            'public function edit()',
            'public function update(Request $request)',
            'public function destroy(): never',
        ], 'app/Http/Controllers/FooController.php');

        $this->assertFileNotContains([
            'Show the form for creating the resource.',
            'Store the newly created resource in storage.',
            'Display the resource.',
            'Show the form for editing the resource.',
            'Update the resource in storage.',
            'Remove the resource from storage.',
        ], 'app/Http/Controllers/FooController.php');
    }

    public function test_it_can_generate_singleton_api_controller_file(): void
    {
        $this->artisan('make:controller', ['name' => 'FooController', '--singleton' => true, '--api' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Http\Controllers;',
            'public function store(Request $request): never',
            'public function show()',
            'public function update(Request $request)',
            'public function destroy(): never',
        ], 'app/Http/Controllers/FooController.php');

        $this->assertFileNotContains([
            'Store the newly created resource in storage.',
            'Display the resource.',
            'Update the resource in storage.',
            'Remove the resource from storage.',
            'public function create(): never',
            'public function edit()',
        ], 'app/Http/Controllers/FooController.php');
    }

    public function test_it_can_generate_nested_singleton_controller_file(): void
    {
        $this->artisan('make:controller', [
            'name' => 'FooController',
            '--model' => 'Bar',
            '--parent' => 'Foo',
            '--singleton' => true,
        ])
            ->expectsQuestion('A App\Models\Foo model does not exist. Do you want to generate it?', false)
            ->expectsQuestion('A App\Models\Bar model does not exist. Do you want to generate it?', false)
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Http\Controllers;',
            'use App\Models\Bar;',
            'use App\Models\Foo;',
            'public function create(Foo $foo): never',
            'public function store(Request $request, Foo $foo): never',
            'public function show(Foo $foo)',
            'public function edit(Foo $foo)',
            'public function update(Request $request, Foo $foo)',
            'public function destroy(Foo $foo): never',
        ], 'app/Http/Controllers/FooController.php');

        $this->assertFileNotContains([
            'Show the form for creating the new resource.',
            'Store the newly created resource in storage.',
            'Display the resource.',
            'Show the form for editing the resource.',
            'Update the resource in storage.',
            'Remove the resource from storage.',
        ], 'app/Http/Controllers/FooController.php');
    }

    public function test_it_can_generate_nested_singleton_api_controller_file(): void
    {
        $this->artisan('make:controller', [
            'name' => 'FooController',
            '--model' => 'Bar',
            '--parent' => 'Foo',
            '--singleton' => true,
            '--api' => true,
        ])
            ->expectsQuestion('A App\Models\Foo model does not exist. Do you want to generate it?', false)
            ->expectsQuestion('A App\Models\Bar model does not exist. Do you want to generate it?', false)
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Http\Controllers;',
            'use App\Models\Bar;',
            'use App\Models\Foo;',
            'public function store(Request $request, Foo $foo): never',
            'public function show(Foo $foo)',
            'public function update(Request $request, Foo $foo)',
            'public function destroy(Foo $foo): never',
        ], 'app/Http/Controllers/FooController.php');

        $this->assertFileNotContains([
            'Store the newly created resource in storage.',
            'Display the resource.',
            'Update the resource in storage.',
            'Remove the resource from storage.',
            'public function create(Foo $foo): never',
            'public function edit(Foo $foo)',
        ], 'app/Http/Controllers/FooController.php');
    }

    public function test_it_can_generate_controller_file_with_test(): void
    {
        $this->artisan('make:controller', ['name' => 'FooController', '--test' => true])
            ->assertExitCode(0);

        $this->assertFileNotContains([
            'A basic feature test example.',
        ], 'tests/Feature/Http/Controllers/FooControllerTest.php');

        $this->assertFilenameExists('app/Http/Controllers/FooController.php');
    }
}
