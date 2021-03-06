php-router
========================

A small routing library for php that decouples controllers from routing.
The routing table only acts as a translation table between paths and intentions.

# Installation

Install via composer. Installation help and versions at [Packagist](https://packagist.org/packages/tailored-tunes/php-router)

# Usage

## Set up routes

```php
use TailoredTunes\Router;

$router = new Router();
$router->addRoutes(
	[
		["/" => "Home#index"],
		["/login" => "Home#login"],
		["/logout" => "Home#logout"],
		["/privacy" => "Home#privacy"],
		["/magic/:var1/:var2" => "Home#magic"]
    ]
);
```

### Variables in paths

You can match path variables by adding `:var` notions to the route table, as above.
Those parameters will translate to the respective variable name in the parameters array of the handler.

## Handle routes

The reason behind not handling the request internally is that you might
want to put a controller factory between the routing and the serving.
This way the router only tells you what the _intention_ of the route was,
then it's up to you to map it to a controller.

```php
// $uri = the request uri
// $method = the request method
// $params = parameters for the request.

$requestParamBuilder = new RequestParamBuilder();
$requestParamBuilder->withEnv($_ENV)
	->withRequest($_REQUEST)
	->withCookies($_COOKIE)
	->withFiles($_FILES)
	->withServer($_SERVER)
	->withSession($_SESSION);

$params = new RequestParams($requestParamBuilder);

$handler = $router->handle($uri, $method, $params);

// serve request
call_user_func_array(array($handler->controller(), $handler->action()), $handler->parameters());

```
