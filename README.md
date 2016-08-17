# Slim Tegar

Slim Tegar is a package that designed for integrating PHP-DI and Slim Framework version 3.x.x. This package is an [Slim Bridge](http://php-di.org/doc/frameworks/slim.html) advanced. You don't need to exteds just to make container configuration. Slim Tegar also providing the easy way to implement Closure and MVC routes.


## Requirement

Slim Tegar requires PHP-DI and SlimFramework version 3.x.x.


## Installation

Install Slim Tegar can do via Composer:
```
composer require ibnusyuhada/slim-tegar
```

## Usage

Basically, Slim Tegar is replacing original container of Slim ([Pimple](http://pimple.sensiolabs.org/)) with [PHP-DI](http://php-di.org/). You don't need to extend any class just for configuration dependencies. Some advance usage has been added to polish up original integration in http://php-di.org/doc/frameworks/slim.html.

### Basic Usage

Slim Tegar usage is simple and easy. Initially, create an example project, let say **slimtegar**. Then install Slim Tegar inside that. After that, create *index.php* with the following simple code:

```
<?php

require_once __DIR__ . '/vendor/autoload.php';

// call Slim Tegar
$app = new IS\Slim\Tegar\App();

// register route with Closure
$app->get("/", function($response){
    $response->write("Welcome to Slim!");
    return $response;
});

// run Slim
$app->run();
```

### Basic Usage Controller

When you want to implement MVC pattern, Slim Tegar providing the simple way to register all controllers. First, add the following code before `$app->run()` method:

```
// register route in MVC pattern
// just say the namespace controller and method
$app->get("/example", "App\Controllers\ExampleController@index");
```

second, open *composer.json* then put the code below:

```
{
	"autoload":
	{
		"psr-4": {
			"App\\Controllers\\": "controllers"
		}
	}
}
```

don't forget to **dumpautoload** for register this namespace in composer. Third, create a directory inside **slimtegar** project with **controllers** as the name. Then create *ExampleController.php* file  inside **controllers** directory with the following code:

```
<?php
namespace App\Controllers;

class ExampleController
{
	public function index($response)
	{
		$response->write("Controller example with index as method");
		return $response;
	}
}
```

fourth, open your lovely browser, and access URI *example*.


## Configurations

In Slim Tegar, configuration was made easy. You don't need to extends any class of Slim or PHP-DI. What you need just create a directory, then put all your configuration files inside it. Basically, Slim Tegar has mandatory configuration directory. The name of the directory is **defaultConfiguration**. Inside there, you will see two files: *defaultConfiguration.php* and *settings.php*. The meaning of *settings.php* is same definition like in Slim (see [http://www.slimframework.com/docs/tutorial/first-app.html]) and PHP-DI (see [http://php-di.org/doc/frameworks/slim.html]). In updating settings, however, you don't need to touch these files. What you need just create another directory in your project, let say the name is **config**, then create a php file inside there. Let we give the name of that file as *config.php* then give the following code:

```
<?php
return [
    'settings' => [
			'displayErrorDetails' => false,
    		'ibnu' => 'syuhada'
	]
];
```

the code above will update `displayErrorDetails` and add new item of settings. After that, tell Slim Tegar where the config directory is placed. Here the example code inside *index.php*

```
<?php
require_once __DIR__ . '/vendor/autoload.php';

// call Slim Tegar
$path = __DIR__ . '/config';
$app = new IS\Slim\Tegar\App($path);

// register route with Closure
$app->get("/", function($response){
    $response->write("Welcome to Slim!");
    return $response;
});

// run Slim
$app->run();
```

## Add Dependencies

If you want to add another dependencies, however, just create a file returning an array (see http://php-di.org/doc/php-definitions.html), then put that file in **config** directory, after that Slim Tegar will register the dependencies automatically for you. As example, let say we want to use **Slim-Twig**. First, install Twig for Slim:

```
composer require slim/twig-view
```

Second, create a file returning an array inside **config** directory. Let say the name of that file is *view.php*. Then give the following code in that file:

```
<?php

return [
	\Slim\Views\Twig::class => function (Interop\Container\ContainerInterface $c) {
		$twig = new \Slim\Views\Twig('views', [
                    'cache' => 'cache'
                ]);
		$twig->addExtension(
					new \Slim\Views\TwigExtension(
							$c->get('router'), 
							$c->get('request')->getUri()
					)
				);
        return $twig;
    }
];
```

Third, inject the Twig service in controllers or closure. Below is the example:

```
$app->get('/', function ($response, Twig $twig) {
	return $twig->render($response, 'home.twig');
});
```

don't forget to create *home.twig* file by your self.


## What Next?

Everything what you need to use Slim Tegar is just follow [SlimFramework Documentation](http://www.slimframework.com/docs/). The different now is how the way you use dependency injection container. You are not using Pimple anymore, but PHP-DI. So, read more documentation about [PHP-DI Documentations](http://php-di.org/doc/) for advance usage. For more understanding, see the example usage inside Slim Tegar package.


## Credits

[Ibnu Syuhada](https://github.com/ibnusyuhadap3)


## License

The MIT [License](https://github.com/ibnusyuhadap3/slim-tegar/blob/master/LICENSE.md).
