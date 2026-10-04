<?php

namespace Kerigard\LaravelStubs\Tests\Generators;

use Kerigard\LaravelStubs\Tests\TestCase;

class MigrationMakeCommandTest extends TestCase
{
    public function test_it_can_generate_migration_file(): void
    {
        $this->artisan('make:migration', ['name' => 'AddBarToFoosTable'])
            ->assertExitCode(0);

        $this->assertMigrationFileContains([
            'use Illuminate\Database\Migrations\Migration;',
            'return new class extends Migration',
            'Schema::table(\'foos\', function (Blueprint $table) {',
        ], 'add_bar_to_foos_table.php');

        $this->assertMigrationFileDoesNotContains([
            'Run the migrations.',
            'Reverse the migrations.',
        ], 'add_bar_to_foos_table.php');
    }

    public function test_it_can_generate_migration_file_with_table_option(): void
    {
        $this->artisan('make:migration', ['name' => 'AddBarToFoosTable', '--table' => 'foobar'])
            ->assertExitCode(0);

        $this->assertMigrationFileContains([
            'use Illuminate\Database\Migrations\Migration;',
            'return new class extends Migration',
            'Schema::table(\'foobar\', function (Blueprint $table) {',
        ], 'add_bar_to_foos_table.php');

        $this->assertMigrationFileDoesNotContains([
            'Run the migrations.',
            'Reverse the migrations.',
        ], 'add_bar_to_foos_table.php');
    }

    public function test_it_can_generate_migration_file_using_create_keyword(): void
    {
        $this->artisan('make:migration', ['name' => 'CreateFoosTable'])
            ->assertExitCode(0);

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
    }

    public function test_it_can_generate_migration_file_using_create_option(): void
    {
        $this->artisan('make:migration', ['name' => 'FoosTable', '--create' => 'foobar'])
            ->assertExitCode(0);

        $this->assertMigrationFileContains([
            'use Illuminate\Database\Migrations\Migration;',
            'return new class extends Migration',
            'Schema::create(\'foobar\', function (Blueprint $table) {',
            "Schema::dropIfExists('foobar');",
        ], 'foos_table.php');

        $this->assertMigrationFileDoesNotContains([
            'Run the migrations.',
            'Reverse the migrations.',
        ], 'foos_table.php');
    }

    public function test_it_can_generate_empty_migration_file(): void
    {
        $this->artisan('make:migration', ['name' => 'FooMigration'])
            ->assertExitCode(0);

        $this->assertMigrationFileContains([
            'use Illuminate\Database\Migrations\Migration;',
            'return new class extends Migration',
        ], 'foo_migration.php');

        $this->assertMigrationFileDoesNotContains([
            'Run the migrations.',
            'Reverse the migrations.',
            'Schema::',
        ], 'foo_migration.php');
    }
}
