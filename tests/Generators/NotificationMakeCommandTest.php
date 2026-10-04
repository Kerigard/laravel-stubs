<?php

namespace Kerigard\LaravelStubs\Tests\Generators;

use Kerigard\LaravelStubs\Tests\TestCase;

class NotificationMakeCommandTest extends TestCase
{
    protected array $files = [
        'app/Notifications/FooNotification.php',
        'resources/views/foo-notification.blade.php',
        'resources/views/mail/foo-notification.blade.php',
        'tests/Feature/Notifications/FooNotificationTest.php',
    ];

    public function test_it_can_generate_notification_file(): void
    {
        $this->artisan('make:notification', ['name' => 'FooNotification'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Notifications;',
            'use Illuminate\Notifications\Notification;',
            'class FooNotification extends Notification',
            'return (new MailMessage)',
        ], 'app/Notifications/FooNotification.php');

        $this->assertFileNotContains([
            'Create a new notification instance.',
            "Get the notification's delivery channels.",
            'Get the mail representation of the notification.',
            'Get the array representation of the notification.',
        ], 'app/Notifications/FooNotification.php');

        $this->assertFilenameNotExists('resources/views/foo-notification.blade.php');
        $this->assertFilenameNotExists('tests/Feature/Notifications/FooNotificationTest.php');
    }

    public function test_it_can_generate_notification_file_with_markdown_option(): void
    {
        $this->artisan('make:notification', ['name' => 'FooNotification', '--markdown' => 'foo-notification'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Notifications;',
            'class FooNotification extends Notification',
            "return (new MailMessage)->markdown('foo-notification')",
        ], 'app/Notifications/FooNotification.php');

        $this->assertFileNotContains([
            'Create a new notification instance.',
            "Get the notification's delivery channels.",
            'Get the mail representation of the notification.',
            'Get the array representation of the notification.',
        ], 'app/Notifications/FooNotification.php');

        $this->assertFileContains([
            '<x-mail::message>',
        ], 'resources/views/foo-notification.blade.php');
    }

    public function test_it_can_generate_notification_file_with_markdown_option_without_value(): void
    {
        $this->artisan('make:notification', ['name' => 'FooNotification', '--markdown' => null])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Notifications;',
            'class FooNotification extends Notification',
            "return (new MailMessage)->markdown('mail.foo-notification')",
        ], 'app/Notifications/FooNotification.php');

        $this->assertFileNotContains([
            'Create a new notification instance.',
            "Get the notification's delivery channels.",
            'Get the mail representation of the notification.',
            'Get the array representation of the notification.',
        ], 'app/Notifications/FooNotification.php');

        $this->assertFileContains([
            '<x-mail::message>',
        ], 'resources/views/mail/foo-notification.blade.php');
    }

    public function test_it_can_generate_notification_file_with_test(): void
    {
        $this->artisan('make:notification', ['name' => 'FooNotification', '--test' => true])
            ->assertExitCode(0);

        $this->assertFileNotContains([
            'A basic feature test example.',
        ], 'tests/Feature/Notifications/FooNotificationTest.php');

        $this->assertFilenameExists('app/Notifications/FooNotification.php');
        $this->assertFilenameNotExists('resources/views/foo-notification.blade.php');
    }
}
