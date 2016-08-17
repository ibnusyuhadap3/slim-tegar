<?php
use IS\Slim\Tegar\CallableResolver;
use IS\Slim\Tegar\ControllerInvoker;
use DI\Container;
use Interop\Container\ContainerInterface;
use Invoker\Invoker;
use Invoker\ParameterResolver\AssociativeArrayResolver;
use Invoker\ParameterResolver\Container\TypeHintContainerResolver;
use Invoker\ParameterResolver\DefaultValueResolver;
use Invoker\ParameterResolver\ResolverChain;
use Slim\Http\Headers;
use Slim\Http\Request;
use Slim\Http\Response;
use function DI\get;
use function DI\object;

return [

    // Default Slim services
    'router' => object(Slim\Router::class),
    'errorHandler' => object(Slim\Handlers\Error::class)
        ->constructor(get('settings.displayErrorDetails')),
    'phpErrorHandler' => object(Slim\Handlers\PhpError::class)
        ->constructor(get('settings.displayErrorDetails')),
    'notFoundHandler' => object(Slim\Handlers\NotFound::class),
    'notAllowedHandler' => object(Slim\Handlers\NotAllowed::class),
    'environment' => function () {
        return new Slim\Http\Environment($_SERVER);
    },
    'request' => function (ContainerInterface $c) {
        return Request::createFromEnvironment($c->get('environment'));
    },
    'response' => function (ContainerInterface $c) {
        $headers = new Headers(['Content-Type' => 'text/html; charset=UTF-8']);
        $response = new Response(200, $headers);
        return $response->withProtocolVersion($c->get('settings')['httpVersion']);
    },
    'foundHandler' => object(ControllerInvoker::class)
        ->constructor(get('foundHandler.invoker')),
    'foundHandler.invoker' => function (ContainerInterface $c) {
        $resolvers = [
            // Inject parameters by name first
            new AssociativeArrayResolver,
            // Then inject services by type-hints for those that weren't resolved
            new TypeHintContainerResolver($c),
            // Then fall back on parameters default values for optional route parameters
            new DefaultValueResolver(),
        ];
        return new Invoker(new ResolverChain($resolvers), $c);
    },

    'callableResolver' => object(CallableResolver::class),

    // Aliases
    ContainerInterface::class => get(Container::class),

];
