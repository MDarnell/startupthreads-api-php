Startup Threds API
=================

Very simple and easy StartupThreads API wrapper, for PHP.

Complex wrappers are for noobs. This lets you access the StartupThreads API using the docs as directly as possible.

Requires PHP 5.3.

Installation
------------

You can install the startupthreads-api-php using [Composer](https://getcomposer.org/). Just add the following to your `composer.json`:

    {
        "require": {
            "startupthreads/startupthreads-api-php": "dev-master"
        }
    }

You will then need to:
* run `composer install` to get these dependencies added to your vendor directory
* add the Composer autoloader to your application with this line: `require("vendor/autoload.php")`

Examples (TODO: Update Examples)
--------

List items (/items.json method)

```php
$st = new StartupThreads('api-token-here');
print_r($st->get('items.json'));
```
