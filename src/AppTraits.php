<?php
namespace IS\Slim\Tegar;

/**
 * 
 * @author Ibnu Syuhada
 *
 */
trait AppTraits {
	
	/**
	 * Redefinition of Slim map route
	 * 
	 * @param  string[] $methods  Numeric array of HTTP method names
     * @param  string   $pattern  The route URI pattern
     * @param  callable|string    $callable The route callback routine
     * 
     * @return RouteInterface
	 */
	public function map(array $methods, $pattern, $callable)
    {
    	if ( is_string($callable) ) $callable = explode("@", $callable);

    	if ($callable instanceof Closure) {
        	$callable = $callable->bindTo($this->container);
        }
        
        $route = $this->container->get('router')->map($methods, $pattern, $callable);
        
        if (is_callable([$route, 'setContainer'])) {
            $route->setContainer($this->container);
        }

        if (is_callable([$route, 'setOutputBuffering'])) {
            $route->setOutputBuffering($this->container->get('settings')['outputBuffering']);
        }
        
        return $route;
    }
	
	/**
	 * Set folder path of configuration files
	 * 
	 * @param string $path
	 * @return array
	 */
	public function addConfiguration($path="")
	{
		$conf = new Configuration($path);
		return $conf->show();
	}
}