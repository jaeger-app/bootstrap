# Jaeger Bootstrap Object

A per-configured dependency injection container and start-up initialization object. Jaeger Bootstrap will prepare the below Jaeger objects and make them ready for use:

1. Db
2. Email
3. Encrypt
4. Exceptions
5. Files
6. Language
7. License
8. Regex
9. Settings
10. Shell
11. View
12. Validate

## Installation
Add `jaeger-app/bootstrap` as a requirement to your `composer.json`:

```bash
$ composer require jaeger-app/bootstrap
```

## Simple Example


```php
use \JaegerApp\Bootstrap;

$bootstrap = new Bootstrap();

//get the services
$services = $bootstrap->getServices();

//db service
$db = $services['db'];

```