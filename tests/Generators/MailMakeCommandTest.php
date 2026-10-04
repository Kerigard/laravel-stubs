<?php

namespace Kerigard\LaravelStubs\Tests\Generators;

use Kerigard\LaravelStubs\Tests\TestCase;

class MailMakeCommandTest extends TestCase
{
    protected array $files = [
        'app/Mail/FooMail.php',
        'resources/views/foo-mail.blade.php',
        'resources/views/mail/*.blade.php',
        'tests/Feature/Mail/FooMailTest.php',
    ];

    public function test_it_can_generate_mail_file(): void
    {
        $this->artisan('make:mail', ['name' => 'FooMail'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Mail;',
            'use Illuminate\Mail\Mailable;',
            'class FooMail extends Mailable',
            'use Queueable;',
            'use SerializesModels;',
        ], 'app/Mail/FooMail.php');

        $this->assertFileNotContains([
            'Create a new message instance.',
            'Get the message envelope.',
            'Get the message content definition.',
            'Get the attachments for the message.',
        ], 'app/Mail/FooMail.php');

        $this->assertFilenameNotExists('resources/views/foo-mail.blade.php');
        $this->assertFilenameNotExists('tests/Feature/Mail/FooMailTest.php');
    }

    public function test_it_can_generate_mail_file_with_markdown_option(): void
    {
        $this->artisan('make:mail', ['name' => 'FooMail', '--markdown' => 'foo-mail'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Mail;',
            'use Illuminate\Mail\Mailable;',
            'class FooMail extends Mailable',
            'use Queueable;',
            'use SerializesModels;',
            'return new Content(',
            "markdown: 'foo-mail',",
        ], 'app/Mail/FooMail.php');

        $this->assertFileContains([
            '<x-mail::message>',
            '<x-mail::button :url="\'\'">',
            '</x-mail::button>',
            '</x-mail::message>',
        ], 'resources/views/foo-mail.blade.php');

        $this->assertFileNotContains([
            'Create a new message instance.',
            'Get the message envelope.',
            'Get the message content definition.',
            'Get the attachments for the message.',
        ], 'app/Mail/FooMail.php');
    }

    public function test_it_can_generate_mail_file_with_view_option(): void
    {
        $this->artisan('make:mail', ['name' => 'FooMail', '--view' => 'foo-mail'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Mail;',
            'use Illuminate\Mail\Mailable;',
            'class FooMail extends Mailable',
            'use Queueable;',
            'use SerializesModels;',
            'return new Content(',
            "view: 'foo-mail',",
        ], 'app/Mail/FooMail.php');

        $this->assertFileNotContains([
            'Create a new message instance.',
            'Get the message envelope.',
            'Get the message content definition.',
            'Get the attachments for the message.',
        ], 'app/Mail/FooMail.php');

        $this->assertFilenameExists('resources/views/foo-mail.blade.php');
    }

    public function test_it_can_generate_mail_file_with_test(): void
    {
        $this->artisan('make:mail', ['name' => 'FooMail', '--test' => true])
            ->assertExitCode(0);

        $this->assertFileNotContains([
            'A basic feature test example.',
        ], 'tests/Feature/Mail/FooMailTest.php');

        $this->assertFilenameExists('app/Mail/FooMail.php');
        $this->assertFilenameNotExists('resources/views/foo-mail.blade.php');
    }
}
