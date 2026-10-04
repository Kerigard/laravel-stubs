<?php

namespace Kerigard\LaravelStubs\Tests\Generators;

use Kerigard\LaravelStubs\Tests\TestCase;

class PolicyMakeCommandTest extends TestCase
{
    protected array $files = [
        'app/Policies/FooPolicy.php',
    ];

    public function test_it_can_generate_policy_file(): void
    {
        $this->artisan('make:policy', ['name' => 'FooPolicy'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Policies;',
            'use Illuminate\Foundation\Auth\User;',
            'class FooPolicy',
        ], 'app/Policies/FooPolicy.php');

        $this->assertFileNotContains([
            'Create a new policy instance.',
            'public function __construct()',
        ], 'app/Policies/FooPolicy.php');
    }

    public function test_it_can_generate_policy_file_with_model_option(): void
    {
        $this->artisan('make:policy', ['name' => 'FooPolicy', '--model' => 'Post'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Policies;',
            'use App\Models\Post;',
            'use Illuminate\Foundation\Auth\User;',
            'class FooPolicy',
            'public function viewAny(User $user)',
            'public function view(User $user, Post $post)',
            'public function create(User $user)',
            'public function update(User $user, Post $post)',
            'public function delete(User $user, Post $post)',
            'public function restore(User $user, Post $post)',
            'public function forceDelete(User $user, Post $post)',
        ], 'app/Policies/FooPolicy.php');

        $this->assertFileNotContains([
            'Determine whether the user can view any models.',
            'Determine whether the user can view the model.',
            'Determine whether the user can create models.',
            'Determine whether the user can update the model.',
            'Determine whether the user can delete the model.',
            'Determine whether the user can restore the model.',
            'Determine whether the user can permanently delete the model.',
        ], 'app/Policies/FooPolicy.php');
    }
}
