Sucre/Session
===============

Sucre/Session is simple loosely-coupled PHP $\_SESSION wrapper.

## Requirement
--------------------

* PHP 5.4 or later

## Installation
--------------------

Download the [`composer.phar`](http://getcomposer.org/composer.phar).

``` sh
$ curl -s http://getcomposer.org/installer | php
```

Run Composer: `php composer.phar require "cyrill/sucre-session"`

## Usage
--------------------
```php
<?php
reqire __DIR__.'/composer/autoload.php';

use Sucre\Session;

Session::init($regenerate = true); // start session

Session::set('foo', 'bar'); // $_SESSION['foo'] = 'bar';
Session::get('foo'); // returns 'bar'

Session::setFlash('foofoo', 'barbar');
Session::getFlash('foofoo'); // returns 'barbar'

Session::generateId();
Session::destroy();
```

## How to test?
-------------------

Sucre\Session is tested by PHPUnit.

Run composer `composer install --dev`.
All you have to do is to run `phpunit`.

## License
--------------------
The MIT License
