# Jaeger Bootstrap Object

[![Build Status](https://travis-ci.org/jaeger-app/bootstrap.svg?branch=master)](https://travis-ci.org/jaeger-app/bootstrap)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/jaeger-app/bootstrap/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/jaeger-app/bootstrap/?branch=master)
[![Author](http://img.shields.io/badge/author-@mithra62-blue.svg?style=flat-square)](https://twitter.com/mithra62)
[![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg)](https://raw.githubusercontent.com/jaeger-app/bootstrap/master/LICENSE)

A pre-configured dependency injection container and start-up initialization object. Jaeger Bootstrap will prepare the most common Jaeger objects and make them ready for use as well as function as a stand alone dependency injection container utilizing [Pimple\Container](https://packagist.org/packages/pimple/pimple).

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

## Configured Services

`Jaeger\Bootstrap` sets up quite a few Jaeger objects and makes them ready for use. 

```php
use \JaegerApp\Bootstrap;
$bootstrap = new Bootstrap();
$db = $bootstrap->getService('db');
$email = $bootstrap->getService('email');
$encrypt = $bootstrap->getService('encrypt');
$lang = $bootstrap->getService('lang');
$validate = $bootstrap->getService('validate');
$files = $bootstrap->getService('files');
$view = $bootstrap->getService('view');
$shell = $bootstrap->getService('shell');
$console = $bootstrap->getService('console');

```

## Adding Services

Ideally, like all Jaeger classes, you should extend `Jaeger\Bootstrap` and initialize the parent services before adding your own like the below:

```php
use \JaegerApp\Bootstrap;

class MyBootstrap extends Bootstrap
{
    public function getServices()
    {
        $this->container = parent::getServices(); //init existing services
		
		//add new service
        $this->container['my_service'] = function ($c) {
            $settings = new NewService;
            return $settings;
        };

		return $this->container;
    }
}
```

You can also add new Services at run time by using the `setService($name, \Closure $function)` method. 


```php
use \JaegerApp\Bootstrap;

$bootstrap = new Bootstrap();
$callable = function() {
    return 'foo to the who';
};

$bootstrap->setService('test_service', $callable);
```