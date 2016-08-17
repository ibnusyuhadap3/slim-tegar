<?php
namespace IS\Slim\Tegar;

use DI\ContainerBuilder;

/**
 * 
 * @author Ibnu Syuhada
 *
 */
class Container extends ContainerBuilder
{
	/**
	 * Start container PHP-DI
	 * 
	 * @param array $definitions
	 */
	public function __construct($definitions)
	{
		parent::__construct('DI\Container');
		$this->addDefinitions($definitions);
	}
	
	/**
	 * build container PHP-DI
	 */
	public function buildContainer()
	{
		return $this->build();
	}	
}