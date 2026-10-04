<?php

namespace Kerigard\LaravelStubs\Tests\Generators;

use Kerigard\LaravelStubs\Tests\TestCase;

class RequestMakeCommandTest extends TestCase
{
    protected array $files = [
        'app/Http/Requests/FooRequest.php',
    ];

    public function test_it_can_generate_request_file(): void
    {
        $this->artisan('make:request', ['name' => 'FooRequest'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Http\Requests;',
            'use Illuminate\Foundation\Http\FormRequest;',
            'class FooRequest extends FormRequest',
        ], 'app/Http/Requests/FooRequest.php');

        $this->assertFileNotContains([
            'Determine if the user is authorized to make this request.',
            'Get the validation rules that apply to the request.',
            'public function authorize()',
        ], 'app/Http/Requests/FooRequest.php');
    }
}
