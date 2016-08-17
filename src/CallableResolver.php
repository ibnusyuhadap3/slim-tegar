<?php
namespace IS\Slim\Tegar; 

use Slim\Interfaces\CallableResolverInterface;

/**
 * Resolve middleware and route callables using PHP-DI.
 * Originally inspired by http://php-di.org/doc/frameworks/slim.html
 */
class CallableResolver implements CallableResolverInterface
{
    /**
     * @var \Invoker\CallableResolver
     */
    private $callableResolver;

    public function __construct(\Invoker\CallableResolver $callableResolver)
    {
        $this->callableResolver = $callableResolver;
    }

    /**
     * {@inheritdoc}
     */
    public function resolve($toResolve)
    {
        return $this->callableResolver->resolve($toResolve);
    }
}
