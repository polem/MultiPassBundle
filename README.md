# MultiPassBundle

Symfony Bundle for Multipass library.


## Dependencies

* PHP 5.3.x
* Official OAuth extension (<http://pecl.php.net/oauth>)
* oauth2-php (<https://github.com/Keeguon/oauth2-php>)
* Multipass (<https://github.com/Keeguon/Multipass>)

## Installation

### composer

To install MultiPassBundle with composer you simply need to create a composer.json in your project root and add:

```json
{
    "require": {
        "multipass/multipassBundle": ">=1.0.0"
    }
}
```

Then run

```bash
$ wget -nc http://getcomposer.org/composer.phar
$ php composer.phar install
```

