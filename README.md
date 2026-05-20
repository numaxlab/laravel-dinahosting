# Laravel Dinahosting

Laravel utilities for projects hosted on [Dinahosting](https://dinahosting.com) shared hosting.

## Requirements

- PHP ^8.2
- Laravel 10+

## Installation

```bash
composer require numaxlab/laravel-dinahosting
```

The service provider is registered automatically via Laravel's package auto-discovery.

## Commands

### Symlink

Dinahosting shared hosting exposes a `www/` directory as the web root instead of the standard `public/` directory. This command creates a symlink from `../www` to `public/` so your Laravel application is served correctly.

```bash
php artisan dinahosting:symlink
```

Run this once after deploying your application to the server for the first time.

### Envoy

Installs [Laravel Envoy](https://laravel.com/docs/envoy) as a dev dependency and scaffolds an `Envoy.blade.php` file pre-configured for Dinahosting deployments.

```bash
php artisan dinahosting:envoy-setup
```

Use `--force` to overwrite an existing `Envoy.blade.php` without being prompted:

```bash
php artisan dinahosting:envoy-setup --force
```

After running the command, edit the generated `Envoy.blade.php` to set your server credentials and project directory, then run your first deploy:

```bash
php vendor/bin/envoy run dinahosting-deploy
```

The generated Envoy task pulls the latest code from `main`, installs Composer dependencies (without dev packages), runs `package:discover`, and executes pending migrations — using Dinahosting's custom PHP binary path (`$HOME/.bin/php`).

## License

MIT — see [LICENSE](LICENSE).