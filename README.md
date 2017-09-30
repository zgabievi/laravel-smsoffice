# laravel-smsoffice

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![StyleCI][ico-styleci]][link-styleci]
[![Total Downloads][ico-downloads]][link-downloads]

Custom driver, [SMSOffice](http://smsoffice.ge/), integration for [Laravel Notifications](https://laravel.com/docs/5.5/notifications)

## Table of Contents

- [Install](#install)
    - [Configuration](#configuration)
- [Usage](#usage)
- [Changelog](#changelog)
- [Testing](#testing)
- [Contributing](#contributing)
- [Security](#security)
- [Credits](#credits)
- [License](#license)

## Install

Via Composer

```bash
$ composer require zgabievi/laravel-smsoffice
```

If you do not run Laravel 5.5 (or higher), then follow next step:

```php
// config/app.php
'providers' => [
    ...
    Gabievi\LaravelSMSOffice\SMSOfficeServiceProvider::class,
],
```

If you do run the package on Laravel 5.5+, [package auto-discovery](https://medium.com/@taylorotwell/package-auto-discovery-in-laravel-5-5-ea9e3ab20518) takes care of the magic of adding the service provider.

Optional you can publish the configuration to provide an own service provider stub.

```bash
php artisan vendor:publish --provider="Gabievi\LaravelSMSOffice\SMSOfficeServiceProvider"
```

### Configuration

```php
// config/services.php
...
'smsoffice' => [
    'key'  => env('SMSOFFICE_KEY'),
    'sender' => 'JOHN'
],
...
```

## Usage

You can use the channel in your via() method inside the notification:

``` php
use Illuminate\Notifications\Notification;
use Gabievi\LaravelSMSOffice\SMSOfficeMessage;
use Gabievi\LaravelSMSOffice\SMSOfficeChannel;

class Welcome extends Notification
{
    //
    public function via($notifiable)
    {
        return [SMSOfficeChannel::class];
    }

    //
    public function toSMSOffice($notifiable)
    {
        return SMSOfficeMessage::create('Welcome to the real world!');
    }
}
```

In your notifiable model, make sure to include a routeNotificationForSmsoffice() method, which return the phone number.

```php
//
public function routeNotificationForSmsoffice()
{
    return $this->phone;
}
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email zura.gabievi@gmail.com instead of using the issue tracker.

## Credits

- [Zura Gabievi][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/zgabievi/laravel-smsoffice.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/zgabievi/laravel-smsoffice/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/zgabievi/laravel-smsoffice.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/zgabievi/laravel-smsoffice.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/105359139/shield
[ico-downloads]: https://img.shields.io/packagist/dt/zgabievi/laravel-smsoffice.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/zgabievi/laravel-smsoffice
[link-travis]: https://travis-ci.org/zgabievi/laravel-smsoffice
[link-scrutinizer]: https://scrutinizer-ci.com/g/zgabievi/laravel-smsoffice/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/zgabievi/laravel-smsoffice
[link-styleci]: https://styleci.io/repos/105359139
[link-downloads]: https://packagist.org/packages/zgabievi/laravel-smsoffice
[link-author]: https://github.com/zgabievi
[link-contributors]: ../../contributors
