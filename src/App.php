<?php
namespace IS\Slim\Tegar;

/**
 * Slim Tegar is Slim Framework and PHP-DI integration advanced
 * Slim Tegar is inspired by http://php-di.org/doc/frameworks/slim.html
 * The purpose of this package is to break the extends class of
 * \DI\Bridge\Slim\App
 * What you need is only register the dependencies injection in a 
 * configuration directory.
 * 
 * @author Ibnu Syuhada
 *
 */
class App extends \Slim\App
{
	use AppTraits;
	
	/**
	 * Container
	 * 
	 * @var ContainerInterface
	 */
	private $container;
	
	/**
	 * Start new Slim application
	 * 
	 * @param string $path
	 */
	public function __construct($path = "")
	{
		$definitions = $this->addConfiguration($path);
		$containing = new Container($definitions);
		$container = $containing->buildContainer();
		parent::__construct($container);
		$this->container = $this->getContainer();
	}
}