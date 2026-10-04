<?php

namespace Kerigard\LaravelStubs\Tests\Generators;

use Kerigard\LaravelStubs\Tests\TestCase;

class ComponentMakeCommandTest extends TestCase
{
    protected array $files = [
        'app/View/Components/Foo.php',
        'resources/views/components/foo.blade.php',
        'tests/Feature/View/Components/FooTest.php',
        'resources/views/custom/path/foo.blade.php',
        'app/View/Components/Nested/Foo.php',
        'resources/views/components/nested/foo.blade.php',
        'tests/Feature/View/Components/Nested/FooTest.php',
    ];

    public function test_it_can_generate_component_file(): void
    {
        $this->artisan('make:component', ['name' => 'Foo'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\View\Components;',
            'use Illuminate\View\Component;',
            'class Foo extends Component',
            "return view('components.foo');",
        ], 'app/View/Components/Foo.php');

        $this->assertFileNotContains([
            'Create a new component instance.',
            'Get the view / contents that represent the component.',
        ], 'app/View/Components/Foo.php');

        $this->assertFilenameExists('resources/views/components/foo.blade.php');
        $this->assertFilenameNotExists('tests/Feature/View/Components/FooTest.php');
    }

    public function test_it_can_generate_inline_component_file(): void
    {
        $this->artisan('make:component', ['name' => 'Foo', '--inline' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\View\Components;',
            'use Illuminate\View\Component;',
            'class Foo extends Component',
            "return <<<'blade'",
        ], 'app/View/Components/Foo.php');

        $this->assertFileNotContains([
            'Create a new component instance.',
            'Get the view / contents that represent the component.',
        ], 'app/View/Components/Foo.php');

        $this->assertFilenameNotExists('resources/views/components/foo.blade.php');
    }

    public function test_it_can_generate_component_file_with_custom_path(): void
    {
        $this->artisan('make:component', ['name' => 'Foo', '--path' => 'custom/path'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\View\Components;',
            'use Illuminate\View\Component;',
            'class Foo extends Component',
            "return view('custom.path.foo');",
        ], 'app/View/Components/Foo.php');

        $this->assertFileNotContains([
            'Create a new component instance.',
            'Get the view / contents that represent the component.',
        ], 'app/View/Components/Foo.php');

        $this->assertFilenameExists('resources/views/custom/path/foo.blade.php');
        $this->assertFilenameNotExists('tests/Feature/View/Components/FooTest.php');
    }

    public function test_it_can_generate_nested_component_file(): void
    {
        $this->artisan('make:component', ['name' => 'Nested/Foo'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\View\Components\Nested;',
            'use Illuminate\View\Component;',
            'class Foo extends Component',
            "return view('components.nested.foo');",
        ], 'app/View/Components/Nested/Foo.php');

        $this->assertFileNotContains([
            'Create a new component instance.',
            'Get the view / contents that represent the component.',
        ], 'app/View/Components/Nested/Foo.php');

        $this->assertFilenameExists('resources/views/components/nested/foo.blade.php');
        $this->assertFilenameNotExists('tests/Feature/View/Components/Nested/FooTest.php');
    }

    public function test_it_can_generate_nested_component_file_with_custom_path(): void
    {
        $this->artisan('make:component', ['name' => 'Nested/Foo', '--path' => 'custom/path'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\View\Components\Nested;',
            'use Illuminate\View\Component;',
            'class Foo extends Component',
            "return view('custom.path.foo');",
        ], 'app/View/Components/Nested/Foo.php');

        $this->assertFileNotContains([
            'Create a new component instance.',
            'Get the view / contents that represent the component.',
        ], 'app/View/Components/Nested/Foo.php');

        $this->assertFilenameExists('resources/views/custom/path/foo.blade.php');
        $this->assertFilenameNotExists('tests/Feature/View/Components/Nested/FooTest.php');
    }

    public function test_it_can_generate_component_file_with_test(): void
    {
        $this->artisan('make:component', ['name' => 'Foo', '--test' => true])
            ->assertExitCode(0);

        $this->assertFileNotContains([
            'Create a new component instance.',
            'Get the view / contents that represent the component.',
        ], 'app/View/Components/Foo.php');

        $this->assertFileNotContains([
            'A basic feature test example.',
        ], 'tests/Feature/View/Components/FooTest.php');

        $this->assertFilenameExists('resources/views/components/foo.blade.php');
    }
}
