<?php

namespace Kerigard\LaravelStubs\Tests\Generators;

use Kerigard\LaravelStubs\Tests\TestCase;

class EnumMakeCommandTest extends TestCase
{
    protected array $files = [
        'app/IntEnum.php',
        'app/StatusEnum.php',
        'app/StringEnum.php',
    ];

    public function test_it_can_generate_enum_file(): void
    {
        $this->artisan('make:enum', ['name' => 'StatusEnum'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App;',
            'enum StatusEnum',
        ], 'app/StatusEnum.php');
    }

    public function test_it_can_generate_enum_file_with_string(): void
    {
        $this->artisan('make:enum', ['name' => 'StringEnum', '--string' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App;',
            'enum StringEnum: string',
        ], 'app/StringEnum.php');
    }

    public function test_it_can_generate_enum_file_with_int(): void
    {
        $this->artisan('make:enum', ['name' => 'IntEnum', '--int' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App;',
            'enum IntEnum: int',
        ], 'app/IntEnum.php');
    }
}
