<p align="center">
<a href="https://github.com/TheOrchid/Platform"><img width="250"  src="https://orchid.software/img/orchid.svg">
</a>
</p>

<p align="center">
<a href="https://www.paypal.me/tabuna/10usd"><img src="https://img.shields.io/badge/Donate-PayPal-green.svg"></a>
<a href="https://github.com/chiraggude/awesome-laravel#starter-projects"><img src="https://cdn.rawgit.com/sindresorhus/awesome/d7305f38d29fed78fa85652e3a63e154dd8e8829/media/badge.svg"></a>
<a href="https://styleci.io/repos/73781385"><img src="https://styleci.io/repos/73781385/shield?branch=master"/></a>
<a href="https://packagist.org/packages/orchid/platform"><img src="https://poser.pugx.org/orchid/platform/v/stable"/></a>
<a href="https://packagist.org/packages/orchid/platform"><img src="https://poser.pugx.org/orchid/platform/downloads"/></a>
<a href="https://packagist.org/packages/orchid/platform"><img src="https://poser.pugx.org/orchid/platform/license"/></a>
</p>

## Official Documentation

Documentation can be found at [Orchid website](http://orchid.software).

You can watch [live](http://demo.orchid.software)

**Login**: admin@admin.com **Password**: password


## System requirements

Make sure your server meets the following requirements.

- MySQL Server 5.7.8+ or PostgreSQL
- PHP Version 7.0+

## Install

#### Via Composer

Going your project directory on shell and run this command: 
```php
$ composer require orchid/cms
```

#### User

Inherit your model App\User

```php
namespace App;

use Orchid\Platform\Core\Models\User as UserOrchid;

class User extends UserOrchid
{

}

```

#### Finish


> **Go to url:**  localhost:8000/dashboard

The graphical installation does not work if the server is started using the `artisan serve` command, if you want to use a local server, please go to the public directory and run
```php
php -S localhost:8000
```


## Contributing

1. Fork it!
2. Create your feature branch: `git checkout -b my-new-feature`
3. Commit your changes: `git commit -am 'Add some feature'`
4. Push to the branch: `git push origin my-new-feature`
5. Submit a pull request :D


## Credits

- [Alexandr Chernyaev](https://github.com/tabuna)
- [All Contributors](../../contributors)


## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
