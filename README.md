# Laravel Stubs

<p align="center">
  <a href="https://github.com/Kerigard/laravel-stubs/actions"><img src="https://github.com/Kerigard/laravel-stubs/workflows/Tests/badge.svg" alt="Build Status"></a>
  <a href="https://packagist.org/packages/Kerigard/laravel-stubs"><img src="https://img.shields.io/packagist/dt/Kerigard/laravel-stubs" alt="Total Downloads"></a>
  <a href="https://packagist.org/packages/Kerigard/laravel-stubs"><img src="https://img.shields.io/packagist/v/Kerigard/laravel-stubs" alt="Latest Stable Version"></a>
  <a href="https://packagist.org/packages/Kerigard/laravel-stubs"><img src="https://img.shields.io/packagist/l/Kerigard/laravel-stubs" alt="License"></a>
</p>

Custom Laravel stubs without unnecessary PHPDoc blocks and with improved type hints.

The package automatically replaces Laravel's default stubs. No configuration or manual publishing is required.

## Requirements

* PHP ^8.3
* Laravel ^13.0

## Installation

```bash
composer require --dev kerigard/laravel-stubs
```

The package is automatically discovered by Laravel.

## Usage

Use Laravel's standard generators as usual:

```bash
php artisan make:model Post
php artisan make:controller PostController
php artisan make:request StorePostRequest
```

The generated classes will use the package's stubs.

To publish the stubs to your application's `stubs/` directory for further customization:

```bash
php artisan stub:publish
```

## License

MIT
