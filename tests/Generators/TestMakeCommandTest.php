<?php

namespace Kerigard\LaravelStubs\Tests\Generators;

use Kerigard\LaravelStubs\Tests\TestCase;

class TestMakeCommandTest extends TestCase
{
    protected array $files = [
        'tests/Feature/FooTest.php',
        'tests/Unit/FooTest.php',
    ];

    public function test_it_can_generate_feature_test(): void
    {
        $this->artisan('make:test', ['name' => 'FooTest'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace Tests\Feature;',
            'use Illuminate\Foundation\Testing\RefreshDatabase;',
            'use Illuminate\Foundation\Testing\WithFaker;',
            'use Tests\TestCase;',
            'class FooTest extends TestCase',
        ], 'tests/Feature/FooTest.php');

        $this->assertFileNotContains([
            'A basic feature test example.',
        ], 'tests/Feature/FooTest.php');
    }

    public function test_it_can_generate_unit_test(): void
    {
        $this->artisan('make:test', ['name' => 'FooTest', '--unit' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace Tests\Unit;',
            'use PHPUnit\Framework\TestCase;',
            'class FooTest extends TestCase',
        ], 'tests/Unit/FooTest.php');

        $this->assertFileNotContains([
            'A basic unit test example.',
        ], 'tests/Unit/FooTest.php');
    }

    public function test_it_can_generate_feature_test_using_pest(): void
    {
        $this->artisan('make:test', ['name' => 'FooTest', '--pest' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            "test('example', function () {",
            '$response = $this->get(\'/\');',
            '$response->assertStatus(200);',
        ], 'tests/Feature/FooTest.php');
    }

    public function test_it_can_generate_unit_test_using_pest(): void
    {
        $this->artisan('make:test', ['name' => 'FooTest', '--unit' => true, '--pest' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            "test('example', function () {",
            'expect(true)->toBeTrue();',
        ], 'tests/Unit/FooTest.php');
    }
}
