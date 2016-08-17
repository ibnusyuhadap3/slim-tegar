<?php
namespace IS\Slim\Tegar;

use IS\Slim\Tegar\Exceptions\EmptyDirectoryException;
use IS\Slim\Tegar\Exceptions\NotFoundDefaultConfigurationFolder;

/**
 * 
 * @author Ibnu Syuhada
 *
 */
class Configuration
{
	private $show;
	
	/**
	 * 
	 * @param string $path
	 */
	public function __construct($path)
	{
		// first make sure defaultConfiguration folder is exists
		$defaultConfiguration = __DIR__ . "/defaultConfiguration";
		if(!file_exists( $defaultConfiguration ))
		{
			throw new NotFoundDefaultConfigurationFolder(
					"Sorry, we can't find defaultConfiguration folder :"
					. __DIR__ . "/defaultConfiguration"
				);
		}
		
		$defaultFiles = $this->readPath( $defaultConfiguration );
		$additionalFiles = $this->readPath($path);
		$files = array_merge($defaultFiles,$additionalFiles);
		$conf = $this->readConfigFiles($files);
		$this->show = $conf; 
	}
	
	/**
	 * @return array
	 */
	public function show()
	{
		return $this->show;
	}
	
	/**
	 * 
	 * @param string $path
	 * @throws EmptyDirectoryException
	 */
	private function readPath($path)
	{
		if (is_dir($path)) {
			$info = new \SplFileInfo($path);
			$foldername = $info->getBasename();
			$paths = glob($path . '/*.php');
			if (empty($paths) && $foldername == "defaultConfiguration") {
				throw new EmptyDirectoryException("There is no any files of configuration : " . $path );
			}
			return $paths;
		}
		return [];
	}
	
	/**
	 * 
	 * @param array $files
	 */
	private function readConfigFiles(array $files = array())
	{
		$result = [];
		$arr = [];
		foreach ($files as $file) {
			$info = new \SplFileInfo($file);
			$temp = $info->getExtension() == "php" ? require $file : "";
			if (is_array($temp))
			{
				$result = array_replace_recursive($arr,$temp);
			}
			$arr = $result;
		}
		$arr = "";
		return $result;
	}
}