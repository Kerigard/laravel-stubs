<?php

namespace Kerigard\LaravelStubs\Tests\Generators;

use Kerigard\LaravelStubs\Tests\TestCase;

class RuleMakeCommandTest extends TestCase
{
    protected array $files = [
        'app/Rules/Foo.php',
    ];

    public function test_it_can_generate_rule_file(): void
    {
        $this->artisan('make:rule', ['name' => 'Foo'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Rules;',
            'use Illuminate\Contracts\Validation\ValidationRule;',
            'class Foo implements ValidationRule',
        ], 'app/Rules/Foo.php');

        $this->assertFileNotContains([
            'use Illuminate\Translation\PotentiallyTranslatedString;',
            'Run the validation rule.',
            '@param  Closure(string, ?string=): PotentiallyTranslatedString  $fail',
        ], 'app/Rules/Foo.php');
    }

    public function test_it_can_generate_implicit_rule_file(): void
    {
        $this->artisan('make:rule', ['name' => 'Foo', '--implicit' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Rules;',
            'use Illuminate\Contracts\Validation\ValidationRule;',
            'class Foo implements ValidationRule',
            'public bool $implicit = true;',
            'public function validate(string $attribute, mixed $value, Closure $fail): void',
        ], 'app/Rules/Foo.php');

        $this->assertFileNotContains([
            'use Illuminate\Translation\PotentiallyTranslatedString;',
            'Indicates whether the rule should be implicit.',
            'Run the validation rule.',
            '@param  Closure(string, ?string=): PotentiallyTranslatedString  $fail',
        ], 'app/Rules/Foo.php');
    }
}
