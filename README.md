# Jaeger Bootstrap Object

A pre-configured dependency injection container and start-up initialization object. Jaeger Bootstrap will prepare the most common Jaeger objects and make them ready for use.

## Installation
Add `jaeger-app/bootstrap` as a requirement to your `composer.json`:

```bash
$ composer require jaeger-app/bootstrap
```

## Simple Example


```php
use \JaegerApp\Bootstrap;

$bootstrap = new Bootstrap();

//get all the services
$services = $bootstrap->getServices();

//get a specific service
$db = $services['db']; 

//or ger specific service directly
$db = $bootstrap->getService('db');

```