# Router

## Installation

You can install this package via [packagist.org](https://packagist.org/packages/systream/router) with [composer](https://getcomposer.org/).

`composer require systream/router`

composer.json:

```json
"require": {
    "systream/router": "1.*"
}
```

This library requires `php 5.6` or higher, but also works on php 5.4.

## Usage

### Setup routing

```php
$route = new Router();
$route->addRoute(new SimpleRouting('/foo', new TestController()));
$route->addRoute(new SimpleRouting('/foo/{id}', new TestController2()));
$route->addRoute(new PathBasedRouting('app/Controller/Api', '\MyAppNamespace\Controller\Api'));
$route->addRoute(new FinalMatchRouting(new NotFoundController()));
$serverRequest = ServerRequestFactory::fromGlobals();
$route->dispatch($serverRequest, new SapiEmitter());

```

## Test

[![Build Status](https://travis-ci.org/systream/router.svg?branch=master)](https://travis-ci.org/systream/router)

